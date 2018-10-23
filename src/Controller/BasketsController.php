<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\JsonResponse;
use \Symfony\Component\HttpFoundation\Response;
use \App\Services\BasketService;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use \Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;


class BasketsController extends AbstractController
{
    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var BasketService
     */
    protected $basketService;

    /**
     * @var ValidatorInterface
     */
    protected $validator;


    protected $violations = [];


    public function __construct(Serializer $serializer, BasketService $basketService, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->basketService = $basketService;
        $this->validator = $validator;
    }

    /**
     * @Route("/baskets", methods={"GET"})
     */
    public function indexAction()
    {
        $baskets = $this->basketService->getBasketsList();

        return new JsonResponse([
            'baskets' => $this->serializer->serialize($baskets, 'json', ['attributes' => array('name', 'capacity')])
        ]);
    }

    /**
     * @Route("/baskets/{id}", requirements={"id" = "\d+"}, methods={"GET"})
     */
    public function viewBasketAction($id)
    {
        $basket = $this->basketService->findBasket($id);

        return new JsonResponse([
            'basket' => $this->serializer->serialize($basket, 'json')
        ]);
    }

    /**
     * @Route("/baskets", methods={"POST"})
     */
    public function createBasketAction(Request $request)
    {
        try {

            $basket = $this->basketService->createBasket(
                $request->get('name'),
                $request->get('capacity'),
                $request->get('items')
            );

        }catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }

        return new JsonResponse([
            'basket' => $this->serializer->serialize($basket, 'json')
        ], Response::HTTP_CREATED);
    }

    /**
     * @Route("/baskets/{id}", requirements={"id" = "\d+"}, methods={"PATCH"})
     */
    public function updateBasketAction($id, Request $request)
    {
        $params = (array)$request->request->all();

        try {

            $this->basketService->updateBasket($id, $params);

        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }

        return new JsonResponse([], Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/baskets/{id}", requirements={"id" = "\d+"}, methods={"DELETE"})
     */
    public function deleteBasketAction($id)
    {
        try {

            $delete = $this->basketService->removeBasket($id);

        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/baskets/{id}/item/{itemIndex}", requirements={"id" = "\d+", "itemIndex" = "\d+"}, methods={"DELETE"})
     */
    public function deleteItemAction($id, $itemIndex)
    {
        try {

            $removed = $this->basketService->removeBasketItem($id, $itemIndex);

        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }

    protected function exceptionResponse(\Exception $e)
    {
        throw new HttpException(400, "New comment is not valid.");

        return new JsonResponse([
            'errors' => 1,
            'message' => $e->getMessage()
        ], Response::HTTP_OK);
    }
}

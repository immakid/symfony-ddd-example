<?php

namespace App\Services;

use App\Domain\BasketRepositoryInterface;
use App\Domain\VO\BasketCapacity;
use App\Domain\VO\BasketName;
use App\Domain\VO\ItemType;
use App\Entity\Item;
use App\Helper\Arrays;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Basket;
use Rhumsaa\Uuid\Uuid;

/**
 * Class BasketService
 * @package App\Services
 */
class BasketService
{

    public function __construct(BasketRepositoryInterface $basketRepository)
    {
        $this->basketRepository = $basketRepository;
    }

    public function createBasket(string $name, int $capacity, array $items = []): Basket
    {
        /* @var $basket \App\Entity\Basket */

        $basket = new Basket(
            Uuid::uuid1(),
            new BasketName($name),
            new BasketCapacity($capacity)
        );


        foreach ($items as $item) {
            $basket->addItem(
                new ItemType($item['type']),
                new UnsignedPositiveInt($item['weight'])
            );
        }

        $this->basketRepository->store($basket);

        return $basket;
    }

    public function getBasketsList(
        array $criteria=[],
        array $orderBy = null,
        $limit = null,
        $offset = null)
    {
        return $this->basketRepository->findBy(
            $criteria,
            $orderBy,
            $limit,
            $offset
        );
    }

    public function findBasket(int $id): ?Basket
    {
        return $this->basketRepository->find($id);
    }

    public function updateBasket(int $id, $params = []): ?Basket
    {
        $Arrays = new Arrays();

        $basket = $this->basketRepository->find($id);

        if (is_string($Arrays->getKey($params, 'name'))) {
            $basket->setName(new FilledString($params['name']));
        }

        $this->basketRepository->store($basket);

        return $basket;
    }

    public function removeBasket(int $id): ?Basket
    {
        return $this->basketRepository->remove($id);
    }

    public function removeBasketItem(int $id, $itemIndex): Item
    {
        $basket = $this->basketRepository->find($id);

        if (!$basket) {
            throw new \LogicException('No basket with id'. $id);
        }

        $removed = $basket->removeItem($itemIndex);
        $this->basketRepository->store($basket);

        return $removed;
    }
}

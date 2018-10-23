<?php

namespace App\Entity;

use App\Domain\VO\BasicInt;
use App\Domain\VO\BasketCapacity;
use App\Domain\VO\BasketName;
use App\Domain\VO\ItemType;
use App\Domain\VO\ItemWeight;
use Doctrine\Common\Collections\ArrayCollection;
use Rhumsaa\Uuid\Uuid;

class Basket
{
    private $id;
    private $name;
    private $capacity;
    private $items;


    public function __construct(Uuid $id, BasketName $name, BasketCapacity $capacity)
    {
        $this->id = $id;
        $this->name = $name;
        $this->capacity = $capacity;

        $this->items = new ArrayCollection();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): BasketName
    {
        return $this->name;
    }

    public function setName(BasketName $name)
    {
        $this->name = $name;
    }

    public function getCapacity(): BasketCapacity
    {
        return $this->capacity;
    }

    public function addItem(ItemType $type, ItemWeight $weight)
    {
        $item = new Item(Uuid::uuid1(), $this, $type, $weight);

        $current = $this->getCurrentWeight();
        $newWeight = $current->add($item->getWeight()->getValue());

        if ($newWeight->asInt() > $this->capacity->asInt()) {
            throw new \LogicException('Cant add item: max capacity reached:'. $newWeight);
        }

        $this->items[] = $item;
    }

    public function removeItem($index)
    {
        $item = $this->items->remove($index);

        if (!$item) {
            throw new \LogicException('Cant find item with index:'. $index);
        }

        return $item;
    }

    private function getCurrentWeight(): BasicInt
    {
        $sum = new BasicInt(0);

        foreach ($this->items as $item) {
            $sum = $sum->add($item->getWeight()->getValue());
        }

        return $sum;
    }
}

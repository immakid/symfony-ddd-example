<?php

namespace App\Entity;

use App\Domain\VO\ItemType;
use App\Domain\VO\ItemWeight;
use Rhumsaa\Uuid\Uuid;

class Item
{
    private $id;
    private $weight;
    private $basket;
    private $type;

    public function __construct(Uuid $id, Basket $basket, ItemType $type, ItemWeight $weight)
    {
        $this->id = $id;
        $this->type = $type;
        $this->weight = $weight;
        $this->basket = $basket;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getWeight(): ItemWeight
    {
        return $this->weight;
    }

    public function getType(): ItemType
    {
        return $this->type;
    }
}

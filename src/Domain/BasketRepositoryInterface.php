<?php

namespace App\Domain;

use \App\Entity\Basket;


interface BasketRepositoryInterface
{
    public function store(Basket $basket);
    public function find(int $id);
    public function remove(int $id);
    public function findBy(array $criteria, array$orderBy, int $limit, int $offset);
}

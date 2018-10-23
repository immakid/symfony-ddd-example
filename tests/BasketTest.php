<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.10.18
 * Time: 10:00
 */

namespace App\Tests\Basket;

use App\Entity\Basket;
use App\Entity\Item;
use App\Types\FilledString;
use App\Types\ItemType;
use App\Types\UnsignedPositiveInt;
use PHPUnit\Framework\TestCase;
use Rhumsaa\Uuid\Uuid;


class BasketTest extends TestCase
{
    public function testUnsignedPositiveIntZero()
    {
        $this->expectException(\LogicException::class);
        new UnsignedPositiveInt(0);
    }

    public function testUnsignedPositiveInt()
    {
        $val = new UnsignedPositiveInt(5);
        $this->assertEquals(5, $val->asInt());

        $val = new UnsignedPositiveInt(1);
        $this->assertEquals(1, $val->asInt());
    }

    public function testFilledString()
    {
        $s = new FilledString('sss');
        $this->assertEquals('sss', $s->getValue());
    }

    public function testFilledStringEmpty()
    {
        $this->expectException(\LogicException::class);
        $s = new FilledString('');
    }

    public function testItemType()
    {
        $Item = new ItemType('apple');
        $this->assertEquals('apple', $Item->getValue());

        $Item = new ItemType('orange');
        $this->assertEquals('orange', $Item->getValue());

        $Item = new ItemType('watermellon');
        $this->assertEquals('watermellon', $Item->getValue());
    }


    public function testBasketEmptyName()
    {
        $this->expectException(\LogicException::class);
        $basket = new Basket(Uuid::uuid1(), new FilledString(''), new UnsignedPositiveInt(100));

    }

    public function testBasketEmptyCapacity()
    {
        $this->expectException(\LogicException::class);
        $basket = new Basket(Uuid::uuid1(), new FilledString('name'), new UnsignedPositiveInt(0));

    }

    public function testBasketMaxCapacityReached()
    {
        $this->expectException(\LogicException::class);

        $basket = new Basket(Uuid::uuid1(), new FilledString('name1'), new UnsignedPositiveInt(7));

        $basket->addItem(new ItemType('watermellon'), new UnsignedPositiveInt(5));
        $basket->addItem(new ItemType('orange'), new UnsignedPositiveInt(3));
        $basket->addItem(new ItemType('apple'), new UnsignedPositiveInt(4));
    }

}
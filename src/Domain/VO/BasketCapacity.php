<?php
/**
 * Created by PhpStorm.
 * User: rtt
 * Date: 22.10.18
 * Time: 19:01
 */

namespace App\Domain\VO;


class BasketCapacity
{
    /**
     * @var int
     */
    private $value;

    public function __construct(int $value)
    {
        if ($value < 1) {
            throw new \InvalidArgumentException('Value cant be less than 1:'. $value);
        }

        $this->value = new BasicInt($value);
    }

    public function getValue(): BasicInt
    {
        return $this->value;
    }

    public function asInt(): int
    {
        return $this->value->asInt();
    }
}
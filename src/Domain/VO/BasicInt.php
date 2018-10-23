<?php
/**
 * Created by PhpStorm.
 * User: rtt
 * Date: 22.10.18
 * Time: 19:56
 */

namespace App\Domain\VO;


class BasicInt
{
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function asInt(): int
    {
        return $this->value;
    }

    public function add(BasicInt $val)
    {
        return new BasicInt($val->asInt() + $this->value);
    }
}
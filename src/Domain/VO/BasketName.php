<?php
/**
 * Created by PhpStorm.
 * User: rtt
 * Date: 22.10.18
 * Time: 18:58
 */

namespace App\Domain\VO;


class BasketName
{
    /**
     * @var int
     */
    private $value;

    public function __construct(string $value)
    {
        if (strlen($value) <= 0) {
            throw new \InvalidArgumentException('Basket name cant be empty string :'. $value);
        }

        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}
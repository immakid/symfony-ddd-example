<?php

namespace App\Domain\VO;

class ItemType
{
    const APPLE = 'apple';
    const ORANGE = 'orange';
    const WATERMELLON = 'watermellon';

    protected $types = [
        self::APPLE,
        self::ORANGE,
        self::WATERMELLON,
    ];

    public function __construct(string $value)
    {
        if (!in_array($value, $this->types)) {
            throw new \InvalidArgumentException('Value cant be empty string 1:'. $value);
        }

        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}

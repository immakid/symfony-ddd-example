<?php
/**
 * Created by PhpStorm.
 * User: rtt
 * Date: 22.10.18
 * Time: 20:34
 */

namespace App\Entity\DbalTypes;


class ItemWeight
{
    const NAME = 'ItemWeight'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        // return the SQL used to create your column type. To create a portable column type, use the $platform.
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        // This is executed when the value is read from the database. Make your conversions here, optionally using the $platform.
        return new \App\Domain\VO\ItemWeight($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->asInt();
        // This is executed when the value is written to the database. Make your conversions here, optionally using the $platform.
    }

    public function getName()
    {
        return self::NAME; // modify to match your constant name
    }
}
<?php


namespace App\Entity\Traits;


trait EnumValues
{
    public function getPossibleTypes()
    {
        return array_keys(static::$possibleValues);
    }

    public function getPossibleValues()
    {
        return array_values(static::$possibleValues);
    }

    public function getValueByType($type)
    {
        $this->isTypeExist($type);

        return static::$possibleValues[$type];
    }

    public function getPossible()
    {
        return static::$possibleValues;
    }

    public function getPossibleReversed()
    {
        return array_reverse($this->getPossible());
    }

    public function isPossible($type)
    {
        $this->isTypeExist($type);
        return true;
    }

    public function isTypeExist($type)
    {
        if(!array_key_exists($type, static::$possibleValues))
            throw new \InvalidArgumentException("Invalid enum type '{$type}'");
    }


}
<?php


namespace App\Transformer;


class CustomerTransformer
{
    static $_result = [];
    public static function transform($data)
    {
        foreach ($data as $item){
            array_push(static::$_result, self::singleRow($item));
        }

        return static::$_result;
    }

    public static function singleRow($row)
    {
        return [
            'first_name' => $row->getFirstName(),
            'last_name' => $row->getLastName(),
            'date_of_birth' => $row->getDateOfBirth()->format('m-d-Y H:i:s'),
            'status' => $row->getStatus(),
        ];
    }


}
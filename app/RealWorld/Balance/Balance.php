<?php
/**
 * Created by PhpStorm.
 * User: SHAHIN
 * Date: 5/1/2020
 * Time: 2:38 PM
 */

namespace App\RealWorld\Balance;


use App\User;

class Balance
{
    const MINUS = 'minus';
    const SUM = 'sum';

    public static function updateBalance($userId, $value, $type)
    {
        $user = User::find($userId);
        $user->balance = self::calculateBalance($type, $value, $user->balance);
        $user->save();
    }

    private static function calculateBalance($type, $value, $balance)
    {
        switch ($type) {
            case ($type == self::MINUS):
                return $balance - $value;
                break;
            case ($type == self::SUM):
                return $balance + $value;
                break;
        }

    }
}
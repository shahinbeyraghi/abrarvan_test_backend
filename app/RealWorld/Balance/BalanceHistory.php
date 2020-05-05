<?php

namespace App\RealWorld\Balance;

use App\RealWorld\Contracts\FactorInterface;
use App\RealWorld\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;

class BalanceHistory extends Model
{
    use Filterable;

    public static function addBalanceForUser($userId, $value, $type = Balance::SUM, FactorInterface $referrer)
    {
        $balance = new BalanceHistory();
        $balance->user_id = $userId;
        $balance->value = $value;
        $balance->type = $type;
        self::getTitle($balance, $referrer);
        return $balance->save();
    }

    private static function getTitle($balance, $className)
    {
        if (method_exists($className, 'getFactorTitle') ?? false)
            $balance->title = $className->getFactorTitle();

        if (method_exists($className, 'getFactorDescription') ?? false)
            $balance->description = $className->getFactorDescription();
    }
}

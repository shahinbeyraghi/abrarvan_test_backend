<?php
/**
 * Created by PhpStorm.
 * User: SHAHIN
 * Date: 5/1/2020
 * Time: 10:51 AM
 */

namespace App\Observers;


use App\Events\BalanceChargeAlarmEvent;
use App\RealWorld\Balance\Balance;
use App\RealWorld\Balance\BalanceHistory;
use App\User;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created($user)
    {
        $balance = $user->getInsertFee();
        User::where('id', $user->id)->update(['balance' => $balance]);
        BalanceHistory::addBalanceForUser($user->id, $balance, Balance::SUM, resolve(User::class));
    }

    /**
     * @param $user
     */
    public function updating($user)
    {
        $chargeBoundary = env('BALANCE_CHARGE_ALARM_VALUE', 20000);
        if ($user->balance <= $chargeBoundary && $user->charge_alarm == '0') {
            $user->charge_alarm = '1';
            event(new BalanceChargeAlarmEvent());
        }
        if ($user->balance <= 0) {
            $user->suspend_time = date('Y-m-d H:i:s');
            $user->status = '0';
        }
    }
}

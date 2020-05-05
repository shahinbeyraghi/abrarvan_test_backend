<?php

namespace App\Listeners;

use App\Events\BalanceChargeAlarmEvent;
use App\Mail\ChargeAlarm;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BalanceChargeAlarmListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BalanceChargeAlarmEvent  $event
     * @return void
     */
    public function handle(BalanceChargeAlarmEvent $event)
    {
        Mail::to(Auth::user())->send(resolve(ChargeAlarm::class));
    }
}

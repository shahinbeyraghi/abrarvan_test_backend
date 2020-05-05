<?php
/**
 * Created by PhpStorm.
 * article: SHAHIN
 * Date: 5/1/2020
 * Time: 10:51 AM
 */

namespace App\Observers;


use App\Article;
use App\RealWorld\Balance\Balance;
use App\RealWorld\Balance\BalanceHistory;
use Illuminate\Support\Facades\Auth;

class ArticleObserver
{
    /**
     * Handle the article "created" event.
     *
     * @param  \App\Article  $article
     * @return void
     */
    public function created($article)
    {
        $balance = $article->getInsertFee();
        Balance::updateBalance(Auth::id(), $balance, Balance::MINUS);
        BalanceHistory::addBalanceForUser(Auth::id(), $balance, Balance::MINUS, resolve(Article::class));
    }
}

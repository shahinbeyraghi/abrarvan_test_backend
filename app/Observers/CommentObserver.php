<?php
/**
 * Created by PhpStorm.
 * comment: SHAHIN
 * Date: 5/1/2020
 * Time: 10:51 AM
 */

namespace App\Observers;


use App\Comment;
use App\RealWorld\Balance\Balance;
use App\RealWorld\Balance\BalanceHistory;
use App\User;
use Illuminate\Support\Facades\Auth;

class CommentObserver
{
    /**
     * Handle the comment "created" event.
     *
     * @param  \App\Comment $comment
     * @return void
     */
    public function creating($comment)
    {
        $balance = $comment->getInsertFee();
        if (Auth::user()->comment_count >= $comment->getFreeCount()) {
            Balance::updateBalance(Auth::id(), $balance, Balance::MINUS);
            BalanceHistory::addBalanceForUser(Auth::id(), $balance, Balance::MINUS, resolve(Comment::class));
        } else {
            User::increaseFreeCommentCount();
        }
    }
}

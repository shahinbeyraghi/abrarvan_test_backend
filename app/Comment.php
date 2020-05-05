<?php

namespace App;

use App\RealWorld\Contracts\BalanceInterface;
use App\RealWorld\Contracts\FactorInterface;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model implements BalanceInterface, FactorInterface
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body', 'user_id'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'user'
    ];

    /**
     * Get the user that owns the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the article that owns the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function getInsertFee()
    {
        return env('COMMENT_PRICE', 5000);
    }

    public function getFreeCount()
    {
        return env('COUNT_OF_FREE_COMMENTS', 5);
    }

    public function getFactorTitle()
    {
        return __('factor.commentTitle', ['amount' => $this->getInsertFee()]);
    }

    public function getFactorDescription()
    {
        return __('factor.commentDescription');
    }

}

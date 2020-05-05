<?php

namespace App;

use App\RealWorld\Contracts\BalanceInterface;
use App\RealWorld\Contracts\FactorInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use App\RealWorld\Follow\Followable;
use App\RealWorld\Favorite\HasFavorite;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements BalanceInterface, FactorInterface
{
    use Notifiable, Followable, HasFavorite;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'bio', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function increaseFreeCommentCount()
    {
        DB::table('users')
            ->where('id', Auth::id())
            ->update(['comment_count' => DB::raw('comment_count + 1')]);
    }

    public static function removeSuspendedUsers()
    {
        $suspendedTime = env('REMOVE_SUSPENDED_USERS_TIME', 10) * 60;
        $suspendedTime = date('Y-m-d H:i:s', time() - $suspendedTime);
        User::where('suspend_time', '<', $suspendedTime)->where('status', '0')->delete();
    }

    /**
     * Set the password using bcrypt hash.
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = (password_get_info($value)['algo'] === 0) ? bcrypt($value) : $value;
    }

    /**
     * Generate a JWT token for the user.
     *
     * @return string
     */
    public function getTokenAttribute()
    {
        return JWTAuth::fromUser($this);
    }

    /**
     * Get all the articles by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class)->latest();
    }

    /**
     * Get all the comments by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    /**
     * Get all the articles of the following users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feed()
    {
        $followingIds = $this->following()->pluck('id')->toArray();

        return Article::loadRelations()->whereIn('user_id', $followingIds);
    }

    /**
     * Get the key name for route model binding.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
    }

    public function getInsertFee()
    {
        return env('REGISTER_GIFT_BALANCE', 100000);
    }

    public function getFactorTitle()
    {
        return __('factor.userRegisterTitle', ['amount' => $this->getInsertFee()]);
    }

    public function getFactorDescription()
    {
        return __('factor.User Register Description');
    }

}

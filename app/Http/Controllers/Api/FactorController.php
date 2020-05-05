<?php
/**
 * Created by PhpStorm.
 * User: SHAHIN
 * Date: 5/2/2020
 * Time: 11:59 PM
 */

namespace App\Http\Controllers\Api;


use App\RealWorld\Balance\BalanceHistory;
use App\RealWorld\Paginate\Paginate;
use App\RealWorld\Transformers\FactorTransformer;
use Illuminate\Support\Facades\Auth;

class FactorController extends ApiController
{
    /**
     * UserController constructor.
     *
     * @param FactorTransformer $transformer
     */
    public function __construct(FactorTransformer $transformer)
    {
        $this->transformer = $transformer;

        $this->middleware('auth.api');
    }

    /**
     * Get all the articles.
     ** @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $factors = new Paginate(BalanceHistory::where('user_id', Auth::id())->where('type', 'minus'));

        return $this->respondWithPagination($factors);
    }
}
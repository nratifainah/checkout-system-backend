<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Services\CheckoutService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    //

    private $checkoutService;
    public function __construct( CheckoutService $checkoutService )
    {
        $this->checkoutService  = $checkoutService;
    }


    public function checkout(CheckoutRequest $request){


        $customer = \Auth::user();

        $customerID = $customer->id;
        $result = $this->checkoutService->checkout($customerID, $request->products);

        if($result){
            return response()->json( ['message' => 'success', 'data' => $result], 200);
        }

        return response()->json( ['message' => 'error'], 500);
    }
}

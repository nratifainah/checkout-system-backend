<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    private $service;

    public function __construct(ProductService $productService)
    {
        $this->service = $productService;
    }



    public function index(){
        $products = $this->service->all();

        if($products){
            return response()->json( ['products' => $products], 200);
        }


        return response()->json( ['message' => 'error'], 500);
    }
}

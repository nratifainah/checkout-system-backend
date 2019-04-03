<?php
/**
 * Created by PhpStorm.
 * User: nurulratifainah
 * Date: 16/03/2019
 * Time: 10:40 PM
 */

namespace App\Services;


use App\Models\Product;

class ProductService
{

    private $model;
    public function __construct(Product $model)
    {
        $this->model  = $model;
    }


    public function all(){
        return $this->model->all();
    }

    public function find($id){
        return $this->model->find($id);
    }


    public function findBySlug($slug){
        return $this->model->where('slug', $slug)->first();
    }
}
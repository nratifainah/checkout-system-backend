<?php

use Illuminate\Database\Seeder;
use App\Constants\Products;
use \App\Services\ProductService;

class ProductOffersTableSeeder extends Seeder
{

    private $productService;
    public function __construct(\App\Services\ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $customers = DB::table('users')->get();

        foreach ($customers as $customer){
            switch ($customer->name){
                case "Unilever":

                    $product = $this->productService->findBySlug('classic');

                        DB::table('product_offers')->insert([
                            'customer_id' => $customer->id,
                            'product_id' => $product->id,
                            'minimum_quantity' => 3,
                            'type' => Products::PRODUCT_OFFER_TYPE_DISCOUNTED_QUANTITY,
                            'value' => 2,
                            'status' => Products::PRODUCT_OFFER_STATUS_ACTIVE
                        ]);


                    break;

                case "Apple":

                    $product = $this->productService->findBySlug('standout');

                    DB::table('product_offers')->insert([
                        'customer_id' => $customer->id,
                        'product_id' => $product->id,
                        'minimum_quantity' => 1,
                        'type' => Products::PRODUCT_OFFER_TYPE_DISCOUNTED_PRICE,
                        'value' => 299.99,
                        'status' => Products::PRODUCT_OFFER_STATUS_ACTIVE
                    ]);


                    break;
                case "Nike":

                    $product = $this->productService->findBySlug('premium');

                    DB::table('product_offers')->insert([
                        'customer_id' => $customer->id,
                        'product_id' => $product->id,
                        'minimum_quantity' => 4,
                        'type' => Products::PRODUCT_OFFER_TYPE_DISCOUNTED_PRICE,
                        'value' => 379.99,
                        'status' => Products::PRODUCT_OFFER_STATUS_ACTIVE
                    ]);


                    break;
                case "Ford":

                    $product = $this->productService->findBySlug('classic');

                    DB::table('product_offers')->insert([
                        'customer_id' => $customer->id,
                        'product_id' => $product->id,
                        'minimum_quantity' => 5,
                        'type' => Products::PRODUCT_OFFER_TYPE_DISCOUNTED_QUANTITY,
                        'value' => 4,
                        'status' => Products::PRODUCT_OFFER_STATUS_ACTIVE
                    ]);

                    $product = $this->productService->findBySlug('standout');

                    DB::table('product_offers')->insert([
                        'customer_id' => $customer->id,
                        'product_id' => $product->id,
                        'minimum_quantity' => 5,
                        'type' => Products::PRODUCT_OFFER_TYPE_DISCOUNTED_QUANTITY,
                        'value' => 309.99,
                        'status' => Products::PRODUCT_OFFER_STATUS_ACTIVE
                    ]);

                    $product = $this->productService->findBySlug('premium');

                    DB::table('product_offers')->insert([
                        'customer_id' => $customer->id,
                        'product_id' => $product->id,
                        'minimum_quantity' => 3,
                        'type' => Products::PRODUCT_OFFER_TYPE_DISCOUNTED_PRICE,
                        'value' => 389.99,
                        'status' => Products::PRODUCT_OFFER_STATUS_ACTIVE
                    ]);


                    break;

            }
        }
    }
}

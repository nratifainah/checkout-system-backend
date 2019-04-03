<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $products = [
            [
                "name"  => "Classic",
                "price" =>  269.99
            ],
            [
                "name"  => "Standout",
                "price" =>  322.99
            ],
            [
                "name"  => "Premium",
                "price" =>  394.99
            ]
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'slug' => strtolower($product["name"]),
                'name' => $product["name"] .' Ad',
                'unit_price' => $product["price"],
            ]);
        }

    }
}

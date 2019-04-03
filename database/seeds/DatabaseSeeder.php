<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try{

            $this->call(UsersTableSeeder::class);
            $this->call(ProductsTableSeeder::class);
            $this->call(ProductOffersTableSeeder::class);
        }catch (Exception $ex){
            \Log::error($ex);
            var_dump($ex->getMessage());
            DB::rollBack();
        }

        DB::commit();

    }
}

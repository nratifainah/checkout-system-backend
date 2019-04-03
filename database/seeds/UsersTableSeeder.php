<?php
/**
 * Created by PhpStorm.
 * User: nurulratifainah
 * Date: 16/03/2019
 * Time: 6:39 PM
 */

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $customers = [
            "Ordinary",
            "Unilever",
            "Apple",
            "Nike",
            "Ford"
        ];

        foreach ($customers as $customer) {
            Db::table('users')->insert([
                'name' => $customer,
                'email' => strtolower($customer).'@mail.com',
                'password' => bcrypt('secret')
            ]);
        }
    }

}
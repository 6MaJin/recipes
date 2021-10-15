<?php

namespace Database\Seeders;

use App\Models\Shoppinglist;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Product::factory(50)->create();
        User::factory(10)->create()->each(function ($user) {
            Shoppinglist::factory(rand(1, 8))->create(
                [
                    'user_id' => $user->id
                ]
            )->each(function ($shoppinglist) {
                $product_ids = range(1, 12);
                shuffle($product_ids);
                $product_ids = array_slice($product_ids, 0, rand(0, 33));
                foreach ($product_ids as $product_id) {

                    DB::table('product_shoppinglist')
                        ->insert(
                            [
                                'shoppinglist_id' => $shoppinglist->id,
                                'product_id' => $product_id,
                                'created_at' => now(),
                                'updated_at' => now()
                            ]
                        );


                }
            });
        });
    }
}

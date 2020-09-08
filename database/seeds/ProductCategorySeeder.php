<?php

use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_categories')->insert([
            'product_category' => Str::random(10),
            'product_type' => rand(1,3),
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

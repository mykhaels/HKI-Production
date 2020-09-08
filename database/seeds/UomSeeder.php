<?php

use Illuminate\Database\Seeder;

class UomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('uoms')->insert([
            'name' => 'gram',
        ]);
        DB::table('uoms')->insert([
            'name' => 'kilogram',
        ]);
        DB::table('uoms')->insert([
            'name' => 'botol',
        ]);
        DB::table('uoms')->insert([
            'name' => 'pcs',
        ]);
        DB::table('uoms')->insert([
            'name' => 'sack',
        ]);
    }
}

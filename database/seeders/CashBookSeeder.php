<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CashBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cash_books')->insert([
            'user_id' => '2',
            'category_id' => '1',
            'amount' => '1000000',
            'description' => 'Unknown',
        ]);
        DB::table('cash_books')->insert([
            'user_id' => '2',
            'category_id' => '2',
            'amount' => '1000000',
            'description' => 'Unknown',
        ]);
    }
}

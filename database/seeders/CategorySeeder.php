<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Tidak ada kategori',
                'type' => 'K'
            ],
            [
                'name' => 'Tidak ada kategori',
                'type' => 'D'
            ],
            [
                'name' => 'Ini Pemasukan',
                'type' => 'K'
            ],
            [
                'name' => 'Ini Pengeluaran',
                'type' => 'D'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

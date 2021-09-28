<?php

namespace Database\Seeders;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();
        
        Category::insert([
            ['name' => 'Electronics', 'slug' => 'electronics', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Home', 'slug' => 'home', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Fashion', 'slug' => 'fashion', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}

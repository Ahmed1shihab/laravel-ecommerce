<?php

namespace Database\Seeders;

use App\Models\Product;
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
        for ($i=1; $i < 15; $i++) { 
            Product::create([
                'name' => 'Apple Macbook ' . $i,
                'slug' => 'apple-macbook-' . $i,
                'details' => 'Apple M1 chip - (8 GB/512 GB SSD. 13.3-inch (diagonal) LED-backlit display with IPS technology)',
                'description' => 'Lorem ' . $i . ' ipsum dolor, sit amet consectetur adipisicing elit. Dolorum, laudantium molestiae corrupti similique sequi autem aperiam maxime asperiores tempore modi!',
                'price' => rand(149999, 249999),
                'image' => 'products\September2021\apple-macbook.png'
            ])->categories()->attach(1);
        }

        for ($i=1; $i < 15; $i++) { 
            Product::create([
                'name' => 'Sofa ' . $i,
                'slug' => 'sofa-' . $i,
                'details' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea esse, pariatur',
                'description' => 'Lorem ' . $i . ' ipsum dolor, sit amet consectetur adipisicing elit. Dolorum, laudantium molestiae corrupti similique sequi autem aperiam maxime asperiores tempore modi!',
                'price' => rand(14999, 24999),
                'image' => 'products\September2021\sofa.png'
            ])->categories()->attach(2);
        }

        Product::whereIn('id', [1, 4, 6, 8, 9, 14, 18])->update(['featured' => true]);
    }
}

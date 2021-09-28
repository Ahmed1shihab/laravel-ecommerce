<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewShopPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function shop_page_loads_correctly()
    {
        $response = $this->get('/shop');

        $response->assertOk();
        $response->assertSee('filter');
        $response->assertSee('All Products');
    }

    /** @test */
    public function product_is_visible()
    {
        // Arrange
        $product = Product::factory()->create([
            'price' => 14999
        ]);

        // Act
        $response = $this->get('/shop');

        // Assert
        $response->assertStatus(200);
        $response->assertSee($product->name);
        $response->assertSee('$149.99');
    }

    /** @test */
    public function sort_high_to_low_work()
    {
        // Arrange
        Product::factory()->create([
            'name' => 'Product Low',
            'price' => 10000
        ]);

        Product::factory()->create([
            'name' => 'Product Middle',
            'price' => 15000
        ]);

        Product::factory()->create([
            'name' => 'Product High',
            'price' => 20000
        ]);

        $response = $this->get('/shop?sort=high_low');

        $response->assertOk();
        $response->assertSeeInOrder(['Product High', 'Product Middle', 'Product Low']);
    }

    /** @test */
    public function sort_low_to_high_work()
    {
        // Arrange
        Product::factory()->create([
            'name' => 'Product Low',
            'price' => 10000
        ]);

        Product::factory()->create([
            'name' => 'Product Middle',
            'price' => 15000
        ]);

        Product::factory()->create([
            'name' => 'Product High',
            'price' => 20000
        ]);

        $response = $this->get('/shop?sort=low_high');

        $response->assertOk();
        $response->assertSeeInOrder(['Product Low', 'Product Middle', 'Product High']);
    }

    /** @test */
    public function category_page_shows_correct_products()
    {
        $laptop1 = Product::factory()->create(['name' => 'Laptop 1']);
        $laptop2 = Product::factory()->create(['name' => 'Laptop 2']);

        $laptopsCategory = Category::create([
            'name' => 'Laptops',
            'slug' => 'laptops'
        ]);

        $laptop1->categories()->attach($laptopsCategory->id);
        $laptop2->categories()->attach($laptopsCategory->id);

        $response = $this->get('/shop?category=laptops');

        $response->assertOk();
        $response->assertSee('Laptop 1');
        $response->assertSee('Laptop 2');
    }

    /** @test */
    public function category_page_does_not_show_products_in_another_category()
    {
        $laptop1 = Product::factory()->create(['name' => 'Laptop 1']);
        $laptop2 = Product::factory()->create(['name' => 'Laptop 2']);

        $laptopsCategory = Category::create([
            'name' => 'Laptops',
            'slug' => 'laptops'
        ]);

        $desktop1 = Product::factory()->create(['name' => 'Desktop 1']);
        $desktop2 = Product::factory()->create(['name' => 'Desktop 2']);

        $desktopsCategory = Category::create([
            'name' => 'Desktops',
            'slug' => 'desktops'
        ]);

        $laptop1->categories()->attach($laptopsCategory->id);
        $laptop2->categories()->attach($laptopsCategory->id);

        $desktop1->categories()->attach($desktopsCategory->id);
        $desktop2->categories()->attach($desktopsCategory->id);

        $response = $this->get('/shop?category=laptops');

        $response->assertOk();
        $response->assertSee('Laptop 1');
        $response->assertSee('Laptop 2');
        $response->assertDontSee('Desktop 1');
        $response->assertDontSee('Desktop 2');
    }
}

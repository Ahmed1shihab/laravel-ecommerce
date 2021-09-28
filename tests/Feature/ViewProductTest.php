<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_product_details()
    {
        $prodcut = Product::factory()->create([
            'name' => 'Laptop 1',
            'slug' => 'laptop-1',
            'price' => 149999
        ]);

        $response = $this->get('/shop/' . $prodcut->slug);

        $response->assertOk();
        $response->assertSee($prodcut->name);
        $response->assertSee('$1,499.99');
        $response->assertSee($prodcut->description);
        $response->assertSee('Add To Cart');
    }

    /** @test */
    public function show_related_products()
    {
        $laptop1 = Product::factory()->create(['name' => 'Laptop 1', 'slug' => 'laptop-1']);
        $laptop2 = Product::factory()->create(['name' => 'Laptop 2', 'slug' => 'laptop-2', 'details' => 'details']);

        $response = $this->get('shop/' . $laptop1->slug);

        $response->assertOk();
        $response->assertSee('You Might Also Like');
        $response->assertSee('Laptop 2');
        $response->assertSee($laptop2->details);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewLandingPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function landing_page_loads_correctly()
    {
        //Arrange

        //Act
        $response = $this->get('/');

        //Assert
        $response->assertStatus(200);
        $response->assertSee('Featured Products');
        $response->assertSee('Home');
        $response->assertSee('Shop');
    }

    /** @test */
    public function featured_product_is_visible()
    {
        // Arrange
        $product = Product::factory()->create([
            'price' => 14999
        ]);

        // Act
        $response = $this->get('/');

        // Assert
        $response->assertStatus(200);
        $response->assertSee($product->name);
        $response->assertSee('$149.99');
    }
    
    /** @test */
    public function not_featured_product_is_not_visible()
    {
        // Arrange
        $product = Product::factory()->create([
            'featured' => false,
            'price' => 14999
        ]);

        // Act
        $response = $this->get('/');

        // Assert
        $response->assertStatus(200);
        $response->assertDontSee($product->name);
        $response->assertDontSee('$149.99');
    }
}

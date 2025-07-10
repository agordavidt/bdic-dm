<?php

namespace Tests\Unit;

use App\Models\CartItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartItemTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function cart_item_belongs_to_user()
    {
        $user = User::factory()->create();
        $cartItem = CartItem::factory()->create(['user_id' => $user->id]);
        $this->assertInstanceOf(User::class, $cartItem->user);
        $this->assertEquals($user->id, $cartItem->user->id);
    }

    /** @test */
    public function cart_item_belongs_to_product()
    {
        $product = Product::factory()->create();
        $cartItem = CartItem::factory()->create(['product_id' => $product->id]);
        $this->assertInstanceOf(Product::class, $cartItem->product);
        $this->assertEquals($product->id, $cartItem->product->id);
    }

    /** @test */
    public function cart_item_total_price_is_calculated_correctly()
    {
        $product = Product::factory()->create(['price' => 50.00]);
        $cartItem = CartItem::factory()->create([
            'product_id' => $product->id,
            'quantity' => 3,
        ]);
        $this->assertEquals(150.00, $cartItem->total_price);
    }

    /** @test */
    public function cart_item_can_increase_quantity()
    {
        $cartItem = CartItem::factory()->create(['quantity' => 2]);
        $cartItem->increaseQuantity(3);
        $this->assertEquals(5, $cartItem->fresh()->quantity);
    }

    /** @test */
    public function cart_item_can_decrease_quantity()
    {
        $cartItem = CartItem::factory()->create(['quantity' => 5]);
        $cartItem->decreaseQuantity(2);
        $this->assertEquals(3, $cartItem->fresh()->quantity);
    }

    /** @test */
    public function cart_item_cannot_decrease_quantity_below_one()
    {
        $cartItem = CartItem::factory()->create(['quantity' => 1]);
        $this->expectException(\Exception::class);
        $cartItem->decreaseQuantity(1);
    }
} 
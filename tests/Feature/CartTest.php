<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\DeviceCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function buyer_can_view_cart()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $category = DeviceCategory::factory()->create();
        $product = Product::factory()->create([
            'status' => 'active',
            'stock_quantity' => 10,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($buyer)->get(route('cart.index'));

        $response->assertStatus(200);
        $response->assertSee('Shopping Cart');
    }

    /** @test */
    public function buyer_can_add_item_to_cart()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $category = DeviceCategory::factory()->create();
        $product = Product::factory()->create([
            'status' => 'active',
            'stock_quantity' => 10,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($buyer)->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('cart_items', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    /** @test */
    public function buyer_cannot_add_out_of_stock_item()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $category = DeviceCategory::factory()->create();
        $product = Product::factory()->create([
            'status' => 'active',
            'stock_quantity' => 0,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($buyer)->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('cart_items', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
        ]);
    }

    /** @test */
    public function buyer_cannot_add_more_than_available_stock()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $category = DeviceCategory::factory()->create();
        $product = Product::factory()->create([
            'status' => 'active',
            'stock_quantity' => 5,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($buyer)->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 10,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('cart_items', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
        ]);
    }

    /** @test */
    public function buyer_can_update_cart_item_quantity()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $category = DeviceCategory::factory()->create();
        $product = Product::factory()->create([
            'status' => 'active',
            'stock_quantity' => 10,
            'category_id' => $category->id,
        ]);

        $cartItem = CartItem::factory()->create([
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($buyer)->patch(route('cart.update', $cartItem), [
            'quantity' => 3,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('cart_items', [
            'id' => $cartItem->id,
            'quantity' => 3,
        ]);
    }

    /** @test */
    public function buyer_can_remove_item_from_cart()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $category = DeviceCategory::factory()->create();
        $product = Product::factory()->create([
            'status' => 'active',
            'stock_quantity' => 10,
            'category_id' => $category->id,
        ]);

        $cartItem = CartItem::factory()->create([
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($buyer)->delete(route('cart.remove', $cartItem));

        $response->assertRedirect();
        $this->assertDatabaseMissing('cart_items', ['id' => $cartItem->id]);
    }

    /** @test */
    public function buyer_can_clear_cart()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $category = DeviceCategory::factory()->create();
        $product = Product::factory()->create([
            'status' => 'active',
            'stock_quantity' => 10,
            'category_id' => $category->id,
        ]);

        CartItem::factory()->create([
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($buyer)->post(route('cart.clear'));

        $response->assertRedirect();
        $this->assertDatabaseMissing('cart_items', ['user_id' => $buyer->id]);
    }

    /** @test */
    public function cart_quantity_increases_when_adding_same_product()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $category = DeviceCategory::factory()->create();
        $product = Product::factory()->create([
            'status' => 'active',
            'stock_quantity' => 10,
            'category_id' => $category->id,
        ]);

        // Add product first time
        $this->actingAs($buyer)->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        // Add same product again
        $this->actingAs($buyer)->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $this->assertDatabaseHas('cart_items', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'quantity' => 5,
        ]);

        // Should only have one cart item for this product
        $this->assertDatabaseCount('cart_items', 1);
    }

    /** @test */
    public function buyer_cannot_update_cart_item_with_insufficient_stock()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $category = DeviceCategory::factory()->create();
        $product = Product::factory()->create([
            'status' => 'active',
            'stock_quantity' => 5,
            'category_id' => $category->id,
        ]);

        $cartItem = CartItem::factory()->create([
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($buyer)->patch(route('cart.update', $cartItem), [
            'quantity' => 10,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('cart_items', [
            'id' => $cartItem->id,
            'quantity' => 1, // Should remain unchanged
        ]);
    }

    /** @test */
    public function buyer_cannot_access_other_user_cart_item()
    {
        $buyer1 = User::factory()->create(['role' => 'buyer']);
        $buyer2 = User::factory()->create(['role' => 'buyer']);
        $category = DeviceCategory::factory()->create();
        $product = Product::factory()->create([
            'status' => 'active',
            'stock_quantity' => 10,
            'category_id' => $category->id,
        ]);

        $cartItem = CartItem::factory()->create([
            'user_id' => $buyer1->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($buyer2)->patch(route('cart.update', $cartItem), [
            'quantity' => 3,
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function cart_ajax_endpoints_work()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $category = DeviceCategory::factory()->create();
        $product = Product::factory()->create([
            'status' => 'active',
            'stock_quantity' => 10,
            'category_id' => $category->id,
        ]);

        CartItem::factory()->create([
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($buyer)->get(route('cart.count'));
        $response->assertStatus(200);
        $response->assertJson(['count' => 2]);

        $response = $this->actingAs($buyer)->get(route('cart.total'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['total']);
    }

    /** @test */
    public function unauthenticated_user_cannot_access_cart()
    {
        $response = $this->get(route('cart.index'));
        $response->assertRedirect(route('login'));
    }
} 
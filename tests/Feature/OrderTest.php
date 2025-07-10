<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\CartItem;
use App\Models\DeviceCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function buyer_can_view_orders()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        $order = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'vendor_id' => $vendor->id,
        ]);

        $response = $this->actingAs($buyer)->get(route('orders.index'));

        $response->assertStatus(200);
        $response->assertSee($order->order_number);
    }

    /** @test */
    public function vendor_can_view_orders()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        $order = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'vendor_id' => $vendor->id,
        ]);

        $response = $this->actingAs($vendor)->get(route('orders.index'));

        $response->assertStatus(200);
        $response->assertSee($order->order_number);
    }

    /** @test */
    public function buyer_can_access_checkout()
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

        $response = $this->actingAs($buyer)->get(route('orders.checkout'));

        $response->assertStatus(200);
        $response->assertSee('Checkout');
    }

    /** @test */
    public function buyer_cannot_access_checkout_with_empty_cart()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);

        $response = $this->actingAs($buyer)->get(route('orders.checkout'));

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('error');
    }

    /** @test */
    public function buyer_can_create_order()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        $category = DeviceCategory::factory()->create();
        $product = Product::factory()->create([
            'vendor_id' => $vendor->id,
            'status' => 'active',
            'stock_quantity' => 10,
            'category_id' => $category->id,
            'price' => 100.00,
        ]);

        CartItem::factory()->create([
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $orderData = [
            'shipping_address' => '123 Main St, City, State 12345',
            'billing_address' => '123 Main St, City, State 12345',
            'payment_method' => 'credit_card',
            'notes' => 'Please deliver in the morning',
        ];

        $response = $this->actingAs($buyer)->post(route('orders.store'), $orderData);

        $response->assertRedirect(route('orders.index'));
        $this->assertDatabaseHas('orders', [
            'buyer_id' => $buyer->id,
            'vendor_id' => $vendor->id,
            'payment_method' => 'credit_card',
        ]);

        // Check that stock was reduced
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock_quantity' => 8, // 10 - 2
        ]);

        // Check that cart was cleared
        $this->assertDatabaseMissing('cart_items', [
            'user_id' => $buyer->id,
        ]);
    }

    /** @test */
    public function order_creation_fails_with_insufficient_stock()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        $category = DeviceCategory::factory()->create();
        $product = Product::factory()->create([
            'vendor_id' => $vendor->id,
            'status' => 'active',
            'stock_quantity' => 1,
            'category_id' => $category->id,
        ]);

        CartItem::factory()->create([
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'quantity' => 5,
        ]);

        $orderData = [
            'shipping_address' => '123 Main St, City, State 12345',
            'billing_address' => '123 Main St, City, State 12345',
            'payment_method' => 'credit_card',
        ];

        $response = $this->actingAs($buyer)->post(route('orders.store'), $orderData);

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('orders', [
            'buyer_id' => $buyer->id,
        ]);
    }

    /** @test */
    public function buyer_can_view_order_details()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        $order = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'vendor_id' => $vendor->id,
        ]);

        $response = $this->actingAs($buyer)->get(route('orders.show', $order));

        $response->assertStatus(200);
        $response->assertSee($order->order_number);
    }

    /** @test */
    public function vendor_can_update_order_status()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        $order = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'vendor_id' => $vendor->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($vendor)->patch(route('orders.update-status', $order), [
            'status' => 'confirmed',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'confirmed',
        ]);
    }

    /** @test */
    public function buyer_cannot_update_order_status()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        $order = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'vendor_id' => $vendor->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($buyer)->patch(route('orders.update-status', $order), [
            'status' => 'confirmed',
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function buyer_can_cancel_order()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        $category = DeviceCategory::factory()->create();
        $product = Product::factory()->create([
            'vendor_id' => $vendor->id,
            'stock_quantity' => 5,
            'category_id' => $category->id,
        ]);

        $order = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'vendor_id' => $vendor->id,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        // Create order item
        $order->orderItems()->create([
            'product_id' => $product->id,
            'quantity' => 2,
            'unit_price' => 100.00,
            'total_price' => 200.00,
        ]);

        $response = $this->actingAs($buyer)->post(route('orders.cancel', $order));

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'cancelled',
        ]);

        // Check that stock was restored
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock_quantity' => 7, // 5 + 2
        ]);
    }

    /** @test */
    public function buyer_cannot_cancel_paid_order()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        $order = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'vendor_id' => $vendor->id,
            'status' => 'confirmed',
            'payment_status' => 'paid',
        ]);

        $response = $this->actingAs($buyer)->post(route('orders.cancel', $order));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'confirmed', // Should remain unchanged
        ]);
    }

    /** @test */
    public function vendor_can_update_payment_status()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        $order = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'vendor_id' => $vendor->id,
            'payment_status' => 'pending',
        ]);

        $response = $this->actingAs($vendor)->patch(route('orders.update-payment-status', $order), [
            'payment_status' => 'paid',
            'transaction_id' => 'TXN123456',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'payment_status' => 'paid',
            'transaction_id' => 'TXN123456',
        ]);
    }

    /** @test */
    public function orders_can_be_filtered_by_status()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        
        $pendingOrder = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'vendor_id' => $vendor->id,
            'status' => 'pending',
        ]);
        
        $confirmedOrder = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'vendor_id' => $vendor->id,
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($buyer)->get(route('orders.index', ['status' => 'pending']));

        $response->assertStatus(200);
        $response->assertSee($pendingOrder->order_number);
        $response->assertDontSee($confirmedOrder->order_number);
    }

    /** @test */
    public function unauthenticated_user_cannot_access_orders()
    {
        $response = $this->get(route('orders.index'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function order_creation_creates_multiple_orders_for_different_vendors()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor1 = User::factory()->create(['role' => 'vendor']);
        $vendor2 = User::factory()->create(['role' => 'vendor']);
        $category = DeviceCategory::factory()->create();
        
        $product1 = Product::factory()->create([
            'vendor_id' => $vendor1->id,
            'status' => 'active',
            'stock_quantity' => 10,
            'category_id' => $category->id,
            'price' => 100.00,
        ]);
        
        $product2 = Product::factory()->create([
            'vendor_id' => $vendor2->id,
            'status' => 'active',
            'stock_quantity' => 10,
            'category_id' => $category->id,
            'price' => 200.00,
        ]);

        CartItem::factory()->create([
            'user_id' => $buyer->id,
            'product_id' => $product1->id,
            'quantity' => 1,
        ]);

        CartItem::factory()->create([
            'user_id' => $buyer->id,
            'product_id' => $product2->id,
            'quantity' => 1,
        ]);

        $orderData = [
            'shipping_address' => '123 Main St, City, State 12345',
            'billing_address' => '123 Main St, City, State 12345',
            'payment_method' => 'credit_card',
        ];

        $response = $this->actingAs($buyer)->post(route('orders.store'), $orderData);

        $response->assertRedirect(route('orders.index'));
        
        // Should create two separate orders
        $this->assertDatabaseCount('orders', 2);
        $this->assertDatabaseHas('orders', ['vendor_id' => $vendor1->id]);
        $this->assertDatabaseHas('orders', ['vendor_id' => $vendor2->id]);
    }
} 
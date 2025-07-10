<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function order_belongs_to_buyer()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $order = Order::factory()->create(['buyer_id' => $buyer->id]);
        $this->assertInstanceOf(User::class, $order->buyer);
        $this->assertEquals($buyer->id, $order->buyer->id);
    }

    /** @test */
    public function order_belongs_to_vendor()
    {
        $vendor = User::factory()->create(['role' => 'vendor']);
        $order = Order::factory()->create(['vendor_id' => $vendor->id]);
        $this->assertInstanceOf(User::class, $order->vendor);
        $this->assertEquals($vendor->id, $order->vendor->id);
    }

    /** @test */
    public function order_has_many_order_items()
    {
        $order = Order::factory()->create();
        $item1 = OrderItem::factory()->create(['order_id' => $order->id]);
        $item2 = OrderItem::factory()->create(['order_id' => $order->id]);
        $this->assertCount(2, $order->orderItems);
        $this->assertInstanceOf(OrderItem::class, $order->orderItems->first());
    }

    /** @test */
    public function order_has_many_products_through_order_items()
    {
        $order = Order::factory()->create();
        $product1 = Product::factory()->create();
        $product2 = Product::factory()->create();
        OrderItem::factory()->create(['order_id' => $order->id, 'product_id' => $product1->id]);
        OrderItem::factory()->create(['order_id' => $order->id, 'product_id' => $product2->id]);
        $this->assertCount(2, $order->products);
    }

    /** @test */
    public function order_total_amount_is_calculated_correctly()
    {
        $order = Order::factory()->create();
        OrderItem::factory()->create(['order_id' => $order->id, 'unit_price' => 100, 'quantity' => 2]);
        OrderItem::factory()->create(['order_id' => $order->id, 'unit_price' => 50, 'quantity' => 1]);
        $this->assertEquals(250, $order->total_amount);
    }

    /** @test */
    public function order_status_helpers_work()
    {
        $order = Order::factory()->create(['status' => 'pending']);
        $this->assertTrue($order->isPending());
        $order->status = 'confirmed';
        $this->assertTrue($order->isConfirmed());
        $order->status = 'shipped';
        $this->assertTrue($order->isShipped());
        $order->status = 'delivered';
        $this->assertTrue($order->isDelivered());
        $order->status = 'cancelled';
        $this->assertTrue($order->isCancelled());
    }

    /** @test */
    public function order_payment_status_helpers_work()
    {
        $order = Order::factory()->create(['payment_status' => 'pending']);
        $this->assertTrue($order->isPaymentPending());
        $order->payment_status = 'paid';
        $this->assertTrue($order->isPaid());
        $order->payment_status = 'failed';
        $this->assertTrue($order->isPaymentFailed());
    }

    /** @test */
    public function order_can_be_cancelled()
    {
        $order = Order::factory()->create(['status' => 'pending']);
        $order->cancel();
        $this->assertEquals('cancelled', $order->fresh()->status);
    }

    /** @test */
    public function order_can_be_confirmed()
    {
        $order = Order::factory()->create(['status' => 'pending']);
        $order->confirm();
        $this->assertEquals('confirmed', $order->fresh()->status);
    }

    /** @test */
    public function order_can_be_marked_as_shipped()
    {
        $order = Order::factory()->create(['status' => 'confirmed']);
        $order->markAsShipped();
        $this->assertEquals('shipped', $order->fresh()->status);
    }

    /** @test */
    public function order_can_be_marked_as_delivered()
    {
        $order = Order::factory()->create(['status' => 'shipped']);
        $order->markAsDelivered();
        $this->assertEquals('delivered', $order->fresh()->status);
    }

    /** @test */
    public function order_can_update_payment_status()
    {
        $order = Order::factory()->create(['payment_status' => 'pending']);
        $order->updatePaymentStatus('paid', 'TXN123');
        $this->assertEquals('paid', $order->fresh()->payment_status);
        $this->assertEquals('TXN123', $order->fresh()->transaction_id);
    }

    /** @test */
    public function order_has_order_number()
    {
        $order = Order::factory()->create(['order_number' => 'ORD-12345']);
        $this->assertEquals('ORD-12345', $order->order_number);
    }

    /** @test */
    public function order_scope_by_status_returns_orders_with_given_status()
    {
        Order::factory()->create(['status' => 'pending']);
        Order::factory()->create(['status' => 'confirmed']);
        Order::factory()->create(['status' => 'pending']);
        $pendingOrders = Order::byStatus('pending')->get();
        $this->assertCount(2, $pendingOrders);
        $this->assertTrue($pendingOrders->every(fn($order) => $order->status === 'pending'));
    }

    /** @test */
    public function order_scope_by_buyer_returns_orders_for_buyer()
    {
        $buyer1 = User::factory()->create(['role' => 'buyer']);
        $buyer2 = User::factory()->create(['role' => 'buyer']);
        Order::factory()->create(['buyer_id' => $buyer1->id]);
        Order::factory()->create(['buyer_id' => $buyer2->id]);
        Order::factory()->create(['buyer_id' => $buyer1->id]);
        $buyer1Orders = Order::byBuyer($buyer1->id)->get();
        $this->assertCount(2, $buyer1Orders);
        $this->assertTrue($buyer1Orders->every(fn($order) => $order->buyer_id === $buyer1->id));
    }

    /** @test */
    public function order_scope_by_vendor_returns_orders_for_vendor()
    {
        $vendor1 = User::factory()->create(['role' => 'vendor']);
        $vendor2 = User::factory()->create(['role' => 'vendor']);
        Order::factory()->create(['vendor_id' => $vendor1->id]);
        Order::factory()->create(['vendor_id' => $vendor2->id]);
        Order::factory()->create(['vendor_id' => $vendor1->id]);
        $vendor1Orders = Order::byVendor($vendor1->id)->get();
        $this->assertCount(2, $vendor1Orders);
        $this->assertTrue($vendor1Orders->every(fn($order) => $order->vendor_id === $vendor1->id));
    }
} 
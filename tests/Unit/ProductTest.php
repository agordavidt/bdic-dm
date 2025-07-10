<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\User;
use App\Models\DeviceCategory;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function product_belongs_to_vendor()
    {
        $vendor = User::factory()->create(['role' => 'vendor']);
        $product = Product::factory()->create(['vendor_id' => $vendor->id]);

        $this->assertInstanceOf(User::class, $product->vendor);
        $this->assertEquals($vendor->id, $product->vendor->id);
    }

    /** @test */
    public function product_belongs_to_category()
    {
        $category = DeviceCategory::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(DeviceCategory::class, $product->category);
        $this->assertEquals($category->id, $product->category->id);
    }

    /** @test */
    public function product_has_many_order_items()
    {
        $product = Product::factory()->create();
        $orderItem1 = OrderItem::factory()->create(['product_id' => $product->id]);
        $orderItem2 = OrderItem::factory()->create(['product_id' => $product->id]);

        $this->assertCount(2, $product->orderItems);
        $this->assertInstanceOf(OrderItem::class, $product->orderItems->first());
    }

    /** @test */
    public function product_has_many_cart_items()
    {
        $product = Product::factory()->create();
        $cartItem1 = $product->cartItems()->create([
            'user_id' => User::factory()->create()->id,
            'quantity' => 1,
        ]);
        $cartItem2 = $product->cartItems()->create([
            'user_id' => User::factory()->create()->id,
            'quantity' => 2,
        ]);

        $this->assertCount(2, $product->cartItems);
    }

    /** @test */
    public function product_has_many_orders_through_order_items()
    {
        $product = Product::factory()->create();
        $order1 = Order::factory()->create();
        $order2 = Order::factory()->create();

        OrderItem::factory()->create([
            'product_id' => $product->id,
            'order_id' => $order1->id,
        ]);
        OrderItem::factory()->create([
            'product_id' => $product->id,
            'order_id' => $order2->id,
        ]);

        $this->assertCount(2, $product->orders);
    }

    /** @test */
    public function product_has_many_messages()
    {
        $product = Product::factory()->create();
        $message1 = $product->messages()->create([
            'sender_id' => User::factory()->create()->id,
            'recipient_id' => User::factory()->create()->id,
            'subject' => 'Test 1',
            'content' => 'Test content 1',
        ]);
        $message2 = $product->messages()->create([
            'sender_id' => User::factory()->create()->create()->id,
            'recipient_id' => User::factory()->create()->id,
            'subject' => 'Test 2',
            'content' => 'Test content 2',
        ]);

        $this->assertCount(2, $product->messages);
    }

    /** @test */
    public function product_has_sku_attribute()
    {
        $product = Product::factory()->create(['sku' => 'TEST-001']);

        $this->assertEquals('TEST-001', $product->sku);
    }

    /** @test */
    public function product_has_price_formatted_correctly()
    {
        $product = Product::factory()->create(['price' => 99.99]);

        $this->assertEquals('$99.99', $product->formatted_price);
    }

    /** @test */
    public function product_has_total_value_calculated_correctly()
    {
        $product = Product::factory()->create([
            'price' => 100.00,
            'stock_quantity' => 5,
        ]);

        $this->assertEquals(500.00, $product->total_value);
    }

    /** @test */
    public function product_is_in_stock_when_quantity_greater_than_zero()
    {
        $product = Product::factory()->create(['stock_quantity' => 5]);

        $this->assertTrue($product->is_in_stock);
    }

    /** @test */
    public function product_is_not_in_stock_when_quantity_is_zero()
    {
        $product = Product::factory()->create(['stock_quantity' => 0]);

        $this->assertFalse($product->is_in_stock);
    }

    /** @test */
    public function product_is_low_stock_when_quantity_less_than_or_equal_to_five()
    {
        $product = Product::factory()->create(['stock_quantity' => 3]);

        $this->assertTrue($product->is_low_stock);
    }

    /** @test */
    public function product_is_not_low_stock_when_quantity_greater_than_five()
    {
        $product = Product::factory()->create(['stock_quantity' => 10]);

        $this->assertFalse($product->is_low_stock);
    }

    /** @test */
    public function product_scope_active_returns_only_active_products()
    {
        Product::factory()->create(['status' => 'active']);
        Product::factory()->create(['status' => 'inactive']);
        Product::factory()->create(['status' => 'active']);

        $activeProducts = Product::active()->get();

        $this->assertCount(2, $activeProducts);
        $this->assertTrue($activeProducts->every(fn($product) => $product->status === 'active'));
    }

    /** @test */
    public function product_scope_featured_returns_only_featured_products()
    {
        Product::factory()->create(['featured' => true]);
        Product::factory()->create(['featured' => false]);
        Product::factory()->create(['featured' => true]);

        $featuredProducts = Product::featured()->get();

        $this->assertCount(2, $featuredProducts);
        $this->assertTrue($featuredProducts->every(fn($product) => $product->featured === true));
    }

    /** @test */
    public function product_scope_in_stock_returns_only_products_with_stock()
    {
        Product::factory()->create(['stock_quantity' => 5]);
        Product::factory()->create(['stock_quantity' => 0]);
        Product::factory()->create(['stock_quantity' => 10]);

        $inStockProducts = Product::inStock()->get();

        $this->assertCount(2, $inStockProducts);
        $this->assertTrue($inStockProducts->every(fn($product) => $product->stock_quantity > 0));
    }

    /** @test */
    public function product_scope_by_category_returns_products_in_specific_category()
    {
        $category1 = DeviceCategory::factory()->create();
        $category2 = DeviceCategory::factory()->create();

        Product::factory()->create(['category_id' => $category1->id]);
        Product::factory()->create(['category_id' => $category2->id]);
        Product::factory()->create(['category_id' => $category1->id]);

        $category1Products = Product::byCategory($category1->id)->get();

        $this->assertCount(2, $category1Products);
        $this->assertTrue($category1Products->every(fn($product) => $product->category_id === $category1->id));
    }

    /** @test */
    public function product_scope_search_returns_products_matching_search_term()
    {
        Product::factory()->create(['name' => 'iPhone 13']);
        Product::factory()->create(['name' => 'Samsung Galaxy']);
        Product::factory()->create(['name' => 'iPhone 12']);

        $searchResults = Product::search('iPhone')->get();

        $this->assertCount(2, $searchResults);
        $this->assertTrue($searchResults->every(fn($product) => str_contains($product->name, 'iPhone')));
    }

    /** @test */
    public function product_scope_by_vendor_returns_products_by_specific_vendor()
    {
        $vendor1 = User::factory()->create(['role' => 'vendor']);
        $vendor2 = User::factory()->create(['role' => 'vendor']);

        Product::factory()->create(['vendor_id' => $vendor1->id]);
        Product::factory()->create(['vendor_id' => $vendor2->id]);
        Product::factory()->create(['vendor_id' => $vendor1->id]);

        $vendor1Products = Product::byVendor($vendor1->id)->get();

        $this->assertCount(2, $vendor1Products);
        $this->assertTrue($vendor1Products->every(fn($product) => $product->vendor_id === $vendor1->id));
    }

    /** @test */
    public function product_can_reduce_stock()
    {
        $product = Product::factory()->create(['stock_quantity' => 10]);

        $product->reduceStock(3);

        $this->assertEquals(7, $product->fresh()->stock_quantity);
    }

    /** @test */
    public function product_can_increase_stock()
    {
        $product = Product::factory()->create(['stock_quantity' => 5]);

        $product->increaseStock(3);

        $this->assertEquals(8, $product->fresh()->stock_quantity);
    }

    /** @test */
    public function product_cannot_reduce_stock_below_zero()
    {
        $product = Product::factory()->create(['stock_quantity' => 2]);

        $this->expectException(\Exception::class);
        $product->reduceStock(5);
    }

    /** @test */
    public function product_has_correct_total_sales()
    {
        $product = Product::factory()->create();
        $order1 = Order::factory()->create(['status' => 'completed']);
        $order2 = Order::factory()->create(['status' => 'completed']);

        OrderItem::factory()->create([
            'product_id' => $product->id,
            'order_id' => $order1->id,
            'quantity' => 2,
            'unit_price' => 100.00,
        ]);
        OrderItem::factory()->create([
            'product_id' => $product->id,
            'order_id' => $order2->id,
            'quantity' => 1,
            'unit_price' => 100.00,
        ]);

        $this->assertEquals(300.00, $product->total_sales);
    }

    /** @test */
    public function product_has_correct_total_units_sold()
    {
        $product = Product::factory()->create();
        $order1 = Order::factory()->create(['status' => 'completed']);
        $order2 = Order::factory()->create(['status' => 'completed']);

        OrderItem::factory()->create([
            'product_id' => $product->id,
            'order_id' => $order1->id,
            'quantity' => 2,
        ]);
        OrderItem::factory()->create([
            'product_id' => $product->id,
            'order_id' => $order2->id,
            'quantity' => 3,
        ]);

        $this->assertEquals(5, $product->total_units_sold);
    }

    /** @test */
    public function product_has_correct_average_rating()
    {
        $product = Product::factory()->create();
        
        // Create some reviews (assuming there's a reviews relationship)
        // This would need to be implemented if review functionality is added
        
        $this->assertEquals(0, $product->average_rating);
    }

    /** @test */
    public function product_has_correct_discount_percentage()
    {
        $product = Product::factory()->create([
            'price' => 100.00,
            'original_price' => 120.00,
        ]);

        $this->assertEquals(16.67, $product->discount_percentage);
    }

    /** @test */
    public function product_has_no_discount_when_no_original_price()
    {
        $product = Product::factory()->create([
            'price' => 100.00,
            'original_price' => null,
        ]);

        $this->assertEquals(0, $product->discount_percentage);
    }
} 
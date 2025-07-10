<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\DeviceCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    /** @test */
    public function vendor_can_view_products_index()
    {
        $vendor = User::factory()->create(['role' => 'vendor']);
        $category = DeviceCategory::factory()->create();
        $product = Product::factory()->create([
            'vendor_id' => $vendor->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($vendor)->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    /** @test */
    public function buyer_can_view_products_index()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $category = DeviceCategory::factory()->create();
        $product = Product::factory()->create([
            'status' => 'active',
            'stock_quantity' => 10,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($buyer)->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    /** @test */
    public function vendor_can_create_product()
    {
        $vendor = User::factory()->create(['role' => 'vendor']);
        $category = DeviceCategory::factory()->create();

        $productData = [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 99.99,
            'stock_quantity' => 10,
            'category_id' => $category->id,
            'sku' => 'TEST-001',
            'featured' => true,
        ];

        $response = $this->actingAs($vendor)->post(route('products.store'), $productData);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'vendor_id' => $vendor->id,
            'sku' => 'TEST-001',
        ]);
    }

    /** @test */
    public function vendor_can_create_product_with_images()
    {
        $vendor = User::factory()->create(['role' => 'vendor']);
        $category = DeviceCategory::factory()->create();

        $image = UploadedFile::fake()->image('product.jpg');

        $productData = [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 99.99,
            'stock_quantity' => 10,
            'category_id' => $category->id,
            'sku' => 'TEST-002',
            'images' => [$image],
        ];

        $response = $this->actingAs($vendor)->post(route('products.store'), $productData);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'sku' => 'TEST-002',
        ]);
    }

    /** @test */
    public function vendor_can_update_own_product()
    {
        $vendor = User::factory()->create(['role' => 'vendor']);
        $category = DeviceCategory::factory()->create();
        $product = Product::factory()->create([
            'vendor_id' => $vendor->id,
            'category_id' => $category->id,
        ]);

        $updateData = [
            'name' => 'Updated Product',
            'description' => 'Updated Description',
            'price' => 149.99,
            'stock_quantity' => 20,
            'category_id' => $category->id,
            'sku' => $product->sku,
            'status' => 'active',
        ];

        $response = $this->actingAs($vendor)->put(route('products.update', $product), $updateData);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'price' => 149.99,
        ]);
    }

    /** @test */
    public function vendor_cannot_update_other_vendor_product()
    {
        $vendor1 = User::factory()->create(['role' => 'vendor']);
        $vendor2 = User::factory()->create(['role' => 'vendor']);
        $category = DeviceCategory::factory()->create();
        $product = Product::factory()->create([
            'vendor_id' => $vendor1->id,
            'category_id' => $category->id,
        ]);

        $updateData = [
            'name' => 'Updated Product',
            'description' => 'Updated Description',
            'price' => 149.99,
            'stock_quantity' => 20,
            'category_id' => $category->id,
            'sku' => $product->sku,
            'status' => 'active',
        ];

        $response = $this->actingAs($vendor2)->put(route('products.update', $product), $updateData);

        $response->assertStatus(403);
    }

    /** @test */
    public function vendor_can_delete_own_product()
    {
        $vendor = User::factory()->create(['role' => 'vendor']);
        $category = DeviceCategory::factory()->create();
        $product = Product::factory()->create([
            'vendor_id' => $vendor->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($vendor)->delete(route('products.destroy', $product));

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /** @test */
    public function buyer_can_view_product_details()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $category = DeviceCategory::factory()->create();
        $product = Product::factory()->create([
            'status' => 'active',
            'stock_quantity' => 10,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($buyer)->get(route('products.show', $product));

        $response->assertStatus(200);
        $response->assertSee($product->name);
        $response->assertSee($product->description);
    }

    /** @test */
    public function products_can_be_filtered_by_category()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $category1 = DeviceCategory::factory()->create(['name' => 'Category 1']);
        $category2 = DeviceCategory::factory()->create(['name' => 'Category 2']);
        
        $product1 = Product::factory()->create([
            'category_id' => $category1->id,
            'status' => 'active',
            'stock_quantity' => 10,
        ]);
        $product2 = Product::factory()->create([
            'category_id' => $category2->id,
            'status' => 'active',
            'stock_quantity' => 10,
        ]);

        $response = $this->actingAs($buyer)->get(route('products.index', ['category_id' => $category1->id]));

        $response->assertStatus(200);
        $response->assertSee($product1->name);
        $response->assertDontSee($product2->name);
    }

    /** @test */
    public function products_can_be_searched()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $category = DeviceCategory::factory()->create();
        
        $product1 = Product::factory()->create([
            'name' => 'iPhone 13',
            'category_id' => $category->id,
            'status' => 'active',
            'stock_quantity' => 10,
        ]);
        $product2 = Product::factory()->create([
            'name' => 'Samsung Galaxy',
            'category_id' => $category->id,
            'status' => 'active',
            'stock_quantity' => 10,
        ]);

        $response = $this->actingAs($buyer)->get(route('products.index', ['search' => 'iPhone']));

        $response->assertStatus(200);
        $response->assertSee($product1->name);
        $response->assertDontSee($product2->name);
    }

    /** @test */
    public function buyer_cannot_create_product()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $category = DeviceCategory::factory()->create();

        $response = $this->actingAs($buyer)->get(route('products.create'));

        $response->assertStatus(403);
    }

    /** @test */
    public function unauthenticated_user_cannot_access_products()
    {
        $response = $this->get(route('products.index'));

        $response->assertRedirect(route('login'));
    }
} 
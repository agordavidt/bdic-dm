<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('unique_identifier')->unique(); // PG or serial number
            $table->string('device_type');
            $table->string('model');
            $table->string('brand')->nullable();
            $table->text('specifications')->nullable();
            $table->foreignId('category_id')->constrained('device_categories');
            $table->foreignId('vendor_id')->constrained('users'); // Vendor who registered
            $table->foreignId('buyer_id')->nullable()->constrained('users'); // Current owner (optional, for future use)
            $table->string('buyer_name'); // Vendor-provided buyer name
            $table->string('buyer_email'); // Vendor-provided buyer email
            $table->string('buyer_phone'); // Vendor-provided buyer phone
            $table->string('buyer_address'); // Vendor-provided buyer address
            $table->enum('status', ['active', 'needs_attention', 'replacement_needed', 'stolen'])->default('active');
            $table->decimal('price', 10, 2)->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('warranty_expiry')->nullable();
            $table->json('metadata')->nullable(); // Additional flexible data
            $table->timestamps();

            $table->index(['vendor_id', 'status']);
            $table->index(['buyer_id', 'status']);
            $table->index('unique_identifier');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
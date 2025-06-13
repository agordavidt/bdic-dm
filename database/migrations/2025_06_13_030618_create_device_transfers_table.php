<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('device_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained('devices');
            $table->foreignId('from_user_id')->nullable()->constrained('users');
            $table->foreignId('to_user_id')->constrained('users');
            $table->enum('transfer_type', ['sale', 'transfer', 'return']);
            $table->decimal('amount', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('transfer_date');
            $table->timestamps();
            
            $table->index(['device_id', 'transfer_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('device_transfers');
    }
};
<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buyer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('full_name');
            $table->string('phone');
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('id_type')->nullable(); // License, Passport, etc
            $table->string('id_number')->nullable();
            $table->enum('buyer_type', ['individual', 'institution', 'corporate'])->default('individual');
            $table->string('institution_name')->nullable();
            $table->string('tax_id')->nullable();
            $table->timestamps();
            
            $table->unique('user_id');
            $table->index(['buyer_type', 'city']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buyer_profiles');
    }
};
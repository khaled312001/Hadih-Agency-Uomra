<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_provider_id')->nullable()->constrained('service_providers')->onDelete('set null');
            $table->foreignId('umrah_package_id')->constrained()->onDelete('cascade');
            $table->string('beneficiary_name');
            $table->string('beneficiary_phone');
            $table->text('beneficiary_address')->nullable();
            $table->enum('beneficiary_type', ['deceased', 'sick', 'elderly', 'disabled']);
            $table->text('beneficiary_details')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->string('currency', 3)->default('SAR');
            $table->enum('status', ['pending', 'assigned', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->datetime('assigned_at')->nullable();
            $table->datetime('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
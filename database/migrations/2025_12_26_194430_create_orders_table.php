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
            $table->foreignId('customer_id')->constrained()->restrictOnDelete();
            $table->foreignId('order_store_id')->constrained('stores')->restrictOnDelete();
            $table->foreignId('employee_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->timestamp('ordered_at');
            $table->enum('status',['received', 'canceled', 'completed']);
            $table->integer('total_amount');
            $table->enum('delivery_type', ['pickup', 'delivery']);
            $table->foreignId('pickup_store_id')->nullable()->constrained('stores')->nullOnDelete();
            $table->string('delivery_address')->nullable();
            $table->time('delivery_from')->nullable();
            $table->time('delivery_to')->nullable();
            $table->boolean('has_benefit')->default(false);
            $table->text('note')->nullable();
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

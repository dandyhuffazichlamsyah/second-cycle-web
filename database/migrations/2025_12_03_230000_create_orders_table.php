<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            // Payment Type: cash, dp, credit
            $table->enum('payment_type', ['cash', 'dp', 'credit'])->default('cash');
            
            // Pricing
            $table->unsignedBigInteger('product_price');
            $table->unsignedBigInteger('dp_amount')->nullable(); // Down payment amount
            $table->unsignedBigInteger('remaining_amount')->nullable(); // Remaining after DP
            $table->integer('credit_months')->nullable(); // Credit duration in months
            $table->unsignedBigInteger('monthly_payment')->nullable(); // Monthly installment
            
            // Customer Info
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email');
            $table->text('customer_address');
            $table->string('customer_ktp')->nullable(); // KTP number for credit
            
            // Status: pending, approved, rejected, processing, completed, cancelled
            $table->enum('status', ['pending', 'approved', 'rejected', 'processing', 'completed', 'cancelled'])->default('pending');
            
            $table->text('notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

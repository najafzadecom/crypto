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
        Schema::create('balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('currency', 10)->default('AZN');
            $table->decimal('amount', 15, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['user_id', 'currency']);
            $table->index(['currency']);
        });

        Schema::create('balance_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('sender_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('transaction_id')->unique();
            $table->enum('type', ['deposit', 'withdrawal', 'transfer_in', 'transfer_out', 'admin_adjustment'])->default('deposit');
            $table->decimal('amount', 15, 2);
            $table->string('currency', 10)->default('AZN');
            $table->string('payment_method')->nullable(); // card, crypto, etc.
            $table->string('crypto_address')->nullable();
            $table->string('crypto_transaction_id')->nullable();
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status']);
            $table->index(['sender_id']);
            $table->index(['transaction_id']);
            $table->index(['type', 'status']);
            $table->index(['created_at']);
        });

        Schema::create('transfer_settings', function (Blueprint $table) {
            $table->id();
            $table->string('currency', 10)->default('AZN');
            $table->decimal('min_amount', 15, 2)->default(1);
            $table->decimal('max_amount', 15, 2)->default(1000);
            $table->decimal('fee_percentage', 5, 2)->default(0);
            $table->decimal('fee_fixed', 15, 2)->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
            
            $table->unique(['currency']);
        });

        Schema::create('deposit_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('currency', 10);
            $table->enum('type', ['card', 'crypto', 'manual'])->default('manual');
            $table->decimal('min_amount', 15, 2)->default(1);
            $table->decimal('max_amount', 15, 2)->default(1000);
            $table->decimal('fee_percentage', 5, 2)->default(0);
            $table->decimal('fee_fixed', 15, 2)->default(0);
            $table->text('instructions')->nullable();
            $table->string('qr_code')->nullable();
            $table->string('deposit_address')->nullable();
            $table->json('settings')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            
            $table->index(['currency', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposit_methods');
        Schema::dropIfExists('transfer_settings');
        Schema::dropIfExists('balance_transactions');
        Schema::dropIfExists('balances');
    }
};

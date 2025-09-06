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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name')->nullable();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('telegram')->nullable();
            $table->string('phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->foreignId('birth_country_id')->nullable()->constrained('countries')->nullOnDelete();
            $table->foreignId('birth_region_id')->nullable()->constrained('regions')->nullOnDelete();

            $table->foreignId('residence_country_id')->nullable()->constrained('countries')->nullOnDelete();
            $table->foreignId('residence_region_id')->nullable()->constrained('regions')->nullOnDelete();
            $table->string('residence_address')->nullable();

            $table->string('education')->nullable();
            $table->string('job')->nullable();
            $table->string('position')->nullable();

            $table->string('twitter')->nullable();
            $table->string('wallet_address')->nullable();
            $table->text('bio')->nullable();

            $table->timestamp('profile_blocked_until')->nullable();
            $table->timestamp('last_profile_update')->nullable();

            $table->rememberToken();
            $table->boolean('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

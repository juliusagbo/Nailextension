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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_type')->nullable(); // 'admin' or 'customer'
            $table->string('user_name');
            $table->string('user_role')->nullable(); // 'Owner', 'Customer', etc.
            $table->string('action'); // 'NEW BOOKING', 'PAYMENT PROCESSED', 'SERVICE ADDED', etc.
            $table->text('details');
            $table->string('ip_address');
            $table->string('user_agent')->nullable();
            $table->string('model_type')->nullable(); // App\Models\Appointment, App\Models\Gallery, etc.
            $table->unsignedBigInteger('model_id')->nullable();
            $table->json('old_values')->nullable(); // For tracking changes
            $table->json('new_values')->nullable(); // For tracking changes
            $table->timestamps();
            
            $table->index(['user_id', 'user_type']);
            $table->index(['model_type', 'model_id']);
            $table->index('action');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};

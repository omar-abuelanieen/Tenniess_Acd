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
        Schema::create('subscribtions', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->foreignId('player_id')->constrained()->onDelete('cascade');
            $table->foreignId('training_session_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('active');
            $table->string('payment_status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscribtions');
    }
};

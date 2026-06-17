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
      Schema::create('login_attempts', function (Blueprint $table) {

    $table->id();

    $table->string('email')->index();

    $table->string('ip_address')->index();

    $table->unsignedInteger('failed_attempts')->default(0);

    $table->unsignedInteger('lock_level')->default(0);

    $table->timestamp('locked_until')->nullable();

    $table->timestamps();

    $table->unique(['email', 'ip_address']);

});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_attempts');
    }
};

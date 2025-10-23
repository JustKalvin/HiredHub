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
        Schema::create('user_reminds', function (Blueprint $table) {
            $table->id('user_remind_id');
            $table->string('user_email');
            $table->string('user_keyword');
            $table->string('user_geoId');
            $table->timestamps();

            // Unique constraint gabungan antara email dan keyword
            $table->unique(['user_email', 'user_keyword'], 'unique_user_email_keyword');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_reminds');
    }
};

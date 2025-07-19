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
        Schema::create('pastebins', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('stored_names')->unique();
            $table->string('title');
            $table->string('mime_type');
            $table->unsignedBigInteger('size');
            $table->string('extension', 20);
            $table->string('password')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->unsignedBigInteger('download_count')->default(0);
            $table->unsignedBigInteger('view_count')->default(0);
            $table->string('delete_token', 64)->nullable()->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pastebins');
    }
};

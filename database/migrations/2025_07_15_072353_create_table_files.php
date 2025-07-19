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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); 
            $table->string('stored_name')->unique(); 
            $table->string('original');
            $table->string('mime_type'); 
            $table->unsignedBigInteger('size'); 
            $table->string('extension', 20);
            $table->string('password')->nullable(); 
            $table->unsignedBigInteger('download_count')->default(0);
            $table->unsignedBigInteger('view_count')->default(0);
            $table->ipAddress('uploader_ip')->nullable(); 
            $table->string('delete_token', 64)->nullable()->unique(); 
            $table->timestamp('expires_at')->nullable(); 
            $table->string('bulk_id')->nullable()->default('null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};

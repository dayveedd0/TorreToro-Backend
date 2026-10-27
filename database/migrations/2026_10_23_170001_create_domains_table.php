<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // 'global', 'uk'
            $table->string('name'); // 'Torre Tórò Global', 'Torre Tórò UK'
            $table->json('hostnames')->nullable(); // ["torretoro.com", "localhost"]
            $table->string('currency', 10)->default('NGN'); // 'NGN', 'GBP', 'USD'
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('social_links')->nullable();
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};

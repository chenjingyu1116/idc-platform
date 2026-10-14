<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('product_mappings', function (Blueprint $t) {
            $t->id();
            $t->foreignId('product_id')->constrained()->onDelete('cascade');
            $t->foreignId('provider_id')->constrained()->onDelete('cascade');
            $t->string('upstream_product_id');
            $t->json('upstream_config')->nullable();
            $t->timestamps();
            $t->unique(['product_id', 'provider_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('product_mappings'); }
};

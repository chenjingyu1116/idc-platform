<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->string('slug')->unique();
            $t->text('description')->nullable(); $t->decimal('price',12,2);
            $t->string('billing_cycle',20); $t->json('config')->nullable();
            $t->integer('stock')->default(-1); $t->boolean('is_active')->default(true); $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('products'); }
};

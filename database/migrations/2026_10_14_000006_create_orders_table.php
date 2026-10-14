<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $t) {
            $t->id(); $t->string('order_no',32)->unique();
            $t->foreignId('user_id')->constrained()->onDelete('cascade');
            $t->foreignId('product_id')->constrained();
            $t->integer('quantity')->default(1); $t->decimal('total_amount',12,2);
            $t->string('status',20)->default('pending'); $t->timestamp('paid_at')->nullable(); $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('orders'); }
};

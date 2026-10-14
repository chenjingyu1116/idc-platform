<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('payments', function (Blueprint $t) {
            $t->id();
            $t->string('trade_no',64)->unique();
            $t->foreignId('user_id')->constrained()->onDelete('cascade');
            $t->string('payable_type',50);   // order 或 recharge
            $t->unsignedBigInteger('payable_id');
            $t->decimal('amount',12,2);
            $t->string('gateway',30)->default('epay');
            $t->string('gateway_trade_no')->nullable();
            $t->string('status',20)->default('pending'); // pending / paid / failed / refunded
            $t->json('payload')->nullable();
            $t->timestamp('paid_at')->nullable();
            $t->timestamps();
            $t->index(['payable_type','payable_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('payments'); }
};

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('transactions', function (Blueprint $t) {
            $t->id();
            $t->string('trade_no', 64)->unique();
            $t->string('out_trade_no', 64)->nullable();
            $t->foreignId('user_id')->constrained()->onDelete('cascade');
            $t->decimal('amount', 12, 2);
            $t->string('type', 20);
            $t->unsignedBigInteger('ref_id')->nullable();
            $t->string('gateway', 50);
            $t->string('gateway_trade_no')->nullable();
            $t->string('status', 20)->default('pending');
            $t->json('gateway_response')->nullable();
            $t->timestamp('paid_at')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('transactions'); }
};

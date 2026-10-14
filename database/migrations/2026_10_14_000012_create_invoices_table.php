<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('invoices', function (Blueprint $t) {
            $t->id();
            $t->string('invoice_no', 32)->unique();
            $t->foreignId('user_id')->constrained()->onDelete('cascade');
            $t->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $t->decimal('subtotal', 12, 2);
            $t->decimal('tax', 12, 2)->default(0);
            $t->decimal('total', 12, 2);
            $t->string('status', 20)->default('unpaid');
            $t->string('title')->nullable();
            $t->date('due_date')->nullable();
            $t->timestamp('paid_at')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('invoices'); }
};

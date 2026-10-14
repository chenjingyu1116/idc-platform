<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('commissions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('agent_id')->constrained()->onDelete('cascade');
            $t->foreignId('order_id')->constrained()->onDelete('cascade');
            $t->decimal('amount', 12, 2);
            $t->decimal('rate', 5, 2);
            $t->string('status', 20)->default('pending');
            $t->timestamp('settled_at')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('commissions'); }
};

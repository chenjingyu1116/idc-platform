<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('withdrawals', function (Blueprint $t) {
            $t->id();
            $t->foreignId('agent_id')->constrained()->onDelete('cascade');
            $t->decimal('amount', 12, 2);
            $t->string('account_type', 30);
            $t->string('account_no');
            $t->string('status', 20)->default('pending');
            $t->text('remark')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('withdrawals'); }
};

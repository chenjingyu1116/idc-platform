<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('agents', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->onDelete('cascade');
            $t->string('code', 32)->unique();
            $t->string('level', 20)->default('bronze');
            $t->decimal('commission_rate', 5, 2)->default(10.00);
            $t->decimal('total_earned', 12, 2)->default(0);
            $t->decimal('withdrawable', 12, 2)->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('agents'); }
};

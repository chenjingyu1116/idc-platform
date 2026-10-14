<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('renewals', function (Blueprint $t) {
            $t->id();
            $t->foreignId('service_id')->constrained()->onDelete('cascade');
            $t->foreignId('user_id')->constrained()->onDelete('cascade');
            $t->decimal('amount',12,2);
            $t->string('cycle',20)->default('monthly');
            $t->timestamp('started_at')->nullable();
            $t->timestamp('expires_at')->nullable();
            $t->string('status',20)->default('paid');
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('renewals'); }
};

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('provision_logs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('service_id')->nullable()->constrained()->onDelete('set null');
            $t->foreignId('provider_id')->nullable()->constrained()->onDelete('set null');
            $t->string('action', 50);
            $t->string('status', 20);
            $t->text('request')->nullable();
            $t->text('response')->nullable();
            $t->text('message')->nullable();
            $t->timestamps();
            $t->index(['service_id','created_at']);
        });
    }
    public function down(): void { Schema::dropIfExists('provision_logs'); }
};

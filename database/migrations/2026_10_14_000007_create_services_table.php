<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('services', function (Blueprint $t) {
            $t->id(); $t->foreignId('user_id')->constrained()->onDelete('cascade');
            $t->foreignId('order_id')->constrained(); $t->foreignId('product_id')->constrained();
            $t->string('service_type',50)->default('vps');
            $t->string('provider_type',50)->nullable(); $t->unsignedBigInteger('provider_id')->nullable();
            $t->string('upstream_product_id')->nullable(); $t->string('upstream_service_id')->nullable();
            $t->string('ip_address',45)->nullable(); $t->string('username')->nullable();
            $t->text('password_encrypted')->nullable(); $t->json('resource_config')->nullable();
            $t->string('status',20)->default('pending');
            $t->timestamp('activated_at')->nullable(); $t->timestamp('expires_at')->nullable();
            $t->timestamps(); $t->softDeletes();
        });
    }
    public function down(): void { Schema::dropIfExists('services'); }
};

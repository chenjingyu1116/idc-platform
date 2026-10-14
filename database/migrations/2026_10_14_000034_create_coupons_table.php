<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('coupons', function (Blueprint $t) {
            $t->id();
            $t->string('code', 32)->unique();
            $t->string('name');
            $t->string('type', 20)->default('fixed');
            $t->decimal('value', 12, 2);
            $t->decimal('min_amount', 12, 2)->default(0);
            $t->integer('total')->default(-1);
            $t->integer('used')->default(0);
            $t->timestamp('expires_at')->nullable();
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('coupon_user', function (Blueprint $t) {
            $t->id();
            $t->foreignId('coupon_id')->constrained()->onDelete('cascade');
            $t->foreignId('user_id')->constrained()->onDelete('cascade');
            $t->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $t->timestamp('used_at')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('coupon_user');
        Schema::dropIfExists('coupons');
    }
};

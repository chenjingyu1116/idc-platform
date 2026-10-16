<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('orders', function (Blueprint $t) {
            if (!Schema::hasColumn('orders', 'coupon_id')) {
                $t->unsignedBigInteger('coupon_id')->nullable()->after('product_id');
            }
            if (!Schema::hasColumn('orders', 'discount_amount')) {
                $t->decimal('discount_amount', 12, 2)->default(0)->after('total_amount');
            }
        });
    }
    public function down(): void {
        Schema::table('orders', function (Blueprint $t) {
            if (Schema::hasColumn('orders', 'coupon_id')) $t->dropColumn('coupon_id');
            if (Schema::hasColumn('orders', 'discount_amount')) $t->dropColumn('discount_amount');
        });
    }
};

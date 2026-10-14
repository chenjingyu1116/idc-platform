<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('member_levels', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->integer('min_spent')->default(0);
            $t->decimal('discount', 5, 2)->default(100);
            $t->integer('points_multiplier')->default(1);
            $t->string('color', 20)->default('#FF9EC4');
            $t->timestamps();
        });
        Schema::table('users', function (Blueprint $t) {
            $t->integer('points')->default(0)->after('balance');
            $t->integer('total_spent')->default(0)->after('points');
            $t->unsignedBigInteger('member_level_id')->nullable()->after('total_spent');
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $t) {
            $t->dropColumn(['points','total_spent','member_level_id']);
        });
        Schema::dropIfExists('member_levels');
    }
};

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('settings', function (Blueprint $t) {
            $t->id();
            $t->string('key', 100)->unique();
            $t->text('value')->nullable();
            $t->string('group_name', 50)->default('general');
            $t->string('type', 20)->default('string');
            $t->string('label')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('settings'); }
};

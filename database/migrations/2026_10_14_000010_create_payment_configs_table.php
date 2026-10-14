<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('payment_configs', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('driver', 50);
            $t->string('api_url')->nullable();
            $t->string('pid')->nullable();
            $t->string('key_secret')->nullable();
            $t->string('notify_url')->nullable();
            $t->string('return_url')->nullable();
            $t->json('extra')->nullable();
            $t->boolean('is_active')->default(true);
            $t->integer('sort')->default(0);
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('payment_configs'); }
};

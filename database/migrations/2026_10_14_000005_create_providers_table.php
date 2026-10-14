<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('providers', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->string('driver',50)->default('manual');
            $t->string('api_url')->nullable(); $t->text('credentials_encrypted')->nullable();
            $t->json('config')->nullable(); $t->boolean('is_active')->default(true); $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('providers'); }
};

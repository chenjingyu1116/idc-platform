<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('tickets', function (Blueprint $t) {
            $t->id(); $t->foreignId('user_id')->constrained()->onDelete('cascade');
            $t->string('title'); $t->text('content');
            $t->string('status',20)->default('open'); $t->text('reply')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('tickets'); }
};

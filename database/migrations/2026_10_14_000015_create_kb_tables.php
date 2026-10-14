<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('kb_categories', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->string('slug')->unique();
            $t->text('description')->nullable(); $t->integer('sort')->default(0); $t->timestamps();
        });
        Schema::create('kb_articles', function (Blueprint $t) {
            $t->id();
            $t->foreignId('category_id')->constrained('kb_categories')->onDelete('cascade');
            $t->string('title'); $t->string('slug')->unique();
            $t->longText('content'); $t->integer('views')->default(0);
            $t->boolean('is_published')->default(true); $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('kb_articles'); Schema::dropIfExists('kb_categories'); }
};

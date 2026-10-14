<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('ticket_replies', function (Blueprint $t) {
            $t->id();
            $t->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $t->foreignId('user_id')->constrained()->onDelete('cascade');
            $t->boolean('is_admin')->default(false);
            $t->text('content');
            $t->timestamps();
        });
        Schema::table('tickets', function (Blueprint $t) {
            $t->string('category',30)->default('technical')->after('title');
            $t->string('priority',20)->default('normal')->after('category');
        });
    }
    public function down(): void {
        Schema::dropIfExists('ticket_replies');
        Schema::table('tickets', function (Blueprint $t) {
            $t->dropColumn(['category','priority']);
        });
    }
};

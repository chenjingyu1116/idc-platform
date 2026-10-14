<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('notification_logs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $t->string('channel', 20);
            $t->string('event', 50);
            $t->string('title');
            $t->text('content')->nullable();
            $t->string('status', 20)->default('pending');
            $t->text('error')->nullable();
            $t->timestamp('sent_at')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('notification_logs'); }
};

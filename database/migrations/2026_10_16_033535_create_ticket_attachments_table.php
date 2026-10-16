<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (Schema::hasTable('ticket_attachments')) return;
        Schema::create('ticket_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_reply_id')->constrained()->onDelete('cascade');
            $table->string('filename');
            $table->string('path');
            $table->integer('size')->default(0);
            $table->string('mime', 100)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('ticket_attachments');
    }
};

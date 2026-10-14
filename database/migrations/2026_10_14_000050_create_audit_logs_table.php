<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('audit_logs')) {
            Schema::create('audit_logs', function (Blueprint $t) {
                $t->id();
                $t->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
                $t->string('event', 100);
                $t->string('auditable_type')->nullable();
                $t->unsignedBigInteger('auditable_id')->nullable();
                $t->json('old_values')->nullable();
                $t->json('new_values')->nullable();
                $t->string('ip_address', 45)->nullable();
                $t->string('user_agent')->nullable();
                $t->timestamps();
                $t->index(['event', 'created_at']);
            });
            echo "✅ audit_logs 表已创建\n";
        }
    }
    public function down(): void {
        Schema::dropIfExists('audit_logs');
    }
};

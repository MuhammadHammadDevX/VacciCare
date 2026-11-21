<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('notification_id');
            $table->enum('recipient_type', ['admin', 'hospital', 'parent', 'all'])->default('all');
            $table->unsignedInteger('recipient_id')->default(0);
            $table->string('title', 255);
            $table->text('message');
            $table->string('type', 50)->default('info');
            $table->string('link', 255)->default('');
            $table->boolean('is_read')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

            $table->index(['recipient_type', 'recipient_id', 'is_read'], 'idx_recip');
            $table->index('created_at', 'idx_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};

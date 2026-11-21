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
        Schema::create('parents', function (Blueprint $table) {
            $table->increments('parent_id');
            $table->unsignedInteger('user_id')->unique();
            $table->string('parent_name', 100);
            $table->string('phone', 30);
            $table->text('address')->nullable();
            $table->timestamps();

            $table->foreign('user_id', 'fk_parents_user')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parents');
    }
};

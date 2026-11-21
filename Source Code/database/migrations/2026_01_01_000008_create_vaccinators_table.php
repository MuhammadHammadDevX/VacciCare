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
        Schema::create('vaccinators', function (Blueprint $table) {
            $table->increments('vaccinator_id');
            $table->unsignedInteger('user_id')->unique();
            $table->unsignedInteger('hospital_id');
            $table->string('name', 100);
            $table->string('qualification', 150);
            $table->string('phone', 30);
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

            $table->foreign('user_id', 'fk_vaccinators_user')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('hospital_id', 'fk_vaccinators_hospital')
                ->references('hospital_id')
                ->on('hospitals')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccinators');
    }
};

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
        Schema::create('hospitals', function (Blueprint $table) {
            $table->increments('hospital_id');
            $table->unsignedInteger('user_id');
            $table->string('hospital_name', 150);
            $table->string('hospital_type', 100);
            $table->string('license_no', 100)->unique();
            $table->string('email', 150);
            $table->string('phone', 30);
            $table->string('city', 100);
            $table->text('address');
            $table->string('contact_person', 100);
            $table->string('working_hours', 100);
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();

            $table->foreign('user_id', 'fk_hospitals_user')
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
        Schema::dropIfExists('hospitals');
    }
};

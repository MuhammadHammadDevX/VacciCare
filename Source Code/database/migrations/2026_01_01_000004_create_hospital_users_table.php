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
        Schema::create('hospital_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hospital_name', 150);
            $table->string('hospital_type', 50);
            $table->string('registration_number', 100)->nullable();
            $table->string('email', 150)->unique();
            $table->string('phone', 20);
            $table->text('address');
            $table->string('city', 100);
            $table->string('province', 100);
            $table->string('password', 255);
            $table->string('role', 20)->default('hospital');
            $table->rememberToken();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospital_users');
    }
};

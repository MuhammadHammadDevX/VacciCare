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
        Schema::create('hospital_vaccines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hospital_id')->index();
            $table->string('vaccine_name', 150);
            $table->text('description')->nullable();
            $table->enum('availability', ['Available', 'Unavailable'])->default('Available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospital_vaccines');
    }
};

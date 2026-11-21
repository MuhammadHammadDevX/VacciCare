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
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('booking_id');
            $table->unsignedInteger('parent_id');
            $table->unsignedInteger('child_id');
            $table->unsignedInteger('hospital_id');
            $table->unsignedInteger('vaccine_id');
            $table->unsignedInteger('vaccinator_id');
            $table->date('booking_date');
            $table->time('booking_time');
            $table->enum('status', ['Pending', 'Confirmed', 'Completed', 'Cancelled'])->default('Pending');
            $table->timestamps();

            $table->foreign('parent_id', 'fk_bookings_parent')
                ->references('parent_id')
                ->on('parents')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('child_id', 'fk_bookings_child')
                ->references('child_id')
                ->on('children')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('hospital_id', 'fk_bookings_hospital')
                ->references('hospital_id')
                ->on('hospitals')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('vaccine_id', 'fk_bookings_vaccine')
                ->references('vaccine_id')
                ->on('vaccines')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('vaccinator_id', 'fk_bookings_vaccinator')
                ->references('vaccinator_id')
                ->on('vaccinators')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

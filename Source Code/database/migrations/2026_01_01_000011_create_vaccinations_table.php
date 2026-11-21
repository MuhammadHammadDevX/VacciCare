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
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->increments('vaccination_id');
            $table->unsignedInteger('child_id');
            $table->unsignedInteger('vaccine_id');
            $table->unsignedInteger('hospital_id');
            $table->unsignedInteger('vaccinator_id');
            $table->date('vaccination_date');
            $table->time('vaccination_time');
            $table->enum('status', ['Completed', 'Pending', 'Cancelled'])->default('Pending');
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

            $table->foreign('child_id', 'fk_vaccinations_child')
                ->references('child_id')
                ->on('children')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('vaccine_id', 'fk_vaccinations_vaccine')
                ->references('vaccine_id')
                ->on('vaccines')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('hospital_id', 'fk_vaccinations_hospital')
                ->references('hospital_id')
                ->on('hospitals')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('vaccinator_id', 'fk_vaccinations_vaccinator')
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
        Schema::dropIfExists('vaccinations');
    }
};

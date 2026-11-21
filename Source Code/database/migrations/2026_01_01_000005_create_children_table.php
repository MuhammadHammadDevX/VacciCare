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
        Schema::create('children', function (Blueprint $table) {
            $table->increments('child_id');
            $table->unsignedInteger('parent_id');
            $table->string('child_name', 100);
            $table->date('date_of_birth');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('blood_group', 5)->nullable();
            $table->string('contact', 30)->nullable();
            $table->text('additional_notes')->nullable();
            $table->enum('vaccination_status', ['Up to Date', 'Pending', 'Partially Vaccinated'])->default('Pending');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

            $table->foreign('parent_id', 'fk_children_parent')
                ->references('parent_id')
                ->on('parents')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};

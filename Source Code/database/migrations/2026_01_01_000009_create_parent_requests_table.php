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
        Schema::create('parent_requests', function (Blueprint $table) {
            $table->increments('request_id');
            $table->unsignedInteger('parent_id');
            $table->unsignedInteger('child_id');
            $table->unsignedInteger('hospital_id');
            $table->integer('hospital_vaccine_id')->nullable();
            $table->string('request_type', 100);
            $table->date('request_date');
            $table->time('preferred_time')->nullable();
            $table->text('message')->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->unsignedInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->foreign('parent_id', 'fk_parent_requests_parent')
                ->references('parent_id')
                ->on('parents')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('child_id', 'fk_parent_requests_child')
                ->references('child_id')
                ->on('children')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('hospital_id', 'fk_parent_requests_hospital')
                ->references('hospital_id')
                ->on('hospitals')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('reviewed_by', 'fk_parent_requests_reviewer')
                ->references('user_id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_requests');
    }
};

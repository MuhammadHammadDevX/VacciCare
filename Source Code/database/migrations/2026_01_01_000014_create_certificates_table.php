<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->increments('certificate_id');
            $table->unsignedInteger('child_id');
            $table->string('certificate_number')->unique();
            $table->string('verification_token', 64)->unique();
            $table->timestamp('issued_at')->useCurrent();
            $table->timestamps();

            $table->foreign('child_id', 'fk_certificates_child')
                ->references('child_id')
                ->on('children')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};

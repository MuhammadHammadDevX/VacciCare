<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hospital_vaccines', function (Blueprint $table) {
            $table->integer('stock_quantity')->default(50)->after('availability');
            $table->string('batch_number', 50)->nullable()->after('stock_quantity');
            $table->date('expiry_date')->nullable()->after('batch_number');
            $table->integer('low_stock_threshold')->default(10)->after('expiry_date');
        });
    }

    public function down(): void
    {
        Schema::table('hospital_vaccines', function (Blueprint $table) {
            $table->dropColumn(['stock_quantity', 'batch_number', 'expiry_date', 'low_stock_threshold']);
        });
    }
};

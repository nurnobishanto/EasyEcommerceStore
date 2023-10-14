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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('delivery_method')->nullable();
            $table->string('delivery_id')->nullable();
            $table->double('delivery_fee')->nullable();
            $table->string('delivery_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('delivery_method');
            $table->dropColumn('delivery_id');
            $table->dropColumn('delivery_fee');
            $table->dropColumn('delivery_status');
        });
    }
};

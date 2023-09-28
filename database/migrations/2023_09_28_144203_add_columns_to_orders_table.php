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
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->string('trxid')->nullable();
            $table->string('sent_from')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_method_id');
            $table->dropColumn('paid_amount');
            $table->dropColumn('trxid');
            $table->dropColumn('sent_from');
        });
    }
};

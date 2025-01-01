<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('donasi_detail', function (Blueprint $table) {
            $table->string('payment_type')->nullable()->after('status_pembayaran');
            $table->text('payment_details')->nullable()->after('payment_type');
        });
    }

    public function down()
    {
        Schema::table('donasi_detail', function (Blueprint $table) {
            $table->dropColumn(['payment_type', 'payment_details']);
        });
    }
};

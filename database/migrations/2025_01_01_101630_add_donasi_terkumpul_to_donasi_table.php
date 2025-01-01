<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('donasi', function (Blueprint $table) {
            if (!Schema::hasColumn('donasi', 'donasi_terkumpul')) {
                $table->bigInteger('donasi_terkumpul')->default(0)->after('target_donasi');
            }
        });
    }

    public function down()
    {
        Schema::table('donasi', function (Blueprint $table) {
            $table->dropColumn('donasi_terkumpul');
        });
    }
};

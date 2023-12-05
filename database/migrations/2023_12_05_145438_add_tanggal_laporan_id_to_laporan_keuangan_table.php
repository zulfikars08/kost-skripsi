<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTanggalLaporanIdToLaporanKeuanganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laporan_keuangan', function (Blueprint $table) {
            //
            $table->uuid('tanggal_laporan_id')->after('id')->nullable();

            $table->foreign('tanggal_laporan_id')->references('id')->on('tanggal_laporan')
            ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laporan_keuangan', function (Blueprint $table) {
            //
        });
    }
}

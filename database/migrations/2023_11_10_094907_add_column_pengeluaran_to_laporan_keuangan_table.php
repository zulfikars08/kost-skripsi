<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPengeluaranToLaporanKeuanganTable extends Migration
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
            $table->uuid('pengeluaran_id')->after('pemasukan_id')->nullable();
            
            $table->foreign('pengeluaran_id')->references('id')->on('pengeluaran') 
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
            $table->dropForeign('pengeluaran_id');
        });
    }
}

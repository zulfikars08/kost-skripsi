<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToLaporanKeuanganTable extends Migration
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
            $table->unsignedBigInteger('pemasukan_id')->after('kategori_id')->nullable();
            
            $table->foreign('pemasukan_id')->references('id')->on('pemasukan') 
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
            $table->dropForeign('pemasukan_id');
        });
    }
}

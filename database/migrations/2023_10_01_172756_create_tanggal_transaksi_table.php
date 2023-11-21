<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTanggalTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanggal_transaksi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('bulan'); // Menggunakan huruf kecil
            $table->string('tahun');
            $table->uuid('transaksi_id')->nullable(); 
            $table->timestamps();
            $table->unique(['bulan', 'tahun']);
            $table->integer('created_by')->nullable()->default(null);
            $table->integer('updated_by')->nullable()->default(null);
            $table->integer('deleted_by')->nullable()->default(null);
            $table->dateTime('deleted_at')->nullable()->default(null);
            // Menambahkan batasan unik pada kolom 'bulan' dan 'tahun'
            
            $table->foreign('transaksi_id')->references('id')->on('transaksi')
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
        Schema::dropIfExists('tanggal_transaksi');
    }
}

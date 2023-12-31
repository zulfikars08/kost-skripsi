<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemasukanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemasukan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('kamar_id')->nullable();
            $table->uuid('lokasi_id')->nullable(); 
            $table->uuid('transaksi_id')->nullable();
            $table->date('bulan')->nullable();
            $table->string('tahun')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('kode_pemasukan')->nullable();
            $table->enum('tipe_pembayaran', ['tunai', 'non-tunai'])->nullable()->default(null);
            $table->enum('status_pembayaran', ['lunas', 'belum_lunas', 'cicil'])->nullable()->default(null);
            $table->date('tanggal_pembayaran_awal')->nullable()->default(null);
            $table->date('tanggal_pembayaran_akhir')->nullable()->default(null);
            $table->binary('bukti_pembayaran')->nullable()->default(null);
            $table->string('kategori')->nullable();
            $table->string('nama_kos')->nullable();
            $table->integer('jumlah')->nullable()->default(0);
            $table->string('keterangan')->nullable();
            $table->timestamps();
            $table->integer('created_by')->nullable()->default(null);
            $table->integer('updated_by')->nullable()->default(null);
            $table->integer('deleted_by')->nullable()->default(null);
            $table->dateTime('deleted_at')->nullable()->default(null);

            
            $table->foreign('kamar_id')->references('id')->on('kamar')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('lokasi_id')->references('id')->on('lokasi_kos') // Added foreign key for lokasi_id
            ->onUpdate('cascade')->onDelete('cascade');

              
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
        Schema::dropIfExists('pemasukan');
    }
}

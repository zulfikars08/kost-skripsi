<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanKeuanganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_keuangan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lokasi_id')->nullable(); 
            $table->unsignedBigInteger('kamar_id')->nullable(); 
            $table->unsignedBigInteger('transaksi_id')->nullable(); 
            $table->unsignedBigInteger('penyewa_id')->nullable(); 
            $table->unsignedBigInteger('kategori_id')->nullable();
            $table->string('kode_laporan')->nullable();
            $table->enum('tipe_pembayaran', ['tunai', 'non-tunai'])->nullable()->default(null);
            $table->binary('bukti_pembayaran')->nullable()->default(null);
            $table->date('tanggal_pembayaran_awal')->nullable()->default(null);
            $table->date('tanggal_pembayaran_akhir')->nullable()->default(null);
            $table->enum('status_pembayaran', ['lunas', 'belum_lunas', 'cicil'])->nullable()->default(null);
            $table->string('nama_kos')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('bulan')->nullable();
            $table->string('tahun')->nullable();
            $table->integer('total_pendapatan')->nullable();
            $table->string('kode_pemasukan')->nullable();
            $table->string('kode_pengeluaran')->nullable();
            $table->integer('pemasukan')->nullable();
            $table->integer('pengeluaran')->nullable();
            $table->enum('jenis', ['pemasukan', 'pengeluaran'])->nullable()->default(null);
            $table->string('keterangan')->nullable();
            $table->integer('jumlah')->nullable();
            $table->integer('pendapatan_bersih')->nullable();
            $table->timestamps();
            $table->integer('created_by')->nullable()->default(null);
            $table->integer('updated_by')->nullable()->default(null);
            $table->integer('deleted_by')->nullable()->default(null);
            $table->dateTime('deleted_at')->nullable()->default(null);
            
            $table->foreign('kamar_id')->references('id')->on('kamar')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('lokasi_id')->references('id')->on('lokasi_kos') 
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('transaksi_id')->references('id')->on('transaksi') 
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('penyewa_id')->references('id')->on('penyewa') 
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('kategori_id')->references('id')->on('kategori') 
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
        Schema::dropIfExists('laporan_keuangan');
    }
}

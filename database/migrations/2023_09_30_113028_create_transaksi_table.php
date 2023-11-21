<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('kamar_id')->nullable();
            $table->uuid('lokasi_id')->nullable(); //
            $table->uuid('penyewa_id')->nullable();
            $table->integer('jumlah_tarif')->nullable()->default(0);
            $table->date('tanggal')->nullable();
            $table->enum('tipe_pembayaran', ['tunai', 'non-tunai'])->nullable()->default(null);
            $table->binary('bukti_pembayaran')->nullable()->default(null);
            $table->date('tanggal_pembayaran_awal')->nullable()->default(null);
            $table->date('tanggal_pembayaran_akhir')->nullable()->default(null);
            $table->enum('status_pembayaran', ['lunas', 'belum_lunas', 'cicil'])->nullable()->default(null);
            $table->integer('kebersihan')->nullable()->default(0);
            $table->integer('pengeluaran')->nullable()->default(0);
            $table->string('keterangan')->nullable()->default(null);
            $table->timestamps();
            $table->integer('created_by')->nullable()->default(null);
            $table->integer('updated_by')->nullable()->default(null);
            $table->integer('deleted_by')->nullable()->default(null);
            $table->dateTime('deleted_at')->nullable()->default(null);

            $table->foreign('kamar_id')->references('id')->on('kamar')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('lokasi_id')->references('id')->on('lokasi_kos') // Added foreign key for lokasi_id
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('penyewa_id')->references('id')->on('penyewa')
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
        Schema::dropIfExists('transaksi');
    }
}

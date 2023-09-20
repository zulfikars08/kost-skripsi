<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenyewaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penyewa', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('no_kamar');
            $table->unsignedBigInteger('kamar_id')->nullable();
            $table->unsignedBigInteger('penghuni_id')->nullable();
            $table->unsignedBigInteger('lokasi_id'); // Added lokasi_id column
            $table->enum('tipe_pembayaran', ['tunai', 'non-tunai']);
            $table->integer('jumlah_tarif');
            $table->binary('bukti_pembayaran')->nullable();
            $table->date('tanggal_pembayaran_awal')->nullable();
            $table->date('tanggal_pembayaran_akhir')->nullable();
            $table->string('keterangan');
            $table->enum('status_pembayaran', ['lunas', 'belum_lunas', 'cicil']);
            $table->enum('status_penyewa',['aktif','tidak_aktif']);
            $table->timestamps();
            $table->integer('created_by')->nullable()->default(null);
            $table->integer('updated_by')->nullable()->default(null);
            $table->integer('deleted_by')->nullable()->default(null);
            $table->dateTime('deleted_at')->nullable()->default(null);
            
            $table->foreign('kamar_id')->references('id')->on('kamar')
                ->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('penghuni_id')->references('id')->on('penghuni')
                ->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('lokasi_id')->references('id')->on('lokasi_kos') // Added foreign key for lokasi_id
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
        Schema::dropIfExists('penyewa');
    }
}

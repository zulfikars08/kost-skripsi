<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTanggalKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanggal_karyawan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('lokasi_id')->nullable(); 
            $table->uuid('kamar_id')->nullable(); 
            $table->string('nama_kos')->nullable(); 
            $table->string('tahun')->nullable(); 
            $table->string('bulan')->nullable();
            $table->date('tanggal')->nullable(); 
            $table->timestamps();

             $table->foreign('lokasi_id')->references('id')->on('lokasi_kos') 
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('kamar_id')->references('id')->on('kamar') 
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
        Schema::dropIfExists('tanggal_karyawan');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTanggalInvestorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanggal_investor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lokasi_id')->nullable(); 
            $table->string('nama_kos')->nullable(); 
            $table->string('tahun')->nullable(); 
            $table->string('bulan')->nullable();
            $table->string('jumlah_investor')->nullable();
            $table->date('tanggal')->nullable(); 
            $table->timestamps();

             $table->foreign('lokasi_id')->references('id')->on('lokasi_kos') 
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
        Schema::dropIfExists('tanggal_investor');
    }
}

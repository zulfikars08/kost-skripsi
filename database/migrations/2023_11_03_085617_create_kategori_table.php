<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('transaksi_id')->nullable();
            $table->uuid('lokasi_id')->nullable();
            $table->uuid('penyewa_id')->nullable();
            $table->string('kategori')->nullable();
            $table->string('jumlah')->nullable();
            $table->integer('total_pendapatan')->nullable();
            $table->timestamps();
            $table->integer('created_by')->nullable()->default(null);
            $table->integer('updated_by')->nullable()->default(null);
            $table->integer('deleted_by')->nullable()->default(null);
            $table->dateTime('deleted_at')->nullable()->default(null);
            
            $table->foreign('lokasi_id')->references('id')->on('lokasi_kos') 
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('transaksi_id')->references('id')->on('transaksi') 
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
        Schema::dropIfExists('kategori');
    }
}

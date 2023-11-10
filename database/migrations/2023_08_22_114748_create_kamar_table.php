<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKamarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kamar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lokasi_id'); // Foreign key to lokasi_kos table
            $table->string('nama_investor')->nullable();
            $table->string('no_kamar');
            $table->integer('harga');
            $table->string('fasilitas');
            $table->string('keterangan');
            $table->timestamps();
            
            // Define the foreign key constraint
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
        Schema::dropIfExists('kamar');
    }
}

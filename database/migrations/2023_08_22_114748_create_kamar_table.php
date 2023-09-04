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
            $table->unsignedBigInteger('kost_id'); // Foreign key to lokasi_kos table
            $table->string('no_kamar');
            $table->integer('harga');
            $table->string('fasilitas');
            $table->string('keterangan');
            $table->timestamps();
            
            // Define the foreign key constraint
            $table->foreign('kost_id')->references('id')->on('lokasi_kos')
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

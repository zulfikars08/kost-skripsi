<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFasilitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('lokasi_id')->nullable(); 
            $table->string('nama_fasilitas')->nullable();
            $table->timestamps();
        });

        Schema::create('fasilitas_kamar', function (Blueprint $table) {
            $table->uuid('kamar_id');
            $table->uuid('fasilitas_id');
            $table->primary(['kamar_id', 'fasilitas_id']);

            $table->foreign('kamar_id')->references('id')->on('kamar')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('fasilitas_id')->references('id')->on('fasilitas')
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
        Schema::dropIfExists('fasilitas_kamar');
        Schema::dropIfExists('fasilitas');
    }
}

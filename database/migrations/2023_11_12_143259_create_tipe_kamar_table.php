<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipeKamarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipe_kamar', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('lokasi_id')->nullable(); 
            $table->uuid('kamar_id')->nullable(); 
            $table->enum('tipe_kamar', ['AC', 'Non-AC'])->nullable()->default(null);
            $table->string('nama_kos')->nullable()->default(null);
            $table->string('no_kamar')->nullable()->default(null); 
            $table->timestamps();

            $table->foreign('kamar_id')->references('id')->on('kamar')
            ->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('tipe_kamar');
    }
}

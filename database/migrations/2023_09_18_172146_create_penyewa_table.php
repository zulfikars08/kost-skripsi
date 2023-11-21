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
            $table->uuid('id')->primary();
            // $table->index('id');
            $table->string('kode_penyewa')->nullable();
            $table->string('nama')->nullable();
            $table->string('nama_kos')->nullable();
            $table->string('no_kamar')->nullable();
            $table->uuid('kamar_id')->nullable();
            $table->uuid('lokasi_id')->nullable(); // Added lokasi_id column
            $table->enum('status_penyewa',['aktif','tidak_aktif']);
            $table->timestamps();
            $table->integer('created_by')->nullable()->default(null);
            $table->integer('updated_by')->nullable()->default(null);
            $table->integer('deleted_by')->nullable()->default(null);
            $table->dateTime('deleted_at')->nullable()->default(null);
            
            $table->foreign('kamar_id')->references('id')->on('kamar')
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

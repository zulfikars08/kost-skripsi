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
            $table->unsignedBigInteger('kamar_id');
            $table->unsignedBigInteger('penghuni_id');
            $table->string('tipe_pembayaran');
            $table->integer('jumlah_tarif');
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');
            $table->string('keterangan');
            $table->string('status_pembayaran');
            $table->timestamps();
            $table->integer('created_by')->nullable()->default(null);
            $table->integer('updated_by')->nullable()->default(null);
            $table->integer('deleted_by')->nullable()->default(null);
            $table->dateTime('deleted_at')->nullable()->default(null);

            $table->foreign('kamar_id')->references('id')->on('kamar')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('penghuni_id')->references('id')->on('penyewa')
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investor', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama')->nullable();
            $table->uuid('kamar_id')->nullable();
            $table->uuid('lokasi_id')->nullable();
            $table->integer('jumlah_pintu')->nullable();
            $table->integer('jumlah_investor')->nullable();
            $table->string('bulan')->nullable();
            $table->string('tahun')->nullable();
            $table->string('no_kamar')->nullable();
            $table->string('nama_kos')->nullable();
            $table->integer('pendapatan_bersih')->nullable();
            $table->timestamps();
            $table->integer('created_by')->nullable()->default(null);
            $table->integer('updated_by')->nullable()->default(null);
            $table->integer('deleted_by')->nullable()->default(null);
            $table->dateTime('deleted_at')->nullable()->default(null);
            $table->unique(['nama', 'kamar_id', 'lokasi_id']);
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
        Schema::dropIfExists('investor');
    }
}

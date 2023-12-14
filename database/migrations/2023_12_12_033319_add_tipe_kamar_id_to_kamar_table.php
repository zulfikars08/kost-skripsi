<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipeKamarIdToKamarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kamar', function (Blueprint $table) {
            //
            $table->uuid('tipe_kamar_id')->after('lokasi_id')->nullable();

            $table->foreign('tipe_kamar_id')->references('id')->on('tipe_kamar')
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
        Schema::table('kamar', function (Blueprint $table) {
            //
            $table->dropForeign('tipe_kamar_id');
        });
    }
}

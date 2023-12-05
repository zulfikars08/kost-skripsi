<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTanggalInvestorIdToInvestorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investor', function (Blueprint $table) {
            //
             //
             $table->uuid('tanggal_investor_id')->after('id')->nullable();

             $table->foreign('tanggal_investor_id')->references('id')->on('tanggal_investor')
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
        Schema::table('investor', function (Blueprint $table) {
            //
        });
    }
}

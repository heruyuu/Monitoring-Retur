<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaktursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fakturs', function (Blueprint $table) {
            $table->id();
            $table->string('kd_toko',25);
            $table->foreign('kd_toko')->references('kd_toko')->on('tokos')->onDelete('cascade');
            $table->string('no_faktur',75);
            $table->date('tgl_faktur');
            $table->date('tgl_tiba');
            $table->string('pejabat',50);
            $table->string('no_plat_mu',15);
            $table->enum('status',['Belum Dilihat','Dilihat','Selesai'])->default('Belum Dilihat');
            $table->bigInteger('user_id');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fakturs');
    }
}

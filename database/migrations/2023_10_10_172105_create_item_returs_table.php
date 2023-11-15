<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemRetursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_returs', function (Blueprint $table) {
            $table->id();
            $table->string('kd_toko',25);
            $table->foreign('kd_toko')->references('kd_toko')->on('tokos')->onDelete('cascade');
            $table->unsignedBigInteger('faktur_id');
            $table->foreign('faktur_id')->references('id')->on('fakturs')->onDelete('cascade');
            $table->unsignedBigInteger('produk_id');
            $table->foreign('produk_id')->references('id')->on('produks')->onDelete('cascade');
            $table->string('qty',5)->nullable();
            $table->string('bta',5)->nullable();
            $table->string('sb',5)->nullable();
            $table->string('bl',5)->nullable();
            $table->string('bk',5)->nullable();
            $table->string('bnf',5)->nullable();
            $table->string('brp',5)->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('status',['Terima','Tolak'])->nullable();
            $table->text('catatan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_returs');
    }
}

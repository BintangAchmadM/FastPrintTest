<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('id_produk')->autoIncrement();
            $table->string('nama_produk');
            $table->decimal('harga', 10, 2);
            $table->unsignedBigInteger('kategori_id')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->timestamps();

        });

        Schema::table('products', function($table) {
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->nullable()->constrained('items')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('service_id')->nullable()->constrained('services')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('sale_id')->nullable()->constrained('sales')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('kuantitas_barang')->nullable();
            $table->integer('harga_satuan_barang')->nullable();
            $table->integer('subtotal_barang')->nullable();
            $table->string('keterangan_barang')->nullable();
            $table->integer('kuantitas_servis')->nullable();
            $table->integer('harga_satuan_servis')->nullable();
            $table->integer('subtotal_servis')->nullable();
            $table->string('keterangan_servis')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_details');
    }
}

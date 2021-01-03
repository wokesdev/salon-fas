<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('account_detail_id')->nullable()->constrained('account_details')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('account_detail_payment_id')->nullable()->constrained('account_details')->onUpdate('cascade')->onDelete('set null');
            $table->string('nomor_penjualan')->unique();
            $table->integer('total_barang')->nullable();
            $table->integer('total_servis')->nullable();
            $table->integer('total');
            $table->date('tanggal');
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
        Schema::dropIfExists('sales');
    }
}

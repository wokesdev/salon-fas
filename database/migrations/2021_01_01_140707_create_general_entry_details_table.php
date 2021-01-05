<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralEntryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_entry_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->nullable()->constrained('purchases')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('sale_id')->nullable()->constrained('sales')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('cash_payment_id')->nullable()->constrained('cash_payments')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('cash_receipt_id')->nullable()->constrained('cash_receipts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('account_detail_id')->nullable()->constrained('account_details')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('general_entry_id')->nullable()->constrained('general_entries')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('ledger_id')->nullable()->constrained('ledgers')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('debit');
            $table->integer('kredit');
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
        Schema::dropIfExists('general_entry_details');
    }
}

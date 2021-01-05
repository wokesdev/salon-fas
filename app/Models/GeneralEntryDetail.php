<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralEntryDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function general_entry()
    {
        return $this->belongsTo('App\Models\GeneralEntry', 'general_entry_id');
    }

    public function account_detail()
    {
        return $this->belongsTo('App\Models\AccountDetail', 'account_detail_id');
    }

    public function purchase()
    {
        return $this->belongsTo('App\Models\Purchase', 'purchase_id');
    }

    public function sale()
    {
        return $this->belongsTo('App\Models\Sale', 'sale_id');
    }

    public function cash_payment()
    {
        return $this->belongsTo('App\Models\CashPayment', 'cash_payment_id');
    }

    public function cash_receipt()
    {
        return $this->belongsTo('App\Models\CashReceipt', 'cash_receipt_id');
    }
}

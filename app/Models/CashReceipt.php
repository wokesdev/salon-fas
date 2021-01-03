<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashReceipt extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function account_detail()
    {
        return $this->belongsTo('App\Models\AccountDetail', 'account_detail_id');
    }
}

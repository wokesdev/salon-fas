<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function purchase()
    {
        return $this->belongsTo('App\Models\Purchase', 'purchase_id');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_id');
    }
}

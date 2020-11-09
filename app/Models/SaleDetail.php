<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function sale()
    {
        return $this->belongsTo('App\Models\Sale', 'sale_id');
    }
}

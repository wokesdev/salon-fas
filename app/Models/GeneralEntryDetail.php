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
}

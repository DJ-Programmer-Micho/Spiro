<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    use HasFactory;
    protected $table = 'cashes';
    protected $fillable = [
        'invoice_id', 

        'cash_date',
        'payments',
        
        'grand_total_dollar', 
        'due_dollar', 
        
        'grand_total_iraqi', 
        'due_iraqi',

        'cash_status',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class,'invocie_id');
    }
    
}

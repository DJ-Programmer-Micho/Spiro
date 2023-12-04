<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $fillable = [
        'payment_type', 
    ];

    public function quotation()
    {
        return $this->hasMany(Quotation::class,'payment_id');
    }
}

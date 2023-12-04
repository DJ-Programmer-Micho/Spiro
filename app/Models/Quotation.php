<?php

namespace App\Models;

// use App\Models\Branch;
// use App\Models\Client;
// use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quotation extends Model
{
    use HasFactory;
    protected $table = 'quotation';
    protected $fillable = [
        'branch_id', 
        'client_id', 
        'payment_id',
        'services',
        'discount',
        'tax',
        'change_rate',
        'total_amount', 
        'fully_paid_date', 
        'description', 
        'notes',
        'quotation_status',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}

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
    protected $table = 'quotations';
    protected $fillable = [
        'client_id', 
        'payment_id',
        'qoutation_date',

        'status',
        'services',

        'description',
        'services',
        'notes',

        'total_amount_dollar',
        'tax_dollar',
        'discount_dollar',
        'first_pay_dollar', 
        'grand_total_dollar', 
        'due_dollar', 

        'total_amount_iraqi',
        'tax_iraqi',
        'discount_iraqi',
        'first_pay_iraqi', 
        'grand_total_iraqi', 
        'due_iraqi', 

        'quotation_status',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}

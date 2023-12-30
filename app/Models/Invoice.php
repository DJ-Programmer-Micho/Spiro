<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoices';
    protected $fillable = [
        'quotation_id', 
        'client_id', 
        'payment_id',
        'invoice_date',

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

        'exchange_rate',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    // public function cash()
    // {
    //     return $this->belongsTo(Cash::class);
    // }

    public function cashes()
{
    return $this->hasMany(Cash::class, 'invoice_id');
}

}

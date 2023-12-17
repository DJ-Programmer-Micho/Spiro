<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';
        protected $fillable = [
        'client_name',
        'country',
        'city',
        'address', 
        'email', 
        'phone_one', 
        'phone_two', 
    ];
    // protected $fillable = [
    //     'client_name',
    //     'event_address',
    //     'event_type',
    //     'event_date',
 
    // ];

    public function quotation()
    {
        return $this->hasMany(Quotation::class,'client_id');
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class,'client_id');
    }
}

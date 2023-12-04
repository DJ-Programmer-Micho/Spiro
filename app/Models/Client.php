<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';
    protected $fillable = [
        'company_name',
        'client_name',
        'email',
        'address',
        'city',
        'country',
        'zipcode',
        'website',
        'phone_one',
        'phone_two',  
    ];

    public function quotation()
    {
        return $this->hasMany(Quotation::class,'client_id');
    }
}

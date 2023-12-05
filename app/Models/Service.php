<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = 'services';
    protected $fillable = [
        'service_code',
        'service_name',
        'service_description',
        'price_dollar',
        'price_iraqi'
    ];

    // public function branch()
    // {
    //     return $this->belongsTo(Branch::class);
    // }

}

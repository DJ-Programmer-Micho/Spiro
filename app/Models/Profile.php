<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $table = 'profiles';
    protected $fillable = [
        'job_title',
        'national_id',
        'phone_number_1',
        'phone_number_2',
        'email_address',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}

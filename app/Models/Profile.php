<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $table = 'profiles';
    protected $fillable = [
        'user_id',
        'job_title',
        'national_id',
        'avatar',
        'phone_number_1',
        'phone_number_2',
        'email_address',
        'salary_dollar',
        'salary_iraqi',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $table = 'branches';
    protected $fillable = [
        'branch_name',
        'branch_manager',
        'description', 
        'systematic'
    ];

    public function service()
    {
        return $this->hasMany(Service::class,'branch_id');
    }

    public function quotation()
    {
        return $this->hasMany(Quotation::class,'branch_id');
    }
}

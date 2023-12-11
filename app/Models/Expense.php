<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $table = 'expenses';
    protected $fillable = [
        'item',
        'type',
        'cost_dollar',
        'cost_iraqi',
        'description',
        'payed_date',
        'status',
    ];
}

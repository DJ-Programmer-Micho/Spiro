<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillsExpense extends Model
{
    use HasFactory;
    protected $table = 'bills_expenses';
    protected $fillable = [
        'bill_name',
        'description',
        'cost_dollar',
        'cost_iraqi',
        'status'
    ];
}
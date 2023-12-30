<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpTask extends Model
{
    use HasFactory;
    protected $table = 'emp_tasks';
    protected $fillable = [
        'invoice_id', 
        'tasks',
        'progress', 
        'task_status', 
        'status', 
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}

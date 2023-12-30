<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table = 'tasks';
    protected $fillable = [
        'task_option',
        'status',
    ];

    public function EmpTask()
    {
        return $this->hasMany(EmpTask::class,'client_id');
    }
}

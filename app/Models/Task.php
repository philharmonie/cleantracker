<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'date',
        'name',
        'points'
    ];

    protected $dates = [
        'date',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function count_of_tasks_with_same_name_for_user($id)
    {
        return Task::where('user_id', $id)->where('name', $this->name)->count();
    }
}

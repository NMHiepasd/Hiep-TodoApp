<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];

    protected $fillable = [
        'title',
        'user_id',
        'status',
        'created_at',
        'end_date',
    ];

    /**
     * Get the user that owns the task.
     */
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


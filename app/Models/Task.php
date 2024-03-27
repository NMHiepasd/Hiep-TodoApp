<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $squarded = ['id'];
    protected $fillable = ['title', 'description', 'create_date', 'end_date', 'status'];
}

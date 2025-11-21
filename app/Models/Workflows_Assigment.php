<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workflows_Assigment extends Model
{
    use HasFactory;
    protected $fillable = ['workflow_id', 'user_id', 'created_by'];
}

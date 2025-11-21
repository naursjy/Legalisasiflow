<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workflows extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'created_by'];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function stages()
    {
        return $this->hasMany(Stages::class, 'workflow_id')->orderBy('order');
    }
    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'workflow__assignments', 'workflow_id', 'user_id');
    }
}

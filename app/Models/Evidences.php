<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evidences extends Model
{
    use HasFactory;
    protected $fillable = ['stage_id', 'user_id', 'file_path', 'type', 'submitted_at'];
    public function stage()
    {
        return $this->belongsTo(Stages::class, 'stage_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

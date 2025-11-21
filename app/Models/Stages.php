<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stages extends Model
{
    use HasFactory;
    protected $fillable = ['workflow_id', 'name', 'description', 'order', 'required_evidence_type'];
    public function workflow()
    {
        return $this->belongsTo(Workflows::class, 'workflow_id');
    }
    public function evidences()
    {
        return $this->hasMany(Evidences::class, 'stage_id');
    }
}

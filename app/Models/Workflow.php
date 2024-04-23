<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'description',
        'project_id',
        'url'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function testSteps()
    {
        return $this->hasMany(TestStep::class);
    }

}

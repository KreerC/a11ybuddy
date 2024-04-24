<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workflow extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'name',
        'description',
        'project_id',
        'url'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function testSteps(): HasMany
    {
        return $this->hasMany(TestStep::class);
    }

}

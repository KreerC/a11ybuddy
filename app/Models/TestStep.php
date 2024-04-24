<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestStep extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'name',
        'description',
        'workflow_id',
        'url'
    ];

    public function workflow(): BelongsTo
    {
        return $this->belongsTo(Workflow::class);
    }

    public function testStepResults(): HasMany
    {
        return $this->hasMany(TestStepResult::class);
    }

}

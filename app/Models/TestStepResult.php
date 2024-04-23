<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestStepResult extends Model
{
    use HasFactory;

    public function testStep(): BelongsTo
    {
        return $this->belongsTo(TestStep::class);
    }

}

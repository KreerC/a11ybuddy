<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestStepResult extends Model
{
    use HasFactory;

    public function testStep()
    {
        return $this->belongsTo(TestStep::class);
    }

}

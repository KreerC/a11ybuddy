<?php

use App\Models\TestStepResult;
use App\Models\Workflow;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('test_steps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(Workflow::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('url')->nullable();
            $table->foreignIdFor(TestStepResult::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_steps');
    }
};

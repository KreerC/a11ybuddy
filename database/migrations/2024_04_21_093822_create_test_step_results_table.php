<?php

use App\Models\TestStep;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('test_step_results', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(TestStep::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->nullable();
            $table->string('based_on_test')->default('manual');
            $table->integer('blindness')->nullable();
            $table->integer('low_vision')->nullable();
            $table->integer('deafness')->nullable();
            $table->integer('motor_impairment')->nullable();
            $table->integer('learning_disability')->nullable();
            $table->integer('neurodivergent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_step_results');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('child_stats_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('doctor_id');
            $table->integer('parent_id');
            $table->integer('child_id');
            $table->string('weight');
            $table->string('height');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_stats_histories');
    }
};

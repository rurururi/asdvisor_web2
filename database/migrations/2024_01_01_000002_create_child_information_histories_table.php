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
        Schema::create('child_information_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('doctor_id');
            $table->integer('parent_id');
            $table->integer('child_id');
            $table->string('behavior');
            $table->string('assessment');
            $table->binary('image')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_information_histories');
    }
};

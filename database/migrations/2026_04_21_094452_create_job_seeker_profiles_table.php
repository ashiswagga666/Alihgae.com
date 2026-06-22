<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_seeker_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('phone')->nullable();
            $table->string('domicile')->nullable();
            $table->enum('education_level', ['SMA/SMK', 'D3', 'S1', 'S2', 'S3']);
            $table->string('cv_path')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->text('skills')->nullable();
            $table->text('work_experience')->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_seeker_profiles');
    }
};
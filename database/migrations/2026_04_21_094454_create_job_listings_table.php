<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->string('location');
            $table->enum('job_type', ['full-time', 'part-time', 'freelance', 'internship']);
            $table->unsignedBigInteger('salary_min')->nullable();
            $table->unsignedBigInteger('salary_max')->nullable();
            $table->enum('min_education', ['SMA/SMK', 'D3', 'S1', 'S2', 'S3']);
            $table->unsignedTinyInteger('min_experience')->default(0);
            $table->date('deadline');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('view_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('job_listing_id')->constrained()->cascadeOnDelete();
            $table->text('cover_letter')->nullable();
            $table->string('cv_path');
            $table->enum('status', ['pending', 'reviewed', 'interview', 'accepted', 'rejected'])->default('pending');
            $table->timestamp('applied_at')->useCurrent();
            $table->timestamps();
            $table->unique(['user_id', 'job_listing_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained('users');
            $table->string('job_title');
            $table->text('job_description');
            $table->text('qualifications');
            $table->string('location');
            $table->enum('job_type', ['full-time', 'part-time', 'contract', 'internship', 'remote'])->default('full-time');
            $table->decimal('salary_min', 10, 2)->nullable();
            $table->decimal('salary_max', 10, 2)->nullable();
            $table->string('industry')->nullable();
            $table->string('application_email');
            $table->string('application_phone')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'filled'])->default('pending');
            $table->date('deadline')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_postings');
    }
};
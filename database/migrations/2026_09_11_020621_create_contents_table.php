<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('category'); // Video, LKPD, Modul, dll
            $table->string('subject');  // Matematika, IPAS, dll
            $table->string('grade');    // Kelas 1 - 6
            $table->string('teacher_name');
            $table->string('school_name');
            $table->string('district_name');
            $table->string('license')->default('CC BY-NC-SA 4.0');
            $table->enum('status', [
                'DRAFT', 'SUBMITTED', 'IN_REVIEW', 'REVISION_REQUIRED', 'APPROVED', 'PUBLISHED', 'REJECTED'
            ])->default('SUBMITTED');
            $table->unsignedBigInteger('views_count')->default(0);
            $table->unsignedBigInteger('downloads_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
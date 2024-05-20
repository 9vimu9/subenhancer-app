<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('filteredword_enhancement', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('enhancement_id');
            $table->foreign('enhancement_id')->references('id')->on('enhancements')->onDelete('cascade');
            $table->unsignedBigInteger('captionword_id');
            $table->foreign('captionword_id')->references('id')->on('captionwords')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enhancement_vocabulary');
    }
};

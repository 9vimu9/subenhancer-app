<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enhancement_vocabulary', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('enhancement_id');
            $table->foreign('enhancement_id')->references('id')->on('enhancements')->onDelete('cascade');
            $table->unsignedBigInteger('vocabulary_id');
            $table->foreign('vocabulary_id')->references('id')->on('vocabularies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enhancement_vocabulary');
    }
};

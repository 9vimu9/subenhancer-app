<?php

declare(strict_types=1);

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
        Schema::create('captionwords', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('order_in_sentence');
            $table->unsignedBigInteger('sentence_id');
            $table->foreign('sentence_id')->references('id')->on('sentences')->onDelete('cascade');
            $table->unsignedBigInteger('corpus_id');
            $table->foreign('corpus_id')->references('id')->on('corpuses')->onDelete('cascade');
            $table->unsignedBigInteger('definition_id');
            $table->foreign('definition_id')->references('id')->on('definitions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('captionwords');
    }
};

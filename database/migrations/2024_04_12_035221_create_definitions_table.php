<?php

declare(strict_types=1);

use App\Enums\WordClassEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('definitions', function (Blueprint $table) {
            $table->id();
            $table->mediumText('definition');
            $table->unsignedBigInteger('corpus_id');
            $table->foreign('corpus_id')->references('id')->on('corpuses')->onDelete('cascade');
            $table->enum('word_class', [
                WordClassEnum::NOUN->name,
                WordClassEnum::VERB->name,
                WordClassEnum::ADJECTIVE->name,
                WordClassEnum::ADVERB->name,
                WordClassEnum::PREPOSITION->name,
                WordClassEnum::DETERMINER->name,
                WordClassEnum::PRONOUN->name,
                WordClassEnum::CONJUNCTION->name,
            ]);
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('definitions');
    }
};

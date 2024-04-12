<?php

declare(strict_types=1);

use App\Enums\VocabularyEnum;
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
        Schema::create('vocabularies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('captionword_id');
            $table->foreign('captionword_id')->references('id')->on('captionwords')->onDelete('cascade');
            $table->enum('vocabulary_type', [
                VocabularyEnum::FILTERED_OUT_AS_KNOWN_USING_THE_TEST->name,
                VocabularyEnum::MARKED_AS_KNOWN->name,
                VocabularyEnum::MARKED_AS_UNKNOWN->name,
                VocabularyEnum::HAVE_NOT_SPECIFIED->name,
            ])->default(VocabularyEnum::HAVE_NOT_SPECIFIED->name);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vocabularies');
    }
};

<?php

use App\Enums\UserVocabularyEstimationMethodsEnum;
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
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('uuid')->after('remember_token')->nullable();
            $table->enum('vocabulary_estimation_method', [
                UserVocabularyEstimationMethodsEnum::VOCABULARY_TEST->name,
                UserVocabularyEstimationMethodsEnum::SHOW_EACH_AND_EVERY_WORD->name])
                ->after('uuid')
                ->default(UserVocabularyEstimationMethodsEnum::SHOW_EACH_AND_EVERY_WORD->name);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('uuid');
            $table->dropColumn('vocabulary_estimation_method');
        });
    }
};

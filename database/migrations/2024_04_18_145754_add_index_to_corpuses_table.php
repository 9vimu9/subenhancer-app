<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('corpuses', function (Blueprint $table) {
            $table->index('word');
            $table->unique('word');
        });
    }

    public function down(): void
    {
        Schema::table('corpuses', function (Blueprint $table) {
            $table->dropIndex('corpuses_word_index');
            $table->dropUnique('corpuses_word_unique');
        });
    }
};

<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Captionword extends Model
{
    protected $fillable = ['order_in_sentence', 'sentence_id', 'corpus_id', 'definition_id'];

    use HasFactory;
}

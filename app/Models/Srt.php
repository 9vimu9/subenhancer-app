<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Srt extends Model
{
    use HasFactory;

    protected $fillable = ['file_location', 'md5_hash'];

    public function source(): MorphOne
    {
        return $this->morphOne(Source::class, 'sourceable');
    }
}

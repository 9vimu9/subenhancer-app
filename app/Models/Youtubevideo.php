<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Contracts\ResourceModels\ResourcableInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Youtubevideo extends Model implements ResourcableInterface
{
    use HasFactory;

    protected $fillable = ['video_id'];

    public function source(): MorphOne
    {
        return $this->morphOne(Source::class, 'sourceable');
    }
}

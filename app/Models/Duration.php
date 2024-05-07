<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duration extends Model
{
    use HasFactory;

    protected $fillable = ['start_time_in_millis', 'end_time_in_millis', 'source_id'];
}

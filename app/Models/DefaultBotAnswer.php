<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultBotAnswer extends Model
{
    use HasFactory;

    /**
     * The attributes that are assignable for a default bot answer.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question',
        'answer',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    /**
     * The attributes that are assignable for a User answer.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'message',
        'quantity',
        'bot_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

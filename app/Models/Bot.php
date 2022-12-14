<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    use HasFactory;

    /**
     * The attributes that are assignable for a Bot.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'greeting',
        'ip',
        'username',
        'password',
        'db_name',
        'table_names',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

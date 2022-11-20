<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableAnswer extends Model
{
    use HasFactory;

    /**
     * The attributes that are assignable for a User answer for a table.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'table_name',
        'quantity',
        'bot_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

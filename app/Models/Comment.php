<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content_id',
        'body',
    ];

    // Relasi ke User (pembuat komentar)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Content (karya yang dikomentari)
    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Like;
use App\Models\Comment;

class Content extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'category',
        'subject',
        'grade',
        'teacher_name',
        'school_name',
        'district_name',
        'file_url',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel Likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Cek apakah user tertentu sudah menyukai karya ini
    public function isLikedBy($user)
    {
        if (!$user) return false;
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    // Relasi ke tabel Comments
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
}
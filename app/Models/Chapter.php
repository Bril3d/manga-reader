<?php

namespace App\Models;

use App\Models\User;
use App\Models\Manga;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Chapter
 *
 */
class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'chapter_number',
        'manga_id',
        'user_id',
        'content'
    ];

    protected $casts = [
        'content' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function manga()
    {
        return $this->belongsTo(Manga::class, 'manga_id');
    }


    public function comments()
    {
        // order comments by reactions number, likes - dislikes then order by created at
        return $this->morphMany(Comment::class, 'commentable')
            ->select('comments.*')
            ->leftJoin('comments_reactions', 'comments.id', '=', 'comments_reactions.comment_id')
            ->groupBy('comments.id', 'comments.user_id', 'comments.commentable_id', 'comments.commentable_type', 'comments.content', 'comments.created_at', 'comments.updated_at', 'comments.deleted_at')
            ->orderByRaw('(COALESCE(SUM(CASE WHEN comments_reactions.type = 1 THEN 1 ELSE 0 END), 0) - COALESCE(SUM(CASE WHEN comments_reactions.type = 0 THEN 1 ELSE 0 END), 0)) DESC')
            ->orderBy('comments.created_at', 'desc');
    }

    public function views()
    {
        return $this->hasMany(View::class, 'key')->where('model', self::class);
    }

    public static function getTotalViews()
    {
        return View::where('model', self::class)->count();
    }
}

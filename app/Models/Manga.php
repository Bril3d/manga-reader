<?php

namespace App\Models;

use App\Models\Slider;
use App\Models\Chapter;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Manga
 *
 */
class Manga extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'author',
        'artist',
        'official_links',
        'track_links',
        'alternative_titles',
        'cover',
        'views',
        'rate',
        'likes',
        'user_id',
        'releaseDate',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function taxables()
    {
        return $this->morphMany(Taxable::class, 'taxable');
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'manga_id');
    }

    public function genres()
    {
        return $this->morphToMany(Taxonomy::class, 'taxable')->where('type', 'genre');
    }

    public function status()
    {
        return $this->morphToMany(Taxonomy::class, 'taxable')->where('type', 'manga_status');
    }

    public function types()
    {
        return $this->morphToMany(Taxonomy::class, 'taxable')->where('type', 'manga_type');
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

    public function slider()
    {
        return $this->hasMany(Slider::class, 'manga_id');
    }

    public function getTotalFavorites()
    {
        return $this->hasMany(Bookmark::class, 'manga_id')->count();
    }
}

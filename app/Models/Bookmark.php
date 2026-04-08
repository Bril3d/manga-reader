<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Bookmark
 *
 */
class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'manga_id',
        'collection_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function manga()
    {
        return $this->belongsTo(Manga::class);
    }

    // public function collection()
    // {
    //     return $this->belongsTo(BookmarkCollection::class, 'collection_id');
    // }

}

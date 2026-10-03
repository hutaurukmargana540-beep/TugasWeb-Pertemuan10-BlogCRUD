<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory, SoftDeletes; // BONUS: soft delete

    protected $fillable = ['title', 'content', 'image'];

    /** BONUS: pencarian — dipakai di PostController@index (?q=kata). */
    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        return $query->when($keyword, function (Builder $q) use ($keyword) {
            $q->where(fn (Builder $w) => $w
                ->where('title', 'like', "%{$keyword}%")
                ->orWhere('content', 'like', "%{$keyword}%"));
        });
    }

    /** URL gambar upload (null jika tidak ada gambar). */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    public function getExcerptAttribute(): string
    {
        return str($this->content)->limit(120)->toString();
    }
}

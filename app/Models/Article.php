<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'author',
        'summary',
        'content',
        'thumbnail_path',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected $appends = [
        'thumbnail_url',
    ];

    protected static function booted(): void
    {
        static::saving(function (Article $article) {
            if ($article->isDirty('title') || blank($article->slug) || !$article->exists) {
                $article->slug = static::generateUniqueSlug($article->title, $article->getKey());
            }

            if ($article->is_published && blank($article->published_at)) {
                $article->published_at = now();
            }
        });
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->latest('published_at');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail_path
            ? Storage::url($this->thumbnail_path)
            : null;
    }

    /**
     * Mutator to normalize image paths when saving
     */
    public function setContentAttribute($value): void
    {
        if (blank($value)) {
            $this->attributes['content'] = '';
            return;
        }

        // Normalize image paths to relative paths for storage
        // Convert full URLs back to relative paths for consistent storage
        $pattern = '/(<img[^>]+src=["\'])([^"\']+)(["\'][^>]*>)/i';
        
        $normalized = preg_replace_callback($pattern, function ($matches) {
            $src = $matches[2];
            
            // If it's a full URL with storage path, extract relative path
            if (str_contains($src, '/storage/')) {
                $relativePath = str_replace('/storage/', '', parse_url($src, PHP_URL_PATH));
                return $matches[1] . $relativePath . $matches[3];
            }
            
            // If it's already a relative path or starts with /storage, keep as is
            if (!str_starts_with($src, 'http://') && !str_starts_with($src, 'https://')) {
                return $matches[0];
            }
            
            return $matches[0];
        }, $value);

        $this->attributes['content'] = $normalized;
    }

    /**
     * Get content with processed image URLs for frontend display
     */
    public function getProcessedContentAttribute(): string
    {
        $content = $this->attributes['content'] ?? '';
        
        if (blank($content)) {
            return '';
        }

        // Convert relative image paths to full URLs
        // Filament RichEditor stores paths like "articles-media/filename.jpg"
        // We need to convert them to "/storage/articles-media/filename.jpg"
        $pattern = '/(<img[^>]+src=["\'])([^"\']+)(["\'][^>]*>)/i';
        
        return preg_replace_callback($pattern, function ($matches) {
            $src = $matches[2];
            
            // If it's already a full URL or starts with /storage, don't modify
            if (str_starts_with($src, 'http://') || str_starts_with($src, 'https://') || str_starts_with($src, '/storage/')) {
                return $matches[0];
            }
            
            // Convert relative path to storage URL
            $url = Storage::url($src);
            return $matches[1] . $url . $matches[3];
        }, $content);
    }

    protected static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 2;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn (Builder $query) => $query->whereKeyNot($ignoreId))
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}

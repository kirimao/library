<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'category_id',
        'publisher',
        'price',
        'cover_type',
        'year',
        'arrival_month',
        'arrival_year',
        'total_copies',
        'available_copies',
        'shelf_location',
        'cover_image',
        'cover_thumbnail',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'year' => 'integer',
        'arrival_month' => 'integer',
        'arrival_year' => 'integer',
        'total_copies' => 'integer',
        'available_copies' => 'integer',
    ];

    public function getArrivalMonthNameAttribute(): string
    {
        if (!$this->arrival_month) return '-';
        return __('common.months.' . $this->arrival_month);
    }

    /**
     * Determine if the book is considered a "Buku Baru" (arrival_year >= 2025).
     */
    public function isNewArrival(): bool
    {
        return $this->arrival_year && $this->arrival_year >= 2025;
    }

    /**
     * Get arrival status text ("Buku Baru" / "Buku Lama").
     */
    public function getArrivalStatusTextAttribute(): string
    {
        if (!$this->arrival_year) {
            return 'Buku Lama';
        }
        return $this->arrival_year >= 2025 ? 'Buku Baru' : 'Buku Lama';
    }

    /**
     * Get the category that owns the book.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all genres for this book.
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'book_genre');
    }

    /**
     * Get all loans for this book.
     */
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Get all reviews for this book.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(BookReview::class);
    }
}

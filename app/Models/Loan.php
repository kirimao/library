<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'member_id',
        'loan_date',
        'due_date',
        'return_date',
        'status',
        'reading_status',
        'fine_amount',
        'reported_lost_by',
        'reported_lost_at',
    ];

    protected $casts = [
        'loan_date' => 'datetime',
        'due_date' => 'date',
        'return_date' => 'datetime',
        'reported_lost_at' => 'datetime',
        'fine_amount' => 'decimal:2',
    ];

    /**
     * Get the book associated with this loan.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the member associated with this loan.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Get the review associated with this loan.
     */
    public function review(): HasOne
    {
        return $this->hasOne(BookReview::class);
    }

    /**
     * Get the user who reported this book as lost.
     */
    public function reportedLostBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_lost_by');
    }
}

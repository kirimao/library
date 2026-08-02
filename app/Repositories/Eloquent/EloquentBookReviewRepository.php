<?php

namespace App\Repositories\Eloquent;

use App\Models\BookReview;
use App\Repositories\Contracts\BookReviewRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentBookReviewRepository implements BookReviewRepositoryInterface
{
    public function create(array $data): BookReview
    {
        return BookReview::create($data);
    }

    public function getByBookId(int $bookId): Collection
    {
        return BookReview::with(['member', 'loan'])
            ->where('book_id', $bookId)
            ->latest()
            ->get();
    }

    public function getByMemberId(int $memberId): Collection
    {
        return BookReview::with(['book', 'loan'])
            ->where('member_id', $memberId)
            ->latest()
            ->get();
    }
}

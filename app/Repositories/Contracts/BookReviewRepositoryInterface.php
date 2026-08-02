<?php

namespace App\Repositories\Contracts;

use App\Models\BookReview;
use Illuminate\Database\Eloquent\Collection;

interface BookReviewRepositoryInterface
{
    public function create(array $data): BookReview;
    public function getByBookId(int $bookId): Collection;
    public function getByMemberId(int $memberId): Collection;
}

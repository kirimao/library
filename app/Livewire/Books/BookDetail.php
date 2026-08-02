<?php

namespace App\Livewire\Books;

use App\Actions\Book\GetBookReadersAction;
use App\Actions\Loan\AddBookReviewAction;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Repositories\Contracts\MemberRepositoryInterface;
use Exception;
use Livewire\Component;

class BookDetail extends Component
{
    public int $bookId;
    public ?int $selectedMemberId = null;
    public string $readingStatus = 'sedang_dibaca';
    public string $comment = '';

    public function mount(int $id)
    {
        $this->bookId = $id;
    }

    public function addReview(AddBookReviewAction $addBookReviewAction)
    {
        $this->validate([
            'selectedMemberId' => 'required|exists:members,id',
            'readingStatus'    => 'required|in:sedang_dibaca,selesai_dibaca,belum_selesai',
            'comment'          => 'required|string|min:3',
        ]);

        try {
            $addBookReviewAction->execute(
                $this->bookId,
                $this->selectedMemberId,
                $this->comment,
                null, // loanId = null karena ini baca langsung di perpus (on-site)
                $this->readingStatus
            );

            session()->flash('success', 'Ulasan/Komentar berhasil ditambahkan!');
            $this->reset(['selectedMemberId', 'readingStatus', 'comment']);
            $this->readingStatus = 'sedang_dibaca';
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render(
        BookRepositoryInterface $bookRepository,
        GetBookReadersAction $getBookReadersAction,
        MemberRepositoryInterface $memberRepository
    ) {
        $book = $bookRepository->findById($this->bookId);
        $readers = $getBookReadersAction->execute($this->bookId);
        $members = $memberRepository->all();

        return view('livewire.books.book-detail', compact('book', 'readers', 'members'))
            ->layout('layouts.app');
    }
}

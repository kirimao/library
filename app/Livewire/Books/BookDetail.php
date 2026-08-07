<?php

namespace App\Livewire\Books;

use App\Actions\Book\GetBookReadersAction;
use App\Actions\Loan\AddBookReviewAction;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Models\Member;
use Exception;
use Livewire\Component;

class BookDetail extends Component
{
    public int $bookId;
    public ?int $selectedMemberId = null;
    public string $memberSearch = '';
    public ?string $selectedMemberText = null;
    public string $readingStatus = 'sedang_dibaca';
    public string $comment = '';

    public function mount(int $id)
    {
        $this->bookId = $id;
    }

    public function selectMember(int $id, string $name, string $memberNumber)
    {
        $this->selectedMemberId = $id;
        $this->selectedMemberText = "{$memberNumber} — {$name}";
        $this->memberSearch = '';
    }

    public function clearMember()
    {
        $this->selectedMemberId = null;
        $this->selectedMemberText = null;
        $this->memberSearch = '';
    }

    public function addReview(AddBookReviewAction $addBookReviewAction)
    {
        $this->validate([
            'selectedMemberId' => 'required|exists:members,id',
            'readingStatus'    => 'required|in:sedang_dibaca,selesai_dibaca,belum_selesai',
            'comment'          => 'required|string|min:3',
        ], [
            'selectedMemberId.required' => 'Silakan pilih anggota terlebih dahulu.',
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
            $this->reset(['selectedMemberId', 'selectedMemberText', 'memberSearch', 'readingStatus', 'comment']);
            $this->readingStatus = 'sedang_dibaca';
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render(
        BookRepositoryInterface $bookRepository,
        GetBookReadersAction $getBookReadersAction
    ) {
        $book = $bookRepository->findById($this->bookId);
        $readers = $getBookReadersAction->execute($this->bookId);

        $members = [];
        if (strlen(trim($this->memberSearch)) >= 1) {
            $members = Member::query()
                ->where('status', 'active')
                ->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->memberSearch . '%')
                      ->orWhere('member_number', 'like', '%' . $this->memberSearch . '%')
                      ->orWhere('email', 'like', '%' . $this->memberSearch . '%');
                })
                ->limit(10)
                ->get(['id', 'name', 'member_number', 'member_type']);
        }

        return view('livewire.books.book-detail', compact('book', 'readers', 'members'))
            ->layout('layouts.app');
    }
}

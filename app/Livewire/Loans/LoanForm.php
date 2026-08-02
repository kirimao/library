<?php

namespace App\Livewire\Loans;

use App\Actions\Loan\BorrowBookAction;
use App\Models\Book;
use App\Models\Member;
use Exception;
use Livewire\Component;

class LoanForm extends Component
{
    public ?int $member_id = null;
    public string $memberSearch = '';
    public ?string $selectedMemberText = null;

    public ?int $book_id = null;
    public string $bookSearch = '';
    public ?string $selectedBookText = null;

    public ?string $due_date = null;

    public function mount()
    {
        $this->due_date = now()->addDays(config('library.default_loan_days', 7))->format('Y-m-d');
    }

    protected function rules()
    {
        return [
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'due_date' => 'required|date|after_or_equal:today',
        ];
    }

    public function selectMember(int $id, string $name, string $memberNumber)
    {
        $this->member_id = $id;
        $this->selectedMemberText = "{$memberNumber} — {$name}";
        $this->memberSearch = '';
    }

    public function clearMember()
    {
        $this->member_id = null;
        $this->selectedMemberText = null;
        $this->memberSearch = '';
    }

    public function selectBook(int $id, string $title, int $availableCopies, int $totalCopies)
    {
        if ($availableCopies <= 0) {
            return;
        }

        $this->book_id = $id;
        $this->selectedBookText = "{$title} (Stok: {$availableCopies}/{$totalCopies})";
        $this->bookSearch = '';
    }

    public function clearBook()
    {
        $this->book_id = null;
        $this->selectedBookText = null;
        $this->bookSearch = '';
    }

    public function submitLoan(BorrowBookAction $borrowBookAction)
    {
        $this->validate();

        try {
            $borrowBookAction->execute($this->member_id, $this->book_id, null, $this->due_date);
            session()->flash('success', __('loans.loan_success'));
            
            $this->reset(['member_id', 'memberSearch', 'selectedMemberText', 'book_id', 'bookSearch', 'selectedBookText']);
            $this->due_date = now()->addDays(config('library.default_loan_days', 7))->format('Y-m-d');
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
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

        $books = [];
        if (strlen(trim($this->bookSearch)) >= 1) {
            $books = Book::query()
                ->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->bookSearch . '%')
                      ->orWhere('isbn', 'like', '%' . $this->bookSearch . '%')
                      ->orWhere('author', 'like', '%' . $this->bookSearch . '%');
                })
                ->limit(10)
                ->get(['id', 'title', 'author', 'isbn', 'available_copies', 'total_copies']);
        }

        return view('livewire.loans.loan-form', compact('members', 'books'))
            ->layout('layouts.app');
    }
}

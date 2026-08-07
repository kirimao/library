<?php

namespace App\Livewire\Loans;

use App\Actions\Loan\CalculateFineAction;
use App\Actions\Loan\ReturnBookAction;
use App\Repositories\Contracts\LoanRepositoryInterface;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class ReturnForm extends Component
{
    use WithPagination;

    public string $search = '';
    public int|string $perPage = 10;

    // Modal state for return process
    public ?int $selectedLoanId = null;
    public ?object $selectedLoan = null;
    public float $calculatedFine = 0.0;
    public string $returnCondition = 'normal'; // 'normal' or 'lost'
    public ?float $lostFee = null;
    public string $readingStatus = 'selesai_dibaca';
    public string $comment = '';
    public bool $isReturnModalOpen = false;

    public function mount(): void
    {
        $allowed = [10, 25, 50, 100];
        $saved = session('perPage_return_loans', 10);
        $this->perPage = in_array((int)$saved, $allowed, true) ? (int)$saved : 10;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
        session(['perPage_return_loans' => (int) $this->perPage]);
    }

    public function openReturnModal(
        int $loanId,
        LoanRepositoryInterface $loanRepository,
        CalculateFineAction $calculateFineAction
    ) {
        $loan = $loanRepository->findById($loanId);
        $this->selectedLoanId = $loanId;
        $this->selectedLoan = $loan;
        $this->calculatedFine = $calculateFineAction->execute($loan->due_date, null, $loan->book);
        $this->returnCondition = 'normal';
        $this->lostFee = $loan->book?->price ? (float)$loan->book->price : (float)config('library.default_lost_book_fee', 50000);
        $this->readingStatus = 'selesai_dibaca';
        $this->comment = '';
        $this->isReturnModalOpen = true;
    }

    public function closeReturnModal()
    {
        $this->isReturnModalOpen = false;
        $this->reset(['selectedLoanId', 'selectedLoan', 'calculatedFine', 'returnCondition', 'lostFee', 'readingStatus', 'comment']);
    }

    public function confirmReturn(
        ReturnBookAction $returnBookAction,
        \App\Actions\Loan\ReportLostBookAction $reportLostBookAction
    ) {
        if (!$this->selectedLoanId) {
            return;
        }

        try {
            if ($this->returnCondition === 'lost') {
                $loan = $reportLostBookAction->execute($this->selectedLoanId, auth()->id(), $this->lostFee);
                session()->flash('success', 'Buku berhasil dilaporkan HILANG. Denda ganti rugi sebesar Rp ' . number_format($loan->fine_amount) . ' telah dicatat.');
            } else {
                $loan = $returnBookAction->execute(
                    $this->selectedLoanId,
                    null,
                    $this->readingStatus,
                    $this->comment
                );

                $fineMsg = $loan->fine_amount > 0
                    ? ' (' . __('loans.fine_calculated', ['amount' => 'Rp ' . number_format($loan->fine_amount)]) . ')'
                    : '';

                session()->flash('success', __('loans.return_success') . $fineMsg);
            }

            $this->closeReturnModal();
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render(
        LoanRepositoryInterface $loanRepository,
        CalculateFineAction $calculateFineAction
    ) {
        $loans = $loanRepository->paginate((int) $this->perPage, null, $this->search);

        foreach ($loans as $loan) {
            if (!in_array($loan->status, ['returned', 'hilang'])) {
                $loan->estimated_fine = $calculateFineAction->execute($loan->due_date);
            }
        }

        return view('livewire.loans.return-form', compact('loans'))
            ->layout('layouts.app');
    }
}

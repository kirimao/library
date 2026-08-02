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
    public int $perPage = 10;

    // Modal state for return process
    public ?int $selectedLoanId = null;
    public string $readingStatus = 'selesai_dibaca';
    public string $comment = '';
    public bool $isReturnModalOpen = false;

    public function openReturnModal(int $loanId)
    {
        $this->selectedLoanId = $loanId;
        $this->readingStatus = 'selesai_dibaca';
        $this->comment = '';
        $this->isReturnModalOpen = true;
    }

    public function closeReturnModal()
    {
        $this->isReturnModalOpen = false;
        $this->reset(['selectedLoanId', 'readingStatus', 'comment']);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmReturn(ReturnBookAction $returnBookAction)
    {
        if (!$this->selectedLoanId) return;

        try {
            $loan = $returnBookAction->execute(
                $this->selectedLoanId,
                null,
                $this->readingStatus,
                $this->comment
            );

            if ($loan->fine_amount > 0) {
                session()->flash('success', __('loans.return_success') . ' ' . __('loans.fine_calculated', ['amount' => 'Rp ' . number_format($loan->fine_amount)]));
            } else {
                session()->flash('success', __('loans.return_success'));
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
        $loans = $loanRepository->paginate($this->perPage, null, $this->search);

        foreach ($loans as $loan) {
            if ($loan->status !== 'returned') {
                $loan->estimated_fine = $calculateFineAction->execute($loan->due_date);
            }
        }

        return view('livewire.loans.return-form', compact('loans'))
            ->layout('layouts.app');
    }
}

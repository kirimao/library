<?php

namespace App\Livewire\Loans;

use App\Actions\Loan\CalculateFineAction;
use App\Actions\Loan\GetOverdueLoansAction;
use App\Actions\Loan\ReturnBookAction;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class OverdueList extends Component
{
    use WithPagination;

    public string $search = '';
    public int|string $perPage = 10;

    public function mount(): void
    {
        $allowed = [10, 25, 50, 100];
        $saved = session('perPage_overdue_loans', 10);
        $this->perPage = in_array((int)$saved, $allowed, true) ? (int)$saved : 10;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
        session(['perPage_overdue_loans' => (int) $this->perPage]);
    }

    public function processReturn(int $loanId, ReturnBookAction $returnBookAction)
    {
        try {
            $loan = $returnBookAction->execute($loanId);
            session()->flash('success', __('loans.return_success') . ' (' . __('loans.fine_calculated', ['amount' => 'Rp ' . number_format($loan->fine_amount)]) . ')');
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render(
        GetOverdueLoansAction $getOverdueLoansAction,
        CalculateFineAction $calculateFineAction
    ) {
        $overdueLoans = $getOverdueLoansAction->executePaginated((int) $this->perPage, $this->search);

        foreach ($overdueLoans->items() as $loan) {
            $loan->estimated_fine = $calculateFineAction->execute($loan->due_date);
        }

        return view('livewire.loans.overdue-list', compact('overdueLoans'))
            ->layout('layouts.app');
    }
}

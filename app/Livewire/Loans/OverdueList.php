<?php

namespace App\Livewire\Loans;

use App\Actions\Loan\CalculateFineAction;
use App\Actions\Loan\GetOverdueLoansAction;
use App\Actions\Loan\ReturnBookAction;
use Exception;
use Livewire\Component;

class OverdueList extends Component
{
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
        $overdueLoans = $getOverdueLoansAction->execute();

        foreach ($overdueLoans as $loan) {
            $loan->estimated_fine = $calculateFineAction->execute($loan->due_date);
        }

        return view('livewire.loans.overdue-list', compact('overdueLoans'))
            ->layout('layouts.app');
    }
}

<?php

namespace App\Livewire;

use App\Actions\Loan\GetOverdueLoansAction;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Repositories\Contracts\LoanRepositoryInterface;
use App\Repositories\Contracts\MemberRepositoryInterface;
use Livewire\Component;

class Dashboard extends Component
{
    public function render(
        BookRepositoryInterface $bookRepository,
        MemberRepositoryInterface $memberRepository,
        LoanRepositoryInterface $loanRepository,
        GetOverdueLoansAction $getOverdueLoansAction
    ) {
        $totalBooks = $bookRepository->getTotalCount();
        $totalMembers = $memberRepository->getActiveCount();
        $totalBorrowed = $loanRepository->getActiveLoansCount();
        $totalOverdue = $getOverdueLoansAction->count();

        $popularBooks = $bookRepository->getPopularBooks(5);
        $recentLoans = $loanRepository->getRecentLoans(5);

        return view('livewire.dashboard', compact(
            'totalBooks',
            'totalMembers',
            'totalBorrowed',
            'totalOverdue',
            'popularBooks',
            'recentLoans'
        ))->layout('layouts.app');
    }
}

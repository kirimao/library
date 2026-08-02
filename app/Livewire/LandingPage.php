<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Support\Carbon;
use Livewire\Component;

class LandingPage extends Component
{
    public function render()
    {
        $today = Carbon::today()->toDateString();

        // Statistik utama
        $totalBooks    = Book::count();
        $totalMembers  = Member::count();
        $activeLoans   = Loan::whereIn('status', ['borrowed', 'overdue'])->count();

        // Buku paling populer (paling banyak dipinjam/dibaca)
        $popularBooks = Book::with(['category', 'genres'])
            ->withCount('loans')
            ->orderByDesc('loans_count')
            ->take(8)
            ->get();

        // Aktivitas hari ini: peminjaman baru + baca on-site yang dicatat hari ini
        $todayLoans = Loan::whereDate('loan_date', $today)
            ->whereIn('status', ['borrowed', 'on_site'])
            ->count();

        // Total buku dikembalikan hari ini
        $todayReturns = Loan::whereDate('return_date', $today)
            ->where('status', 'returned')
            ->count();

        // Total peminjaman & kunjungan hari ini gabungan
        $todayActivity = $todayLoans + $todayReturns;

        // Jumlah anggota aktif
        $activeMembers = Member::where('status', 'active')->count();

        return view('livewire.landing-page', compact(
            'totalBooks',
            'totalMembers',
            'activeLoans',
            'popularBooks',
            'todayActivity',
            'todayLoans',
            'todayReturns',
            'activeMembers'
        ))->layout('layouts.landing');
    }
}

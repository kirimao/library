<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\BookReview;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Support\Carbon;
use Livewire\Component;

class LandingPage extends Component
{
    public function render()
    {
        $today = Carbon::today()->toDateString();

        // ── Statistik utama (query masing-masing sederhana & cepat) ──────────
        $totalBooks   = Book::count();
        $activeMembers = Member::where('status', 'active')->count();
        $activeLoans  = Loan::whereIn('status', ['borrowed', 'overdue'])->count();

        // Aktivitas hari ini: peminjaman baru (borrowed + on_site)
        $todayLoans = Loan::whereDate('loan_date', $today)
            ->whereIn('status', ['borrowed', 'on_site'])
            ->count();

        // Dikembalikan hari ini
        $todayReturns = Loan::whereDate('return_date', $today)
            ->where('status', 'returned')
            ->count();

        // Aktivitas gabungan hari ini (pinjam + kembali)
        $todayActivity = $todayLoans + $todayReturns;

        // ── Buku paling populer — eager load relasi, satu query + aggregasi ──
        $popularBooks = Book::with(['category', 'genres'])
            ->withCount('loans')
            ->orderByDesc('loans_count')
            ->take(8)
            ->get();

        // ── Testimoni/review publik (jika ada data) ──────────────────────────
        // Hanya tampilkan review yang memiliki komentar ≥ 20 karakter
        // dan TIDAK menyertakan nama lengkap anggota (privasi anak)
        $publicReviews = BookReview::with(['book:id,title', 'member:id,member_type,grade'])
            ->whereNotNull('comment')
            ->where('comment', '!=', '')
            ->whereRaw('CHAR_LENGTH(comment) >= 20')
            ->latest()
            ->take(3)
            ->get();

        return view('livewire.landing-page', compact(
            'totalBooks',
            'activeMembers',
            'activeLoans',
            'popularBooks',
            'todayActivity',
            'todayLoans',
            'todayReturns',
            'publicReviews',
        ))->layout('layouts.landing');
    }
}

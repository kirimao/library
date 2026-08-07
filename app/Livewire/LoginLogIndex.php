<?php

namespace App\Livewire;

use App\Models\LoginLog;
use Livewire\Component;
use Livewire\WithPagination;

class LoginLogIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public int|string $perPage = 10;
    public bool $canShowAll = true;

    public function mount(): void
    {
        $totalLogs = LoginLog::count();
        // Disambungkan dengan batas aman 5000 baris untuk log login
        $this->canShowAll = $totalLogs <= 5000;

        $allowed = [10, 25, 50, 100];
        if ($this->canShowAll) {
            $allowed[] = 'all';
        }

        $saved = session('perPage_login_logs', 10);
        if ($saved === 'all' && !$this->canShowAll) {
            $saved = 100;
        }

        $this->perPage = in_array($saved, $allowed, true) || in_array((int)$saved, [10, 25, 50, 100], true) ? $saved : 10;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
        if ($this->perPage === 'all' && !$this->canShowAll) {
            $this->perPage = 100;
        }
        session(['perPage_login_logs' => $this->perPage]);
    }

    public function render()
    {
        $query = LoginLog::query()->latest('id');

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
                  ->orWhere('role', 'like', "%{$this->search}%")
                  ->orWhere('ip_address', 'like', "%{$this->search}%");
            });
        }

        if ($this->perPage === 'all') {
            $totalCount = max(1, (clone $query)->count());
            $logs = $query->paginate($totalCount);
        } else {
            $logs = $query->paginate((int) $this->perPage);
        }

        return view('livewire.login-log-index', compact('logs'))
            ->layout('layouts.app');
    }
}

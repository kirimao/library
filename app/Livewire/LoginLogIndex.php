<?php

namespace App\Livewire;

use App\Models\LoginLog;
use Livewire\Component;
use Livewire\WithPagination;

class LoginLogIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 20;

    public function updatingSearch(): void
    {
        $this->resetPage();
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

        $logs = $query->paginate($this->perPage);

        return view('livewire.login-log-index', compact('logs'))
            ->layout('layouts.app');
    }
}

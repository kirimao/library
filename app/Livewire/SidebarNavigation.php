<?php

namespace App\Livewire;

use App\Actions\Loan\GetOverdueLoansAction;
use App\Livewire\Actions\Logout;
use Livewire\Component;

class SidebarNavigation extends Component
{
    public int $overdueCount = 0;

    public function mount(GetOverdueLoansAction $getOverdueLoansAction)
    {
        $this->overdueCount = $getOverdueLoansAction->count();
    }

    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }

    public function render()
    {
        return view('livewire.layout.navigation');
    }
}

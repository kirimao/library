<?php

namespace App\Livewire\Members;

use App\Actions\Member\DeleteMemberAction;
use App\Repositories\Contracts\MemberRepositoryInterface;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class MemberIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public ?string $type = null;
    public ?string $grade = null;
    public int|string $perPage = 10;

    protected $listeners = ['memberSaved' => '$refresh'];

    public function mount(): void
    {
        $allowed = [10, 25, 50, 100, 'all'];
        $saved = session('perPage_members', 10);
        $this->perPage = in_array($saved, $allowed, true) || in_array((int)$saved, [10, 25, 50, 100], true) ? $saved : 10;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingType(): void
    {
        $this->resetPage();
    }

    public function updatingGrade(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
        session(['perPage_members' => $this->perPage]);
    }

    public function deleteMember(int $id, DeleteMemberAction $deleteMemberAction)
    {
        try {
            $deleteMemberAction->execute($id);
            session()->flash('success', __('members.deleted_success'));
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render(MemberRepositoryInterface $memberRepository)
    {
        $perPageInt = $this->perPage === 'all'
            ? max(1, $memberRepository->getTotalCount())
            : (int) $this->perPage;

        $members = $memberRepository->paginate($perPageInt, $this->search, $this->type, $this->grade);

        return view('livewire.members.member-index', compact('members'))
            ->layout('layouts.app');
    }
}

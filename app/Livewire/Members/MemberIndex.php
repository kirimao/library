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
    public int $perPage = 10;

    protected $listeners = ['memberSaved' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingType()
    {
        $this->resetPage();
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
        $members = $memberRepository->paginate($this->perPage, $this->search, $this->type);

        return view('livewire.members.member-index', compact('members'))
            ->layout('layouts.app');
    }
}

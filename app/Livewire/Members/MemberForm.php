<?php

namespace App\Livewire\Members;

use App\Actions\Member\CreateMemberAction;
use App\Actions\Member\UpdateMemberAction;
use App\Repositories\Contracts\LoanRepositoryInterface;
use App\Repositories\Contracts\MemberRepositoryInterface;
use Livewire\Component;

class MemberForm extends Component
{
    public ?int $memberId = null;
    public string $member_number = '';
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $member_type = 'SD';
    public string $status = 'active';

    public bool $isOpen = false;
    public array $loanHistory = [];

    protected $listeners = ['openMemberModal' => 'loadMember'];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:members,email,' . ($this->memberId ?? 'NULL') . ',id',
            'phone' => 'nullable|string|max:50',
            'member_type' => 'required|in:SD,SMP,SMA,Guru,Mahasiswa,Lainnya',
            'status' => 'required|in:active,inactive',
            'member_number' => 'nullable|string|max:50|unique:members,member_number,' . ($this->memberId ?? 'NULL') . ',id',
        ];
    }

    public function loadMember(?int $id = null)
    {
        $this->resetValidation();
        $this->reset();

        if ($id) {
            $member = app(MemberRepositoryInterface::class)->findById($id);
            $this->memberId = $member->id;
            $this->member_number = $member->member_number;
            $this->name = $member->name;
            $this->email = $member->email;
            $this->phone = $member->phone ?? '';
            $this->member_type = $member->member_type;
            $this->status = $member->status;

            $history = app(LoanRepositoryInterface::class)->getHistoryForMember($id);
            $this->loanHistory = $history->toArray();
        }

        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset();
        $this->resetValidation();
    }

    public function save(CreateMemberAction $createMemberAction, UpdateMemberAction $updateMemberAction)
    {
        $validated = $this->validate();

        if ($this->memberId) {
            $updateMemberAction->execute($this->memberId, $validated);
            session()->flash('success', __('members.updated_success'));
        } else {
            $createMemberAction->execute($validated);
            session()->flash('success', __('members.created_success'));
        }

        $this->dispatch('memberSaved');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.members.member-form');
    }
}

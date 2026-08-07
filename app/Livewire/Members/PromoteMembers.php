<?php

namespace App\Livewire\Members;

use App\Actions\Member\AdjustMemberGradeAction;
use App\Actions\Member\PromoteAllMembersAction;
use App\Models\Member;
use Exception;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

class PromoteMembers extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterType = '';
    public ?array $lastResult = null;

    // Manual Edit Modal State
    public bool $isModalOpen = false;
    public ?int $selectedMemberId = null;
    public ?string $selectedMemberName = null;
    public string $editMemberType = 'SD';
    public string $editGrade = 'Kelas 1';
    public string $editStatus = 'active';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterType(): void
    {
        $this->resetPage();
    }

    public function promoteAll(PromoteAllMembersAction $promoteAction)
    {
        try {
            $this->lastResult = $promoteAction->execute();
            session()->flash('success', "Proses Kenaikan Kelas Massal Berhasil! ({$this->lastResult['promoted']} Siswa Naik Kelas, {$this->lastResult['graduated']} Lulus/Alumni)");
        } catch (Exception $e) {
            session()->flash('error', 'Gagal memproses kenaikan kelas: ' . $e->getMessage());
        }
    }

    public function openAdjustModal(int $memberId)
    {
        $member = Member::findOrFail($memberId);
        $this->selectedMemberId = $member->id;
        $this->selectedMemberName = $member->name;
        $this->editMemberType = $member->member_type;
        $this->editGrade = $member->grade ?? 'Kelas 1';
        $this->editStatus = $member->status;
        $this->isModalOpen = true;
    }

    public function closeAdjustModal()
    {
        $this->isModalOpen = false;
        $this->reset(['selectedMemberId', 'selectedMemberName', 'editMemberType', 'editGrade', 'editStatus']);
    }

    public function saveAdjust(AdjustMemberGradeAction $adjustAction)
    {
        $this->validate([
            'editMemberType' => 'required|in:SD,SMP,SMA,Guru,Lainnya',
            'editGrade' => 'nullable|string|max:50',
            'editStatus' => 'required|in:active,inactive',
        ]);

        try {
            $adjustAction->execute(
                $this->selectedMemberId,
                $this->editMemberType,
                $this->editGrade,
                $this->editStatus
            );

            session()->flash('success', "Jenjang/Kelas anggota {$this->selectedMemberName} berhasil diperbarui.");
            $this->closeAdjustModal();
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        $query = Member::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('member_number', 'like', "%{$this->search}%");
            });
        }

        if ($this->filterType) {
            $query->where('member_type', $this->filterType);
        }

        $members = $query->orderBy('member_type')->orderBy('grade')->paginate(15);
        $lastPromotionDate = Cache::get('last_mass_promotion_at');

        return view('livewire.members.promote-members', compact('members', 'lastPromotionDate'))
            ->layout('layouts.app');
    }
}

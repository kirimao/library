<?php

namespace App\Livewire\Members;

use App\Actions\Member\GetMemberFavoriteGenreAction;
use App\Actions\Member\GetMemberReadingHistoryAction;
use App\Repositories\Contracts\MemberRepositoryInterface;
use Livewire\Component;

class MemberProfile extends Component
{
    public int $memberId;

    public function mount(int $id)
    {
        $this->memberId = $id;
    }

    public function render(
        MemberRepositoryInterface $memberRepository,
        GetMemberFavoriteGenreAction $getFavoriteGenreAction,
        GetMemberReadingHistoryAction $getReadingHistoryAction
    ) {
        $member = $memberRepository->findById($this->memberId);
        $favoriteGenre = $getFavoriteGenreAction->execute($this->memberId);
        $readingHistory = $getReadingHistoryAction->execute($this->memberId);

        return view('livewire.members.member-profile', compact('member', 'favoriteGenre', 'readingHistory'))
            ->layout('layouts.app');
    }
}

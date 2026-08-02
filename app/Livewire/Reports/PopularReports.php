<?php

namespace App\Livewire\Reports;

use App\Actions\Book\GetMostReadBooksAction;
use App\Actions\Genre\GetPopularGenresAction;
use App\Repositories\Contracts\GenreRepositoryInterface;
use Livewire\Component;

class PopularReports extends Component
{
    public ?string $selectedMemberType = null;
    public ?int $selectedGenreId = null;

    public function render(
        GetPopularGenresAction $getPopularGenresAction,
        GetMostReadBooksAction $getMostReadBooksAction,
        GenreRepositoryInterface $genreRepository
    ) {
        $popularGenres = $getPopularGenresAction->execute($this->selectedMemberType);
        $mostReadBooks = $getMostReadBooksAction->execute($this->selectedGenreId, $this->selectedMemberType);
        $genres = $genreRepository->all();

        return view('livewire.reports.popular-reports', compact('popularGenres', 'mostReadBooks', 'genres'))
            ->layout('layouts.app');
    }
}

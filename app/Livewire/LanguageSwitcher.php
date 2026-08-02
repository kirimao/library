<?php

namespace App\Livewire;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class LanguageSwitcher extends Component
{
    public string $currentLocale;

    public function mount()
    {
        $this->currentLocale = Session::get('locale', App::getLocale() ?? 'id');
    }

    public function switchLanguage(string $locale)
    {
        if (in_array($locale, ['id', 'en'])) {
            Session::put('locale', $locale);
            App::setLocale($locale);
            $this->currentLocale = $locale;
            return redirect(request()->header('Referer') ?? '/dashboard');
        }
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}

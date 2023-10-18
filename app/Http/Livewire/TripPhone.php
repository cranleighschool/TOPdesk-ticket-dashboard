<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class TripPhone extends Component
{
    public string $position;
    public array $phone;
    public Collection $loans;

    public function mount(array $phone, string $position): void
    {
        $this->position = $position;
        $this->phone = $phone;
        $this->loans = collect($phone['loans'])->map(function($loan) {
            $loan['start_date'] = Carbon::parse($loan['start_date']);
            $loan['return_date'] = Carbon::parse($loan['return_date']);
            return $loan;
        });
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.trip-phone');
    }
}

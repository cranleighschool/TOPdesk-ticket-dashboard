<?php

namespace App\Http\Livewire;

use FredBradley\TOPDesk\Facades\TOPDesk;
use Illuminate\View\View;
use Livewire\Component;

class TicketCounter extends Component
{
    public string $position;
    public string $department;
    public string $title;

    private string $operatorGroupId;

    /**
     * @param  string  $position
     * @param  string  $department
     * @param  string  $title
     * @return void
     */
    public function mount(string $position, string $department, string $title)
    {
        $this->position = $position;
        $this->department = $department;
        $this->title = $title;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function render(): View
    {
        $department = $this->department;
        $title = $this->title;
        $this->operatorGroupId = TOPDesk::getOperatorGroupId($this->department);

        $count = $this->getCount();

        $class = $this->getClassThreshold($count)[$title];

        if (in_array($this->position, ['f2:f2', 'f3:f3', 'f4:f4'])) {
            return view('topdesk.ticket-counter-small', compact('department', 'count', 'title', 'class'));
        }
        return view('topdesk.ticket-counter', compact('department', 'count', 'title', 'class'));
    }

    /**
     * @param  int  $count
     * @param  int  $error
     * @param  int  $warning
     * @return string
     */
    private function threshold(int $count, int $error, int $warning): string
    {
        if ($count > $error) {
            $class = 'bg-error text-white';
        } elseif ($count >= $warning) {
            $class = 'bg-warning';
        } else {
            $class = 'bg-success';
        }

        return $class;
    }

    /**
     * @param  int  $count
     * @return array
     */
    private function getClassThreshold(int $count): array
    {
        return match ($this->department) {
            'I.T. Services' => [
                'Open' => $this->threshold($count, 99, 30),
                'Updated by user' => $this->threshold($count, 20, 10),
                'Scheduled' => $this->threshold($count, 20, 10),
                'Waiting for user' => $this->threshold($count, 10, 5),
            ],
            'Reprographics' => [
                'Open' => $this->threshold($count, 20, 10),
                'Updated by user' => $this->threshold($count, 10, 5),
                'Scheduled' => $this->threshold($count, 10, 5),
                'Waiting for user' => $this->threshold($count, 5, 3),
            ],
            default => [
                'Open' => $this->threshold($count, 99, 30),
                'Updated by user' => $this->threshold($count, 20, 10),
                'Scheduled' => $this->threshold($count, 20, 10),
                'Waiting for user' => $this->threshold($count, 10, 5),
            ]
        };
    }

    /**
     * @return int
     */
    private function getCount(): int
    {
        return match ($this->title) {
            'Open' => TOPDesk::getOpenIncidentsByOperatorGroupId($this->operatorGroupId)->count(),
            'Waiting for user' => TOPDesk::getOpenIncidentsByOperatorGroupId($this->operatorGroupId,
                'Waiting for user')->count(),
            'Updated by user' => TOPDesk::getOpenIncidentsByOperatorGroupId($this->operatorGroupId,
                'Updated by user')->count(),
            'Scheduled' => TOPDesk::getOpenIncidentsByOperatorGroupId($this->operatorGroupId, 'Scheduled')->count(),
            default => throw new \Exception('Could not Match count for '.$this->title)
        };
    }
}

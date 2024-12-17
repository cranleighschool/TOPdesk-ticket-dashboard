<?php

namespace App\Livewire;

use FredBradley\TOPDesk\Facades\TOPDesk;
use Livewire\Component;

class TicketList extends Component
{
    public $position;
    public $department;

    public function mount(string $position, string $department)
    {
        $this->position = $position;
        $this->department = $department;
    }

    public function render()
    {
        $department = $this->department;
        $operatorGroupId = TOPDesk::getOperatorGroupId($this->department);
        $tickets = TOPDesk::getOpenIncidentsByOperatorGroupId($operatorGroupId, 'Open', true);
        $class = 'p-5';

        return view('topdesk.ticket-list', compact('department', 'tickets', 'class'));
    }
}

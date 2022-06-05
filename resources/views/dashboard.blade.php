<x-dashboard>
    {{-- replace this by any tiles --}}
    <livewire:ticket-list position="a1:g5" department="{{ request('department') }}" />
    <livewire:time-and-date position="h1" />
    <livewire:ticket-counter position="h2" department="{{ request('department') }}" title="Open" />
    <livewire:ticket-counter position="h3" department="{{ request('department') }}" title="Waiting for user" />
    <livewire:ticket-counter position="h4" department="{{ request('department') }}" title="Updated by user" />
    <livewire:ticket-counter position="h5" department="{{ request('department') }}" title="Scheduled" />
</x-dashboard>

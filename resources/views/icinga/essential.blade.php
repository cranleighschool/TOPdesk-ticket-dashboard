<x-dashboard>
    {{-- replace this by any tiles --}}

    <livewire:time-and-date position="a1" />
    <livewire:problem-hosts position="b1:d5" handled=0 title="Unknown Problem Hosts"/>
    <livewire:problem-hosts position="b6:d8" handled=1 title="Known Problem Hosts"/>
    <livewire:problem-services position="e1:g4" />
    <livewire:host-headlines position="a2" />
</x-dashboard>

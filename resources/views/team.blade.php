<x-dashboard>
    @php
        $users = (new \App\Logic\SlackTeam())->get()->pluck('username');
    @endphp
    {{-- replace this by any tiles --}}
    <livewire:team-member position="a1" username="{{ $users[0] }}"/>
    <livewire:team-member position="b1" username="{{ $users[1] }}"/>
    <livewire:team-member position="c1" username="{{ $users[2] }}"/>
    <livewire:team-member position="d1" username="{{ $users[3] }}"/>
    <livewire:team-member position="e1" username="{{ $users[4] }}"/>
    <livewire:time-and-date position="f1" />

    <livewire:team-member position="a2" username="{{ $users[5] }}"/>
    <livewire:team-member position="b2" username="{{ $users[6] }}"/>
    <livewire:team-member position="c2" username="{{ $users[7] }}"/>
    <livewire:team-member position="d2" username="{{ $users[8] }}"/>
    <livewire:team-member position="e2" username="{{ $users[9] }}"/>
    <livewire:team-member position="f2" username="TNSCSUPPORT"/>

    {{--    <livewire:time-and-date position="f1" />--}}
    {{--    <livewire:ticket-counter position="f3" department="{{ request('department') }}" title="Waiting for user" />--}}
    {{--    <livewire:ticket-counter position="f4" department="{{ request('department') }}" title="Updated by user" />--}}
    {{--    <livewire:ticket-counter position="f5" department="{{ request('department') }}" title="Scheduled" />--}}
</x-dashboard>

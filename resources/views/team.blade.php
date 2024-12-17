<x-dashboard>
    @php
        $users = (new \App\Logic\SlackTeam())->get()->pluck('username');
        $users = [
            'FRB','SPKM',
            'MJO','MWJS',
            'RSS','DJF',
            'SGSM','CCT',
            'AHJT','FRB',
            ];

    @endphp
    {{-- replace this by any tiles --}}
    <livewire:team-member position="a1:a4" username="{{ $users[0] }}"/>
    <livewire:team-member position="b1:b4" username="{{ $users[1] }}"/>
    <livewire:team-member position="c1:c4" username="{{ $users[2] }}"/>
    <livewire:team-member position="d1:d4" username="{{ $users[3] }}"/>
    <livewire:team-member position="e1:e4" username="{{ $users[4] }}"/>
    <livewire:time-and-date position="f1:f1" />
    <livewire:ticket-counter position="f2:f2" department="I.T. Services" title="Open" />
    <livewire:ticket-counter position="f3:f3" department="I.T. Services" title="Waiting for user" />
    <livewire:ticket-counter position="f4:f4" department="I.T. Services" title="Updated by user" />


    <livewire:team-member position="a5:a8" username="{{ $users[5] }}"/>
    <livewire:team-member position="b5:b8" username="{{ $users[6] }}"/>
    <livewire:team-member position="c5:c8" username="{{ $users[7] }}"/>
    <livewire:team-member position="d5:d8" username="{{ $users[8] }}"/>
    <livewire:team-member position="e5:e8" username="{{ $users[9] }}"/>
{{--    <livewire:team-member position="f5:f8" username="TNSCSUPPORT"/>--}}

    {{--    <livewire:time-and-date position="f1" />--}}
    {{--    <livewire:ticket-counter position="f3" department="{{ request('department') }}" title="Waiting for user" />--}}
    {{--    <livewire:ticket-counter position="f4" department="{{ request('department') }}" title="Updated by user" />--}}
    {{--    <livewire:ticket-counter position="f5" department="{{ request('department') }}" title="Scheduled" />--}}
</x-dashboard>

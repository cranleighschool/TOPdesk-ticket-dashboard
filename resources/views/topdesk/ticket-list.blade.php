<x-dashboard-tile-content :position="$position" refresh-interval="60">
    <div class="grid gap-2 justify-items-center h-full text-center">
    <table class="min-w-full">
        <thead class="border-b">
        <tr>
            <th class="px-2 py-2" style="min-width: 120px;">Number</th>
            <th class="px-2 py-2">Subject</th>
            <th class="px-2 py-2">Caller</th>
            <th class="px-2 py-2">Status</th>
            <th class="px-2 py-2">Target Date</th>
            <th class="px-2 py-2">Created</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($tickets as $row => $ticket)
            <tr class="border-b {{ $row % 2 == 0 ? '' : '' }}">
                <td class="font-bold font-mono text-sm whitespace-nowrap text-center py-1">
                    <a class="bg-red-100 text-red-900 px-1 py-1" target="_blank"
                       href="{{ config('topdesk.endpoint') }}/secure/contained/incident?unid={{ $ticket->id }}">
                        {{ $ticket->number }}
                    </a>
                </td>
                <td class="whitespace-nowrap">{{ $ticket->briefDescription }}</td>
                <td class="whitespace-nowrap">{{ $ticket->caller->dynamicName }}</td>
                <td class="whitespace-nowrap text-center">{{ $ticket->processingStatus->name }}</td>
                <td class="whitespace-nowrap text-center">{{ is_null($ticket->targetDate) ? 'Not Set' : $ticket->targetDate->diffForHumans() }}</td>
                <td class="whitespace-nowrap text-center">{{ $ticket->creationDate->diffForHumans() }}</td>
            </tr>
        @empty
            <tr>
                <td class="text-center text-error" colspan="6">
                    <div class=" text-4xl">Could not find any tickets to list</div>
                    <div>Normally that might be a good thing, but in this case I find it unlikely!</div>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
    </div>

</x-dashboard-tile-content>

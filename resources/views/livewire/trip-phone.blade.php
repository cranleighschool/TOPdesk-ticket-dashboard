<x-dashboard-tile :position="$position" refresh-interval="60">
    <div
        class="grid gap-0 justify-items-center"
        style="grid-template-rows: auto 1fr auto;"
    >
        <div class="flex items-center space-x-2">
            <div class="w-full font-medium dark:text-white">
                <div class="text-left">{{ $phone['device'] }}
                    <span class="text-right text-sm text-gray-500 dark:text-gray-400"
                          style="float:right;">{{ $phone['number'] }}</span></div>
            </div>
        </div>
        <div class="flex flex-wrap">
            <table class="table-auto w-full">
                <tbody>
                <tr style="border-top:1px solid grey;">
                    <td colspan="2" class="text-small text-muted" style="font-size: 0.8rem">
                        <table class="w-full border-collapse table-auto">
                            <thead class="border-b border-gray-400 px-2">
                            <th class="text-left">Staff</th>
                            <th class="text-left">Start</th>
                            <th class="text-left">End</th>
                            <th class="text-left">Status</th>
                            </thead>
                            <tbody>
                            @foreach ($loans as $loan)
                                <tr class="p-0">
                                    <td class="p-0">{{ $loan['loanee'] }}</td>
                                    <td>{{ $loan['start_date_formatted'] }}</td>
                                    <td>{{ $loan['return_date_formatted'] }}</td>
                                    <td>
                                        @if ($loan['start_date'] < now() && $loan['return_date'] > now())
                                            <span class="text-red-500">In Play</span>
                                        @endif
                                        @if ($loan['returned'])
                                            <span class="text-green-500">Returned</span>
                                        @elseif($loan['overdue'])
                                            <span class="text-red-500">Overdue</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>


                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-dashboard-tile>

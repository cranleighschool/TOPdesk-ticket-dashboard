<x-dashboard-tile :position="$position" refresh-interval="60">
    <div
        class="grid gap-0 justify-items-center h-full"
        style="grid-template-rows: auto 1fr auto;"
    >
        <div class="flex items-center space-x-2">
            <div class="font-medium dark:text-white">
                <div class="text-left">{{ $phone['device'] }}</div>
                <div class="text-left text-sm text-gray-500 dark:text-gray-400"
                     style="font-size:0.55rem;">
                </div>
            </div>
        </div>
        <div class="flex flex-wrap">
            <table class="table-auto w-full">
                <tbody>
                <tr style="border-top:1px solid grey;">
                    <td colspan="2" class="text-small text-muted" style="font-size: 0.8rem">
                        @foreach (collect($loans) as $loan)
                            <li>
                                {{ $loan['loanee'] }} - {{ ($loan['start_date']) }} -> {{ $loan['return_date'] }}
                                @if ($loan['start_date'] < now() && $loan['return_date'] > now())
                                    <span class="text-red-500">In Play</span>
                                @endif
                            </li>
                        @endforeach

                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-dashboard-tile>

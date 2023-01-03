<x-dashboard-tile :position="$position">
    <div
        class="grid gap-0 justify-items-center h-full text-center"
        style="grid-template-rows: auto 1fr auto;"
    >
        <div class="flex items-center space-x-2">
            <img class="w-10 h-10 rounded-full" src="{{ $imageData }}" alt="{{ $username }} Profile Image">
            <div class="font-medium dark:text-white">
                <div class="text-left">{{ $username==='TNSCSUPPORT' ? 'TNSC' : $username }}</div>
                @if (is_array($slack) && $slack['status_text'] !== "")
                    <div class="text-left text-sm text-gray-500 dark:text-gray-400"
                         style="font-size:0.55rem;">{!! $slack['status_text'] !!}</div>
                @endif
            </div>
        </div>
        <div class="flex flex-wrap">
            <table class="table-auto w-full">
                <tbody>
                @foreach ($counts as $key => $count)
                    <tr>
                        <td class="text-left leading-relaxed">{{ \Illuminate\Support\Str::words($key, 1, "...") }}</td>
                        <td class="text-center text-small text-warning" style="font-size: 0.8rem">
                            @if ($key=='Updated by user')
                                {{ optional($recentUpdate)->diffForHumans() }}
                            @endif
                        </td>
                        <td class="text-center font-weight-bold text-xl text-bold text-gray-900">{{ $count }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="text-left leading-relaxed">Recent Close</td>
                    <td colspan="2" class="text-center text-small text-muted" style="font-size: 0.8rem">
                        {{ $recentClose->closedDate->diffForHumans() }}
                    </td>
{{--                    <td class="text-center font-weight-bold text-xl text-bold text-gray-900"></td>--}}
                </tr>
                </tbody>
            </table>
        </div>
        {{--
                <div class="flex flex-wrap -m-4 py-2 text-center">
                    @foreach ($counts as $key => $count)
                    <div class="p-2 md:w-1/2 sm:w-1/2 w-full">
                        <div class="border-2 border-gray-200 px-2 py-3 rounded-lg">
                            <h2 class="title-font font-medium text-3xl text-gray-900">{{ $count }}</h2>
                            <p class="leading-relaxed">{{ \Illuminate\Support\Str::words($key, 1, "...") }}</p>
                        </div>
                    </div>
                    @endforeach
                </div> --}}
        {{--
                <div class="flex space-x-4">
                    <table class="table-auto">
                        <thead>
                        <tr>
                            <th>Incident</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($incidents as $incident)
                            <tr>
                                <td class="text-left">{{ $incident['briefDescription'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                --}}
    </div>
</x-dashboard-tile>

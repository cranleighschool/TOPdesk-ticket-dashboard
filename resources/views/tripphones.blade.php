<x-dashboard>

    @php
        $tripPhones = Http::get('https://tripphones.cranleigh.org/display/api')->json();
        $numPhones = count($tripPhones);
        $half = round($numPhones / 2);
        $third = round($numPhones / 3);
    @endphp

    @foreach ($tripPhones as $key=>$phone)
        @php $key = $key+1 @endphp
        @if ($key <= $third)
            @php $position = ($key) @endphp
            @livewire('trip-phone', ['phone' => $phone, 'position' => "A{$position}"])
        @elseif($key <= $third*2)
            @php $position = ($key-$third) @endphp
            @livewire('trip-phone', ['phone' => $phone, 'position' => "B{$position}"])
        @else
            @php $position = ($key-($third*2)) @endphp
            @livewire('trip-phone', ['phone' => $phone, 'position' => "C{$position}"])

        @endif
    @endforeach

</x-dashboard>

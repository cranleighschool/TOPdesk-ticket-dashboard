<x-dashboard-tile :position="$position" :class="$class" refresh-interval="5">
    <div class="grid gap-1 justify-items-center h-full text-center">
        <h2 class="text-center self-center font-bold tracking-wide leading-none">{{ strtoupper($title) }}</h2>
        <div class="text-center self-center font-bold text-2xl tracking-wide leading-none">
            {{ $count }}
        </div>
    </div>
</x-dashboard-tile>

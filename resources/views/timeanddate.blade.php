<x-dashboard-tile :position="$position">
    <div
        class="grid gap-2 justify-items-center h-full text-center"
        style="grid-template-rows: auto 1fr auto;"
        x-data="clock()"
        x-init="tick"
    >
        <h1 class="font-medium text-dimmed text-sm uppercase tracking-wide tabular-nums" x-text="date"></h1>

        <div class="self-center font-bold text-4xl tracking-wide leading-none" x-text="time"></div>

    </div>

    <script>
        function clock() {
            return {
                dateTime: new Date(),

                tick() {
                    setInterval(() => {
                        this.dateTime = new Date();
                    }, 1000);
                },

                get date() {
                    const day = this.dateTime
                        .toLocaleDateString('{{ app()->getLocale() }}', { weekday: 'long' })
                        .substr(0, 3);

                    const date = [
                        this.dateTime.getDate(),
                        this.dateTime.getMonth() + 1,
                    ].map(this.padNumber).join('/');

                    return `${day} ${date}`;
                },

                get time() {
                    return [
                        this.dateTime.getHours(),
                        this.dateTime.getMinutes(),
                    ].map(this.padNumber).join(':');
                },

                padNumber(number) {
                    return String(number).padStart(2, '0');
                }
            }
        }
    </script>

</x-dashboard-tile>

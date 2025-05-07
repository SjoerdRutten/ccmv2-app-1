@once
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endonce
@props([
    'percentage' => 0,
    'height' => 100,
    'label' => '',
    'ref' => uniqid(),
    'color' => '#DB2777',
])
<div
        x-data="{
            init() {
                let chart = new ApexCharts(this.$refs.{{ $ref }}, this.options)

                chart.render()

                this.$watch('values', () => {
                    chart.updateOptions(this.options)
                })
            },
            get options() {
                return {
                    series: [{{ $percentage }}],
                    colors: ['{{ $color }}'],
                    chart: {
                        height: {{ $height }},
                        width: {{ $height }},
                        type: 'radialBar',
                    },
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                size: '20%',
                            }
                        }
                    },
                    labels: ['{{ $label ?? ''}}'],
                }
            }
        }"
        class="w-full"
>
    <div x-ref="{{ $ref }}"></div>
</div>
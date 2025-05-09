<x-ccm::cards.card title="Server status">

    <div class="grid grid-cols-4 gap-2 w-full">
        <x-ccm::typography.h4>Server</x-ccm::typography.h4>
        <x-ccm::typography.h4>CPU</x-ccm::typography.h4>
        <x-ccm::typography.h4>Disk</x-ccm::typography.h4>
        <x-ccm::typography.h4>Ram</x-ccm::typography.h4>

        @foreach ($servers AS $server)
            <div class="flex items-center font-bold text-md">
                <a href="{{ route('admin::servers::edit', $server->id) }}">
                    {{ $server->name }}
                </a>
            </div>

            <x-ccm::charts.radial-bar :percentage="$server->cpuPercentage"
                                      :height="60"
                                      ref="chartCpu{{ $server->id }}"/>
            <x-ccm::charts.radial-bar :percentage="$server->diskFreePercentage"
                                      :height="60"
                                      ref="chartDisk{{ $server->id }}"/>
            <x-ccm::charts.radial-bar :percentage="$server->ramFreePercentage"
                                      :height="60"
                                      ref="chartRam{{ $server->id }}"/>
        @endforeach
    </div>


</x-ccm::cards.card>
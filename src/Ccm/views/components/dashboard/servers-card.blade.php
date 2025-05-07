<x-ccm::cards.card title="Wachtrijen">

    <div class="grid grid-cols-4 gap-2 w-full">
        <x-ccm::typography.h4>Server</x-ccm::typography.h4>
        <x-ccm::typography.h4>CPU</x-ccm::typography.h4>
        <x-ccm::typography.h4>Disk</x-ccm::typography.h4>
        <x-ccm::typography.h4>Ram</x-ccm::typography.h4>

        @foreach ($servers AS $server)
            <div class="flex items-center font-bold text-md">
                {{ $server->name }}
            </div>

            <x-ccm::charts.radial-bar :percentage="$server->cpuPercentage"
                                      :height="60"
                                      ref="chartCpu{{ $server->id }}"/>
            <x-ccm::charts.radial-bar :percentage="$server->diskPercentage"
                                      :height="60"
                                      ref="chartDisk{{ $server->id }}"/>
            <x-ccm::charts.radial-bar :percentage="$server->ramPercentage"
                                      :height="60"
                                      ref="chartRam{{ $server->id }}"/>
        @endforeach
    </div>


</x-ccm::cards.card>
<x-ccm::cards.card title="Queues">
    <div class="flex flex-col gap-4">
        @foreach ($queues AS $queue)
            <div class="">
                <x-ccm::typography.h3>{{ $queue->queue }}</x-ccm::typography.h3>
                <table class="w-full">
                    <tr>
                        <th class="w-1/2">Aantal in queue:</th>
                        <td>{{ $queue->total }}</td>
                    </tr>
                    <tr>
                        <th>Oudste taak:</th>
                        <td>{{ \Carbon\Carbon::parse($queue->oldest)->toDateTimeString() }}</td>
                    </tr>
                    <tr>
                        <th>Nieuwste taak:</th>
                        <td>{{ \Carbon\Carbon::parse($queue->latest)->toDateTimeString() }}</td>
                    </tr>
                </table>
            </div>
        @endforeach
    </div>
</x-ccm::cards.card>
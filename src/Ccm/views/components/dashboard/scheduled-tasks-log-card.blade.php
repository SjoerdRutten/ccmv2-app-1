<x-ccm::cards.card title="Taakplanner logs">
    <div class="flex flex-col gap-4">
        @foreach ($logs AS $log)
            <div class="">
                <x-ccm::typography.h3>{{ $log->scheduledTask->name }}</x-ccm::typography.h3>
                {!! nl2br($log->output) !!}

                <div class="text-xs text-right">{{ $log->created_at }}</div>
            </div>
        @endforeach
    </div>
</x-ccm::cards.card>
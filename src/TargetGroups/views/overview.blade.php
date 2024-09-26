<div wire:loading.remove class="p-5">
    <table class="w-full">
        <thead>
        <tr>
            <th>Naam</th>
            <th>Creatietijd</th>
            <th>Updatetijd</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($this->targetGroups AS $targetGroup)
            <tr>
                <td>
                    <a href="{{ route('target-groups::form', $targetGroup) }}">
                        {{ $targetGroup->name }}
                    </a>
                </td>
                <td>{{ $targetGroup->created_at->toDateTimeString() }}</td>
                <td>{{ $targetGroup->updated_at->toDateTimeString() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

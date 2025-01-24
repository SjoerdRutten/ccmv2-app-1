@foreach ($block AS $key => $row)
    @if ($key === 'title')
        <x-ccm::typography.h2>{{ $row }}</x-ccm::typography.h2>
    @elseif ($key === 'fields')
        <x-extensions::fields :fields="$row"/>
    @endif
@endforeach
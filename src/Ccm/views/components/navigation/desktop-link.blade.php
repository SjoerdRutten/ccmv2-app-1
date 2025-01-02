@props([
    'route' => '',
    'label' => '',
    'sub' => false,
    'item' => null,
])

@if (Arr::get($item, 'permission') === 'admin')
    @isadmin
    <li>
        <x-ccm::navigation.desktop-link-li :route="$route" :label="$label" :sub="$sub" :item="$item"/>
    </li>
    @endisadmin
@elseif (Arr::get($item, 'permission.group'))
    @permission (Arr::get($item, 'permission.group'), Arr::get($item, 'permission.item'))
    <li>
        <x-ccm::navigation.desktop-link-li :route="$route" :label="$label" :sub="$sub" :item="$item"/>
    </li>
    @endpermission
@else
    <li>
        <x-ccm::navigation.desktop-link-li :route="$route" :label="$label" :sub="$sub" :item="$item"/>
    </li>
@endif

<ul role="list" class="flex flex-1 flex-col gap-y-7">
    <li>
        <ul role="list" class="-mx-2 space-y-1" x-data="{ open: $persist(null) }">
            @foreach (\CcmMenu::getMenu() AS $item)
                @if (Arr::get($item, 'permission') === 'admin')
                    @isadmin
                    <x-ccm::navigation.desktop-link :route="Arr::get($item, 'route')" :label="Arr::get($item, 'label')">
                        @if (Arr::get($item, 'sub_items'))
                            @foreach (Arr::get($item, 'sub_items') AS $subItem)
                                <x-ccm::navigation.desktop-link :route="Arr::get($subItem, 'route')"
                                                                :label="Arr::get($subItem, 'label')" :sub="true"/>
                            @endforeach
                        @endif
                    </x-ccm::navigation.desktop-link>
                    @endisadmin
                @elseif (Arr::get($item, 'permission.group'))
                    @permission (Arr::get($item, 'permission.group'), Arr::get($item, 'permission.item'))
                    <x-ccm::navigation.desktop-link :route="Arr::get($item, 'route')" :label="Arr::get($item, 'label')">
                        @if (Arr::get($item, 'sub_items'))
                            @foreach (Arr::get($item, 'sub_items') AS $subItem)
                                <x-ccm::navigation.desktop-link :route="Arr::get($subItem, 'route')"
                                                                :label="Arr::get($subItem, 'label')" :sub="true"/>
                            @endforeach
                        @endif
                    </x-ccm::navigation.desktop-link>
                    @endpermission
                @else
                    <x-ccm::navigation.desktop-link :route="Arr::get($item, 'route')" :label="Arr::get($item, 'label')">
                        @if (Arr::get($item, 'sub_items'))
                            @foreach (Arr::get($item, 'sub_items') AS $subItem)
                                <x-ccm::navigation.desktop-link :route="Arr::get($subItem, 'route')"
                                                                :label="Arr::get($subItem, 'label')" :sub="true"/>
                            @endforeach
                        @endif
                    </x-ccm::navigation.desktop-link>
                @endif
            @endforeach
        </ul>
    </li>
    {{--    <x-ccm::navigation.desktop-settings />--}}
</ul>




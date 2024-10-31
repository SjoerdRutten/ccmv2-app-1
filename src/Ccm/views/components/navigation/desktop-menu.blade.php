<ul role="list" class="flex flex-1 flex-col gap-y-7">
    <li>
        <ul role="list" class="-mx-2 space-y-1" x-data="{ open: $persist(null) }">
            <x-ccm::navigation.desktop-link route="ccm::dashboard" label="Dashboard"/>

            @if (Auth::user()->hasPermissionTo('crm', 'overview'))
                <x-ccm::navigation.desktop-link route="crm-cards::fields::overview" label="CRM">
                    <x-ccm::navigation.desktop-link route="crm-cards::cards::overview" label="Kaarten" :sub="true"/>
                    <x-ccm::navigation.desktop-link route="crm-cards::fields::overview" label="Velden" :sub="true"/>
                </x-ccm::navigation.desktop-link>
            @endif
            @if (Auth::user()->hasPermissionTo('ems', 'overview'))
                <x-ccm::navigation.desktop-link route="ems::emails::overview" label="EMS">
                    <x-ccm::navigation.desktop-link route="ems::emails::overview" label="E-mails" :sub="true"/>
                    <x-ccm::navigation.desktop-link route="ems::emailcontents::overview" label="Content" :sub="true"/>
                </x-ccm::navigation.desktop-link>
            @endif
            @if (Auth::user()->hasPermissionTo('gds', 'overview'))
                <x-ccm::navigation.desktop-link route="target-groups::overview" label="Doelgroep selectie">
                    <x-ccm::navigation.desktop-link route="target-groups::overview" label="Query builder" :sub="true"/>
                </x-ccm::navigation.desktop-link>
            @endif

            @if (Auth::user()->isAdmin)
                <x-ccm::navigation.desktop-link route="admin::features" label="Beheer">
                    <x-ccm::navigation.desktop-link route="admin::customers" label="Klanten" :sub="true"/>
                    <x-ccm::navigation.desktop-link route="admin::environments" label="Omgevingen" :sub="true"/>
                    <x-ccm::navigation.desktop-link route="roles::overview" label="Rollen" :sub="true"/>
                </x-ccm::navigation.desktop-link>
            @endif
        </ul>
    </li>
    {{--    <x-ccm::navigation.desktop-settings />--}}
</ul>




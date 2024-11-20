<ul role="list" class="flex flex-1 flex-col gap-y-7">
    <li>
        <ul role="list" class="-mx-2 space-y-1" x-data="{ open: $persist(null) }">
            <x-ccm::navigation.desktop-link route="ccm::dashboard" label="Dashboard"/>

            @permission ('crm', 'overview')
            <x-ccm::navigation.desktop-link route="crm-cards::fields::overview" label="CRM">
                <x-ccm::navigation.desktop-link route="crm-cards::cards::overview" label="Kaarten" :sub="true"/>
                <x-ccm::navigation.desktop-link route="crm-cards::fields::overview" label="Velden" :sub="true"/>
            </x-ccm::navigation.desktop-link>
            @endpermission
            @permission ('cms', 'overview')
            <x-ccm::navigation.desktop-link route="cms::forms::overview" label="CMS">
                <x-ccm::navigation.desktop-link route="cms::forms::overview" label="Formulieren" :sub="true"/>
            </x-ccm::navigation.desktop-link>
            @endpermission
            @permission ('ems', 'overview')
            <x-ccm::navigation.desktop-link route="ems::emails::overview" label="EMS">
                <x-ccm::navigation.desktop-link route="ems::emails::overview" label="E-mails" :sub="true"/>
                <x-ccm::navigation.desktop-link route="ems::emailcontents::overview" label="Content" :sub="true"/>
            </x-ccm::navigation.desktop-link>
            @endpermission
            @permission ('gds', 'overview')
            <x-ccm::navigation.desktop-link route="target-groups::overview" label="Doelgroep selectie">
                <x-ccm::navigation.desktop-link route="target-groups::overview" label="Query builder" :sub="true"/>
            </x-ccm::navigation.desktop-link>
            @endpermission

            @isadmin
            <x-ccm::navigation.desktop-link route="admin::features" label="Beheer">
                <x-ccm::navigation.desktop-link route="admin::customers" label="Klanten" :sub="true"/>
                <x-ccm::navigation.desktop-link route="admin::environments" label="Omgevingen" :sub="true"/>
                <x-ccm::navigation.desktop-link route="roles::overview" label="Rollen" :sub="true"/>
                <x-ccm::navigation.desktop-link route="users::overview" label="Gebruikers" :sub="true"/>
            </x-ccm::navigation.desktop-link>
            @endisadmin
        </ul>
    </li>
    {{--    <x-ccm::navigation.desktop-settings />--}}
</ul>




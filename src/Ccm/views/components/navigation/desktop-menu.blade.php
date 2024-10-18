<ul role="list" class="flex flex-1 flex-col gap-y-7">
    <li>
        <ul role="list" class="-mx-2 space-y-1" x-data="{ open: $persist(null) }">
            <x-ccm::navigation.desktop-link route="ccm::dashboard" label="Dashboard"/>

            @feature('crm')
            <x-ccm::navigation.desktop-link route="crm-cards::fields::overview" label="CRM">
                <x-ccm::navigation.desktop-link route="crm-cards::cards::overview" label="Kaarten" :sub="true"/>
                <x-ccm::navigation.desktop-link route="crm-cards::fields::overview" label="Velden" :sub="true"/>
            </x-ccm::navigation.desktop-link>
            @endfeature
            @feature('ems')
            <x-ccm::navigation.desktop-link route="ems::emails::overview" label="EMS">
                <x-ccm::navigation.desktop-link route="ems::emails::overview" label="E-mails" :sub="true"/>
                <x-ccm::navigation.desktop-link route="ems::emailcontents::overview" label="Content" :sub="true"/>
            </x-ccm::navigation.desktop-link>
            @endfeature
            @feature('targetGroups')
            <x-ccm::navigation.desktop-link route="target-groups::overview" label="Doelgroep selectie">
                <x-ccm::navigation.desktop-link route="target-groups::overview" label="Query builder" :sub="true"/>
            </x-ccm::navigation.desktop-link>
            @endfeature

            @feature('admin')
            <x-ccm::navigation.desktop-link route="admin::features" label="Beheer">
                <x-ccm::navigation.desktop-link route="admin::features" label="Features" :sub="true"/>
            </x-ccm::navigation.desktop-link>
            @endfeature
        </ul>
    </li>
    {{--    <x-ccm::navigation.desktop-settings />--}}
</ul>




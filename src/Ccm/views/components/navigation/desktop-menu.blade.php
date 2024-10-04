<ul role="list" class="flex flex-1 flex-col gap-y-7">
    <li>
        <ul role="list" class="-mx-2 space-y-1">
            <x-ccm::navigation.desktop-link route="crm-cards::fields::overview" label="CRM">
                <x-ccm::navigation.desktop-link route="crm-cards::cards::overview" label="Kaarten" :sub="true"/>
                <x-ccm::navigation.desktop-link route="crm-cards::fields::overview" label="Velden" :sub="true"/>
            </x-ccm::navigation.desktop-link>
            <x-ccm::navigation.desktop-link route="ems::emails::overview" label="EMS">
                <x-ccm::navigation.desktop-link route="ems::emails::overview" label="E-mails" :sub="true"/>
                <x-ccm::navigation.desktop-link route="ems::emailcontents::overview" label="Content" :sub="true"/>
            </x-ccm::navigation.desktop-link>
            <x-ccm::navigation.desktop-link route="target-groups::overview" label="Doelgroep selectie"/>
        </ul>
    </li>
    {{--    <x-ccm::navigation.desktop-teams />--}}
    {{--    <x-ccm::navigation.desktop-settings />--}}
</ul>




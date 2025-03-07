<?php

namespace Sellvation\CCMV2\Ccm;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class CcmMenuServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(Router $router): void
    {
        \CcmMenu::addCcmMenuItem([
            'permission' => false,
            'label' => 'Dashboard',
            'route' => 'ccm::dashboard',
            'sub_items' => false,
        ]);
        \CcmMenu::addCcmMenuItem([
            'permission' => [
                'group' => 'crm',
                'item' => 'overview',
            ],
            'label' => 'CRM',
            'route' => 'crm-cards::fields::overview',
            'sub_items' => [
                [
                    'label' => 'Kaarten',
                    'route' => 'crm-cards::cards::overview',
                ],
                [
                    'label' => 'Velden',
                    'route' => 'crm-cards::fields::overview',
                ],
                [
                    'label' => 'Rubrieken',
                    'route' => 'crm-cards::categories::overview',
                ],
                [
                    'label' => 'Importeren',
                    'route' => 'crm-cards::imports::overview',
                    'permission' => [
                        'group' => 'crm',
                        'item' => 'import',
                    ],
                ],
            ],
        ]);
        \CcmMenu::addCcmMenuItem([
            'permission' => [
                'group' => 'cms',
                'item' => 'overview',
            ],
            'label' => 'CMS',
            'route' => 'cms::forms::overview',
            'sub_items' => [
                ['label' => 'Sites', 'route' => 'cms::sites::overview'],
                ['label' => 'Layouts', 'route' => 'cms::layouts::overview'],
                ['label' => 'JS/CSS', 'route' => 'cms::imports::overview'],
                ['label' => 'Pagina\'s', 'route' => 'cms::pages::overview'],
                ['label' => 'Contentblokken', 'route' => 'cms::blocks::overview'],
                ['label' => 'Formulieren', 'route' => 'cms::forms::overview'],
                ['label' => 'Data feeds', 'route' => 'cms::data_feeds::overview'],
                ['label' => 'Scrapers', 'route' => 'cms::scrapers::overview'],
            ],
        ]);
        \CcmMenu::addCcmMenuItem([
            'permission' => [
                'group' => 'ems',
                'item' => 'overview',
            ],
            'label' => 'EMS',
            'route' => 'ems::emails::overview',
            'sub_items' => [
                ['label' => 'E-mails', 'route' => 'ems::emails::overview'],
                ['label' => 'E-mail content', 'route' => 'ems::emailcontents::overview'],
                ['label' => 'Mailings', 'route' => 'ems::mailings::overview'],
            ],
        ]);
        \CcmMenu::addCcmMenuItem([
            'permission' => [
                'group' => 'gds',
                'item' => 'overview',
            ],
            'label' => 'Doelgroep selectie',
            'route' => 'target-groups::overview',
            'sub_items' => [
                ['label' => 'Query builders', 'route' => 'target-groups::overview'],
            ],
        ]);
        \CcmMenu::addCcmMenuItem([
            'permission' => 'admin',
            'label' => 'Beheer',
            'route' => 'admin::features',
            'sub_items' => [
                ['label' => 'Klanten', 'route' => 'admin::customers'],
                ['label' => 'Omgevingen', 'route' => 'admin::environments'],
                ['label' => 'E-mail domeinen', 'route' => 'admin::email_domains::overview'],
                ['label' => 'Mailservers', 'route' => 'admin::mailservers::overview'],
                ['label' => 'Verzendregels', 'route' => 'admin::sendrules::overview'],
                ['label' => 'Rollen', 'route' => 'roles::overview'],
                ['label' => 'Gebruikers', 'route' => 'users::overview'],
                ['label' => 'Extensies', 'route' => 'admin::extensions::overview'],
                ['label' => 'Taakplanner', 'route' => 'admin::scheduler::overview'],
            ],
        ]);
    }
}

<?php

namespace Sellvation\CCMV2\TargetGroups\Livewire;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Sellvation\CCMV2\Orders\Models\OrderType;
use Sellvation\CCMV2\TargetGroups\Elements\Column;
use Sellvation\CCMV2\TargetGroups\Elements\ColumnTypeBoolean;
use Sellvation\CCMV2\TargetGroups\Elements\ColumnTypeDate;
use Sellvation\CCMV2\TargetGroups\Elements\ColumnTypeInteger;
use Sellvation\CCMV2\TargetGroups\Elements\ColumnTypeIntegerArray;
use Sellvation\CCMV2\TargetGroups\Elements\ColumnTypePrice;
use Sellvation\CCMV2\TargetGroups\Elements\ColumnTypeProductArray;
use Sellvation\CCMV2\TargetGroups\Elements\ColumnTypeSelectInteger;
use Sellvation\CCMV2\TargetGroups\Elements\ColumnTypeTag;
use Sellvation\CCMV2\TargetGroups\Elements\ColumnTypeTargetGroup;
use Sellvation\CCMV2\TargetGroups\Elements\ColumnTypeText;
use Sellvation\CCMV2\TargetGroups\Elements\ColumnTypeTextArray;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroup;
use Spatie\Tags\Tag;

class Rule extends Component
{
    #[Modelable]
    public $filter;

    public $filterTmp;

    public $index;

    public bool $readonly = false;

    public bool $top = true;

    public $elements = [];

    public function mount()
    {
        $this->filterTmp = $this->filter;

        if (Arr::get($this->filter, 'columnType') === 'target_group') {
            if ($targetGroup = TargetGroup::find(Arr::get($this->filter, 'value'))) {
                $this->elements = $targetGroup->filters;
            }
        }
    }

    public function updated($property, $value)
    {
        if (Str::startsWith($property, 'filterTmp.')) {
            $column = $this->getColumnByName($this->filterTmp['column']);
            $this->filterTmp['columnType'] = $column?->columnType?->name;

            if ($property === 'filterTmp.column') {
                $this->filterTmp['value'] = null;

                switch ($this->filterTmp['columnType']) {
                    case 'tag':
                    case 'text':
                        $this->filterTmp['operator'] = 'eq';
                        break;
                    default:
                        $this->filterTmp['operator'] = null;
                }
            }

            $this->filter = $this->filterTmp;
        }

        if (in_array($property, ['filterTmp.operator', 'filterTmp.value', 'filterTmp.from', 'filterTmp.to', 'filterTmp.active'])) {
            $this->updateCount();
        }
    }

    private function updateCount()
    {
        $this->dispatch('update-count')->to(Form::class);
    }

    private function getColumns()
    {
        $columns = [];
        // First the order columns
        $columns[] = new Column('target_group_id', new ColumnTypeTargetGroup, '- Doelgroep selectie');

        if (Tag::query()->withType('crm-card-'.\Context::get('environment_id'))->count()) {
            $columns[] = new Column('tags', new ColumnTypeTag, '- Kenmerk');
        }

        $columns[] = new Column('first_email_send_at', new ColumnTypeDate, 'Eerste email verzonden');
        $columns[] = new Column('latest_email_send_at', new ColumnTypeDate, 'Laatste email verzonden');
        $columns[] = new Column('first_email_opened_at', new ColumnTypeDate, 'Eerste email geopend');
        $columns[] = new Column('latest_email_opened_at', new ColumnTypeDate, 'Laatste email geopend');
        $columns[] = new Column('first_email_clicked_at', new ColumnTypeDate, 'Eerste email geklikt');
        $columns[] = new Column('latest_email_clicked_at', new ColumnTypeDate, 'Laatste email geklikt');
        $columns[] = new Column('first_visit_at', new ColumnTypeDate, 'Eerste pagina bezocht');
        $columns[] = new Column('latest_visit_at', new ColumnTypeDate, 'Laatste pagina bezocht');
        //        $columns[] = new Column('browser_ua', new ColumnTypeText, 'browser_ua');
        //        $columns[] = new Column('browser', new ColumnTypeText, 'browser');
        //        $columns[] = new Column('browser_device_type', new ColumnTypeText, 'browser_device_type');
        //        $columns[] = new Column('browser_device', new ColumnTypeText, 'browser_device');
        //        $columns[] = new Column('browser_os', new ColumnTypeText, 'browser_os');
        //        $columns[] = new Column('mailclient_ua', new ColumnTypeText, 'mailclient_ua');
        //        $columns[] = new Column('mailclient', new ColumnTypeText, 'mailclient');
        //        $columns[] = new Column('mailclient_device_type', new ColumnTypeText, 'mailclient_device_type');
        //        $columns[] = new Column('mailclient_device', new ColumnTypeText, 'mailclient_device');
        //        $columns[] = new Column('mailclient_os', new ColumnTypeText, 'mailclient_os');

        if (Auth::user()->hasPermissionTo('gds', 'transactions')) {
            $columns[] = new Column('orders.store', new ColumnTypeIntegerArray, 'Transactie winkelnummer');
            $columns[] = new Column('orders.order_time', new ColumnTypeDate, 'Transactie transactie datum');
            $columns[] = new Column('orders.payment_method', new ColumnTypeText, 'Transactie betaalmethode');
            $columns[] = new Column('orders.total_price', new ColumnTypePrice, 'Transactie totaalprijs');
            $columns[] = new Column('orders.number_of_products', new ColumnTypeInteger, 'Transactie aantal producten');
            $columns[] = new Column('orders.order_rows.ean', new ColumnTypeIntegerArray, 'Transactie bevat EAN');
            $columns[] = new Column('orders.order_rows.sku', new ColumnTypeTextArray, 'Transactie bevat SKU');
            $columns[] = new Column('orders.order_type_id', new ColumnTypeSelectInteger(OrderType::pluck('name', 'id')->toArray()), 'Transactie type');

            if (Auth::user()->hasPermissionTo('gds', 'products')) {
                $columns[] = new Column('orders.order_rows.products.id', new ColumnTypeProductArray, 'Transactie bevat product');
            }
        }

        // CRM Card columns
        foreach (CrmField::whereEnvironmentId(Auth::user()->currentEnvironmentId)
            ->orderBy('name')
            ->get() as $crmField
        ) {
            switch ($crmField->type) {
                case 'BOOLEAN':
                case 'CONSENT':
                    $columnType = new ColumnTypeBoolean;
                    break;
                case 'DATETIME':
                    $columnType = new ColumnTypeDate;
                    break;
                case 'DECIMAL':
                case 'INT':
                    $columnType = new ColumnTypeInteger;
                    break;
                case 'MEDIA':
                    $columns[] = new Column('_'.$crmField->name.'_allowed', new ColumnTypeBoolean, $crmField->name.' Mailen toegestaan');
                    $columns[] = new Column('_'.$crmField->name.'_optin', new ColumnTypeBoolean, $crmField->name.' Optin');
                    $columns[] = new Column('_'.$crmField->name.'_optin_timestamp', new ColumnTypeDate, $crmField->name.' Optin timestamp');
                    $columns[] = new Column('_'.$crmField->name.'_confirmed_optin', new ColumnTypeBoolean, $crmField->name.' Confirmed optin option');
                    $columns[] = new Column('_'.$crmField->name.'_confirmed_optin_timestamp', new ColumnTypeDate, $crmField->name.' Confirmed optin timestamp');
                    $columns[] = new Column('_'.$crmField->name.'_optout', new ColumnTypeBoolean, $crmField->name.' Optout');
                    $columns[] = new Column('_'.$crmField->name.'_optout_timestamp', new ColumnTypeDate, $crmField->name.' Optout timestamp');

                    $columnType = false;
                    break;
                case 'EMAIL':
                    $columns[] = new Column($crmField->name, new ColumnTypeText, $crmField->name);
                    $columns[] = new Column('_'.$crmField->name.'_valid', new ColumnTypeBoolean, $crmField->name.' Geldig mailadres');
                    $columns[] = new Column('_'.$crmField->name.'_possible', new ColumnTypeBoolean, $crmField->name.' Mailen mogelijk');
                    $columns[] = new Column('_'.$crmField->name.'_abuse', new ColumnTypeBoolean, $crmField->name.' Abuse');
                    $columns[] = new Column('_'.$crmField->name.'_abuse_timestamp', new ColumnTypeDate, $crmField->name.' Abuse timestamp');
                    $columns[] = new Column('_'.$crmField->name.'_bounce_reason', new ColumnTypeText, $crmField->name.' Bounce reason');
                    $columns[] = new Column('_'.$crmField->name.'_bounce_score', new ColumnTypeInteger, $crmField->name.' Bounce score');
                    $columns[] = new Column('_'.$crmField->name.'_bounce_type', new ColumnTypeText, $crmField->name.' Bounce type');
                    $columns[] = new Column('_'.$crmField->name.'_type', new ColumnTypeText, $crmField->name.' Type e-mail');
                    $columnType = false;
                    break;
                default:
                    $columnType = new ColumnTypeText;
            }

            if ($columnType) {
                $columns[] = new Column($crmField->name, $columnType, $crmField->name);
            }

        }

        $columns = array_merge($columns, \CustomOrderFields::getRuleFields('orders'));

        $columns = Arr::sort($columns, fn ($column) => Str::lower($column->label));

        return $columns;
    }

    #[Computed]
    public function options()
    {
        $column = $this->getColumnByName($this->filter['column']);

        return $column->columnType->options;
    }

    private function getColumnByName($name)
    {
        return Arr::first($this->getColumns(), function ($row) use ($name) {
            return $row->name === $name;
        });
    }

    public function render()
    {
        return view('target-group::livewire.rule')
            ->with([
                'columns' => $this->getColumns(),
                'targetGroups' => TargetGroup::orderBy('name')->get(),
                'tags' => Tag::withType('crm-card-'.\Context::get('environment_id'))->orderBy('name')->get(),
            ]);
    }
}

<?php

namespace Sellvation\CCMV2\TargetGroups\Livewire;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Sellvation\CCMV2\Orders\Models\OrderType;
use Sellvation\CCMV2\TargetGroups\Elements\Column;
use Sellvation\CCMV2\TargetGroups\Elements\ColumnTypeBoolean;
use Sellvation\CCMV2\TargetGroups\Elements\ColumnTypeDate;
use Sellvation\CCMV2\TargetGroups\Elements\ColumnTypeInteger;
use Sellvation\CCMV2\TargetGroups\Elements\ColumnTypeIntegerArray;
use Sellvation\CCMV2\TargetGroups\Elements\ColumnTypeProductArray;
use Sellvation\CCMV2\TargetGroups\Elements\ColumnTypeSelect;
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

    #[Locked]
    public string $uniq;

    public function mount()
    {
        $this->uniq = uniqid();
    }

    public function updated($property, $value)
    {
        if (Str::startsWith($property, 'filter.')) {
            $column = $this->getColumnByName($this->filter['column']);
            $this->filter['columnType'] = $column->columnType->name;

            if ($property === 'filter.column') {
                $this->filter['value'] = null;

                switch ($this->filter['columnType']) {
                    case 'target_group':
                    case 'tag':
                    case 'text':
                        $this->filter['operator'] = 'eq';
                        break;
                    case 'select':
                        $this->filter['value'] = [];
                        break;
                    default:
                        $this->filter['operator'] = null;
                }
            }
        }

        $this->dispatch('update-count')->to(Form::class);
    }

    private function getColumns()
    {
        $columns = [];
        // First the order columns
        $columns[] = new Column('target_group_id', new ColumnTypeTargetGroup, '- Doelgroep selectie');
        $columns[] = new Column('tags', new ColumnTypeTag, '- Kenmerk');
        $columns[] = new Column('orders.store', new ColumnTypeIntegerArray, 'Transactie winkelnummer');
        $columns[] = new Column('orders.order_time', new ColumnTypeDate, 'Transactie transactie datum');
        $columns[] = new Column('orders.payment_method', new ColumnTypeText, 'Transactie betaalmethode');
        $columns[] = new Column('orders.total_price', new ColumnTypeInteger, 'Transactie totaalprijs');
        $columns[] = new Column('orders.number_of_products', new ColumnTypeInteger, 'Transactie aantal producten');
        $columns[] = new Column('orders.order_rows.products.eans', new ColumnTypeTextArray, 'Transactie bevat EAN');
        $columns[] = new Column('orders.order_rows.products.sku', new ColumnTypeTextArray, 'Transactie bevat SKU');
        $columns[] = new Column('orders.order_rows.products.id', new ColumnTypeProductArray, 'Transactie bevat product');
        $columns[] = new Column('orders.order_type_id', new ColumnTypeSelect(OrderType::pluck('name', 'id')->toArray()), 'Transactie type');

        // CRM Card columns
        foreach (CrmField::whereEnvironmentId(Auth::user()->currentEnvironmentId)
            ->whereIsShownOnTargetGroupBuilder(1)
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
                    $columns[] = new Column('_'.$crmField->name.'_optin', new ColumnTypeBoolean, $crmField->name.' Optin');
                    $columns[] = new Column('_'.$crmField->name.'_optin_timestamp', new ColumnTypeDate, $crmField->name.' Optin timestamp');
                    $columns[] = new Column('_'.$crmField->name.'_confirmed_optin', new ColumnTypeBoolean, $crmField->name.' Confirmed optin option');
                    $columns[] = new Column('_'.$crmField->name.'_confirmed_optin_timestamp', new ColumnTypeDate, $crmField->name.' Confirmed optin timestamp');
                    $columns[] = new Column('_'.$crmField->name.'_confirmed_optout', new ColumnTypeBoolean, $crmField->name.' Optout');
                    $columns[] = new Column('_'.$crmField->name.'_optout_timestamp', new ColumnTypeDate, $crmField->name.' Optout timestamp');

                    $columnType = false;
                    break;
                case 'EMAIL':
                    $columns[] = new Column($crmField->name, new ColumnTypeText, $crmField->name);
                    $columns[] = new Column('_'.$crmField->name.'_valid', new ColumnTypeBoolean, $crmField->name.' Geldig mailadres');
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
                'targetGroup' => TargetGroup::orderBy('name')->get(),
                'tags' => Tag::withType('crm-card-'.\Context::get('environment_id'))->orderBy('name')->get(),
            ]);
    }
}

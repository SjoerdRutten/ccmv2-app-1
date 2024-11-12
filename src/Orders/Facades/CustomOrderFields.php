<?php

namespace Sellvation\CCMV2\Orders\Facades;

use Illuminate\Support\Facades\Context;
use Sellvation\CCMV2\TargetGroups\Elements\Column;

class CustomOrderFields
{
    private array $schemaFields = [];

    private array $ruleFields = [];

    public function addSchemaField(string $tableName, array $field)
    {
        $this->schemaFields[$tableName][] = $field;

        Context::add('schemaFields', $this->schemaFields);
    }

    public function addRuleField(string $tableName, Column $column)
    {
        $this->ruleFields[$tableName][] = $column;

        Context::add('ruleFields', $this->ruleFields);
    }

    public function getSchemaFields(string $tableName): array
    {
        $schemaFields = Context::has('schemaFields') ? Context::get('schemaFields') : $this->schemaFields;

        return \Arr::get($schemaFields, $tableName, []);
    }

    public function getRuleFields(string $tableName): array
    {
        $ruleFields = Context::has('ruleFields') ? Context::get('ruleFields') : $this->ruleFields;

        return \Arr::get($ruleFields, $tableName, []);
    }
}

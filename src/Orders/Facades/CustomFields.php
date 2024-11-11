<?php

namespace Sellvation\CCMV2\Orders\Facades;

class CustomFields
{
    private array $schemaFields = [];

    private array $dataFields = [];

    public function addSchemaField(string $tableName, array $field)
    {
        $this->schemaFields[$tableName][] = $field;
    }

    public function getSchemaFields(string $tableName): array
    {
        return $this->schemaFields[$tableName] ?? [];
    }
}

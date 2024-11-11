<?php

namespace Sellvation\CCMV2\Orders\Facades;

class CustomFields
{
    private array $schemaFields = [];

    private array $dataFields = [];

    public function addField(string $tableName, array $schema = [], string $data = '')
    {
        $this->schemaFields[$tableName][] = $schema;
        $this->dataFields[$tableName][] = $data;
    }
}

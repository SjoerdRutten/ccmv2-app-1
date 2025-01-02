<?php

namespace Sellvation\CCMV2\CrmCards\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithLimit;

class CrmCardLimitArrayImport implements WithCustomCsvSettings, WithLimit
{
    use Importable;

    public function __construct(private array $config) {}

    public function limit(): int
    {
        return 150;
    }

    public function array(array $array)
    {
        return $array;
    }

    public function getCsvSettings(): array
    {
        switch ($this->config['enclosure']) {
            case 'dq':
                $this->config['enclosure'] = '"';
                break;
            case 'q':
                $this->config['enclosure'] = '\'';
                break;
            default:
                $this->config['enclosure'] = '';
        }

        $this->config['delimiter'] = $this->config['delimiter'] === '\t' ? "\t" : $this->config['delimiter'];

        return $this->config;
    }
}

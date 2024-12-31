<?php

namespace Sellvation\CCMV2\CrmCards\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithLimit;

class CrmCardLimitArrayImport implements WithChunkReading, WithHeadingRow, WithLimit
{
    use Importable;

    //    public function __construct(private int $startRow = 0) {}

    public function chunkSize(): int
    {
        return 1;
    }

    public function limit(): int
    {
        return 150;
    }

    public function array(array $array)
    {
        return $array;
    }
}

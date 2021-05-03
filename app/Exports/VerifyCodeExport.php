<?php

namespace App\Exports;

use App\Exports\Sheets\VerifyCodeSheet;
use App\Invoice;
use App\VerifyCode;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class VerifyCodeExport implements WithMultipleSheets
{
    use Exportable;

    public function __construct(int $seller_id)
    {
        $this->seller_id = $seller_id;
    }

    public function sheets(): array
    {
        $sheets = [];

        for ($type = 0; $type <= 2; $type++) {
            $sheets[] = new VerifyCodeSheet($type, $this->seller_id);
        }
        
        return $sheets;
    }
}
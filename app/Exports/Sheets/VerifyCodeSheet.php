<?php

namespace App\Exports\Sheets;

use App\VerifyCode;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;

class VerifyCodeSheet implements FromQuery, WithTitle
{
    private $month;
    private $year;

    public function __construct(int $type, int $seller_id)
    {
        $this->type = $type;
        $this->seller_id  = $seller_id;
    }

    /**
     * @return Builder
     */
    public function query()
    {
        return VerifyCode::query()
            ->where('type', $this->type)
            ->where('seller_id', $this->seller_id)
            ->whereNull('customer_id');
    }

    /**
     * @return string
     */
    public function title(): string
    {
        if ($this->type == 0) {
            return '7 days';
        } else if ($this->type == 1) {
            return '15 days';
        } else {
            return '30 days';
        }
    }
}
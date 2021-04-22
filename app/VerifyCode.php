<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerifyCode extends Model
{
    protected $table = 'verify_codes';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function rCustomer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function rSeller() {
        return $this->belongsTo(User::class, 'seller_id');
    }
}

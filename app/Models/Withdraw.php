<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Withdraw extends Model
{
    const UPDATED_AT = null;

    public static $DEFAULT_STATUS = "WAITING_TO_PROCESS";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'trx_id', 'bank_code', 'account_number', 'amount', 'remark', 'status',
        'receipt', 'time_served', 'fee', 'beneficiary_name'
    ];

    public function statusHistories()
    {
        return $this->hasMany('App\Models\StatusHistory');
    }

    public function db()
    {
        return DB::table($this->getTable());
    }
}

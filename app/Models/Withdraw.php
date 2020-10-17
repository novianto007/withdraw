<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Withdraw extends Model
{
    const UPDATED_AT = null;

    public static $DEFAULT_STATUS = "WAITING_TO_PROCCESS";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bank_code', 'account_number', 'amount', 'remark'
    ];

    public function db()
    {
        return DB::table($this->getTable());
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StatusHistory extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'withdraw_id', 'status', 'timestamp'
    ];

    public function db()
    {
        return DB::table($this->getTable());
    }
}

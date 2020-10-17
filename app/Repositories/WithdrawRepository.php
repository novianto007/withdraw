<?php

namespace App\Repositories;

use App\Models\Withdraw;
use Carbon\Carbon;

class WithdrawRepository
{
    private $model;

    public function __construct(Withdraw $model)
    {
        $this->model = $model;
    }

    public function getById(int $id)
    {
        $withdraw = $this->model->db()->where('id', $id)->first();
        return $withdraw;
    }

    public function getByUserId(int $userId, int $paginate = 50)
    {
        $res = $this->model->db()->where('user_id', $userId)
            ->select(['id', 'created_at', 'bank_code', 'account_number', 'amount', 'remark', 'status'])
            ->paginate($paginate);
        return $res;
    }

    public function save(array $data, int $userId)
    {
        $withdraw = $this->model;
        $withdraw->fill($data);
        $withdraw->user_id = $userId;
        $withdraw->status = WithDraw::$DEFAULT_STATUS;
        $withdraw->last_check = Carbon::now();
        return $withdraw->save();
    }
}

<?php

namespace App\Repositories;

use App\Models\StatusHistory;
use App\Models\Withdraw;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class WithdrawRepository
{
    private $model;
    private $statusHistoryModel;

    public function __construct(Withdraw $model, StatusHistory $statusHistoryModel)
    {
        $this->model = $model;
        $this->statusHistoryModel = $statusHistoryModel;
    }

    public function getById(int $id)
    {
        $withdraw = $this->model->with(['statusHistories' => function ($query) {
            $query->orderByDesc('timestamp');
        }])->where('id', $id)->first();
        return $withdraw;
    }

    public function getByUserId(int $userId, int $paginate = 50)
    {
        $res = $this->model->db()->where('user_id', $userId)
            ->select(['id', 'created_at', 'bank_code', 'account_number', 'amount', 'remark', 'status'])
            ->paginate($paginate);
        return $res;
    }

    public function save(array $data, int $userId): int
    {
        $withdraw = $this->model;
        $withdraw->fill($data);
        $withdraw->user_id = $userId;
        $withdraw->status = WithDraw::$DEFAULT_STATUS;
        $withdraw->save();
        return $withdraw->id;
    }

    public function update(array $data, int $id, $withHisory = true)
    {
        try {
            DB::beginTransaction();

            $filteredData = array_intersect_key($data, array_flip($this->model->getFillable()));
            $this->model->where('id', $id)->update($filteredData);

            if ($withHisory) {
                $statusHistory = $this->statusHistoryModel->fill($data);
                $statusHistory->withdraw_id = $id;
                $statusHistory->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }
}

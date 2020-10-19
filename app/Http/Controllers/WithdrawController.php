<?php

namespace App\Http\Controllers;

use App\Helpers\CircuitBreaker;
use App\Jobs\CreateDisbursement;
use App\Models\Withdraw;
use App\Repositories\WithdrawRepository;
use App\Services\WithdrawService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawController extends Controller
{
    private $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(WithdrawRepository $repository)
    {
        $this->middleware('auth');
        $this->repository = $repository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $withdraws = $this->repository->getByUserId(Auth::user()->id);

        return view('withdraw.list', [
            'withdraws' => $withdraws,
            'number' => $withdraws->perPage() * ($withdraws->currentPage() - 1) + 1
        ]);
    }

    /**
     * Show crate withdraw form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showCreateForm()
    {
        return view('withdraw.create');
    }

    /**
     * save withdraw transaction.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request, WithdrawService $service)
    {
        $data = $request->validate([
            'bank_code' => 'required|string',
            'account_number' => 'required|string',
            'amount' => 'required|integer',
            'remark' => 'required|string',
        ]);
        $withdrawId = $this->repository->save($data, Auth::user()->id);
        CreateDisbursement::dispatch($data, $withdrawId);
        return redirect('withdraw')->with('msg', 'Withdraw created successfully');
    }

    public function detail($id)
    {
        $withdraw = $this->repository->getById($id);
        if ($withdraw) {
            $enableStatusCheck = (!in_array($withdraw->status, [Withdraw::$DEFAULT_STATUS, Withdraw::$FAILED_STATUS]));
            return view('withdraw.detail', compact('withdraw', 'enableStatusCheck'));
        }
        abort(404);
    }

    public function updateStatus($id, WithdrawService $service)
    {
        $serviceName = 'update-status';
        if (CircuitBreaker::attemps($serviceName, 500)) {
            $withdraw = $this->repository->getById($id);
            if (!$withdraw) {
                abort(404);
                return;
            }

            try {
                $result = $service->checkDisbursementStatus($withdraw->trx_id);
                $this->repository->update($result, $id, $result['status'] != $withdraw->status);
                CircuitBreaker::success($serviceName);
            } catch (Exception $e) {
                CircuitBreaker::failed($serviceName);
            }
        }
        return redirect('withdraw/detail/' . $id);
    }
}

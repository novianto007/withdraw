<?php

namespace App\Jobs;

use App\Models\Withdraw;
use App\Repositories\WithdrawRepository;
use App\Services\WithdrawService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class CreateDisbursement implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The maximum number of exceptions to allow before failing.
     *
     * @var int
     */
    public $maxExceptions = 3;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 10;

    private $data;
    private $withdrawId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $withdrawId)
    {
        $this->data = $data;
        $this->withdrawId = $withdrawId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(WithdrawService $service, WithdrawRepository $repository)
    {
        $result = $service->createDisbursement($this->data);
        $result['trx_id'] = $result['id'];
        $repository->update($result, $this->withdrawId);
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(Throwable $exception, WithdrawRepository $repository)
    {
        $repository->update(['status' => Withdraw::$FAILED_STATUS], $this->withdrawId, false);
    }
}

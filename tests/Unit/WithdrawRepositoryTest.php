<?php

namespace Tests\Unit;

use App\Models\StatusHistory;
use App\Models\Withdraw;
use App\Repositories\WithdrawRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use UserSeeder;

class WithdrawRepositoryTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;
    
    private $id;
    private $repository;
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([UserSeeder::class]);

        $this->repository = new WithdrawRepository(new Withdraw(), new StatusHistory());
    }

    public function testSave()
    {
        $data = [
            'bank_code' => 'bca',
            'account_number' => '12312345',
            'amount' => 1000000,
            'remark' => 'sample_remark'
        ];
        
        $id = $this->repository->save($data, 1);
        $this->assertNotNull($id);
        $this->id = $id;
    }

    public function testGetByIdAndDefaultStatus()
    {
        $this->testSave();
        $data = $this->repository->getById($this->id);
        $this->assertTrue($data->status == Withdraw::$DEFAULT_STATUS);
    }

    public function testGetByUserId()
    {
        $this->testSave();
        $data = $this->repository->getByUserId(1);
        $this->assertTrue($data instanceof \Illuminate\Pagination\LengthAwarePaginator);
        $items = $data->items();
        $this->assertTrue($items[0]->id == $this->id);
    }

    public function testUpdate()
    {
        $data = [
            "id" => 1137507957,
            "amount" => 10000,
            "status" => "PENDING",
            "timestamp" => "2020-10-18 10:48:45",
            "bank_code" => "bni",
            "account_number" => "1234567890",
            "beneficiary_name" => "PT FLIP",
            "remark" => "sample remark",
            "receipt" => "https:\/\/flip-receipt.oss-ap-southeast-5.aliyuncs.com\/debit_receipt\/126316_3d07f9fef9612c7275b3c36f7e1e5762.jpg",
            "time_served" => "2020-10-18 10:57:45",
            "fee" => 4000
        ];

        $this->testSave();
        $this->repository->update($data, $this->id);
        $res = $this->repository->getById($this->id);
        $this->assertTrue($res->status == 'PENDING');
    }
}

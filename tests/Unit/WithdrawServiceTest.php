<?php

namespace Tests\Unit;

use App\Services\WithdrawService;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

class WithdrawServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        app()->bind('api-client', function(){
            $mock = new MockHandler([
                new Response(200, [], '{
                    "id": 1137507957,
                    "amount": 10000,
                    "status": "PENDING",
                    "timestamp": "2020-10-18 10:48:45",
                    "bank_code": "bni",
                    "account_number": "1234567890",
                    "beneficiary_name": "PT FLIP",
                    "remark": "sample remark",
                    "receipt": "https:\/\/flip-receipt.oss-ap-southeast-5.aliyuncs.com\/debit_receipt\/126316_3d07f9fef9612c7275b3c36f7e1e5762.jpg",
                    "time_served": "2020-10-18 10:57:45",
                    "fee": 4000
                  }'),
            ]);
        
            $handler = HandlerStack::create($mock);
            return new Client(['handler' => $handler]);
        });
    }

    public function testCreateDisbursement()
    {
        $service = new WithdrawService();
        $res = $service->createDisbursement(['data']);
        $this->assertTrue(is_array($res));
        $this->assertTrue($res['id'] == '1137507957');
    }

    public function testcheckDisbursementStatus()
    {
        $service = new WithdrawService();
        $res = $service->checkDisbursementStatus(1);
        $this->assertTrue(is_array($res));
        $this->assertTrue($res['id'] == '1137507957');
    }
}

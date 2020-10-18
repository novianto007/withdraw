<?php

namespace App\Services;

use App\Helpers\ApiCaller;

class WithdrawService
{
    private $client;

    public function __construct()
    {
        $this->client = app('api-client');
    }

    public function createDisbursement(array $data): array
    {
        $apiCallFunc = function () use ($data) {
            $res = $this->client->request('POST', '/disburse', [
                'form_params' => $data
            ]);
            $content = json_decode($res->getBody()->getContents(), true);
            return $content;
        };

        return ApiCaller::wrap($apiCallFunc, 2);
    }

    public function checkDisbursementStatus(int $trxId): array
    {
        $apiCallFunc = function () use ($trxId) {
            $res = $this->client->request('GET', '/disburse/' . $trxId);
            $content = json_decode($res->getBody()->getContents(), true);
            return $content;
        };

        return ApiCaller::wrap($apiCallFunc, 2);
    }
}

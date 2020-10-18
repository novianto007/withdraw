<?php

namespace App\Services;

class WithdrawService
{
    private $client;

    public function __construct()
    {
        $this->client = app('api-client');
    }

    public function createDisbursement(array $data): array
    {
        $res = $this->client->request('POST', '/disburse', [
            'form_params' => $data
        ]);
        $content = json_decode($res->getBody()->getContents(), true);
        return $content;
    }

    public function checkDisbursementStatus(int $trxId): array
    {
        $res = $this->client->request('GET', '/disburse/' . $trxId);
        $content = json_decode($res->getBody()->getContents(), true);
        return $content;
    }
}

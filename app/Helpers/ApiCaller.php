<?php

namespace App\Helpers;

class ApiCaller
{
    public static function wrap($apiCallFunc, $retry = 1)
    {
        for ($i = 0; $i < $retry; $i++) {
            try {
                return $apiCallFunc();
            } catch (\Exception $e) {
                if ($i == $retry - 1) {
                    throw $e;
                }
            }
        }
    }
}

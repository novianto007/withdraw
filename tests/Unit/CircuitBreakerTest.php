<?php

namespace Tests\Unit;

use App\Helpers\CircuitBreaker;
use Tests\TestCase;

class CircuitBreakerTest extends TestCase
{
    private $serviceName = "app-test";
    private $threshold = 50;

    public function testUnavailableOnThresholdReach()
    {
        for ($i = 0; $i < $this->threshold; $i++) {
            $this->assertTrue(CircuitBreaker::isAvailable($this->serviceName, $this->threshold));
        }
        $this->assertFalse(CircuitBreaker::isAvailable($this->serviceName, $this->threshold));
    }

    public function testAvailableAfterFailedOrSuccess()
    {
        for ($i = 0; $i < 20; $i++) {
            CircuitBreaker::failed($this->serviceName);
        }

        for ($i = 0; $i < 20; $i++) {
            CircuitBreaker::success($this->serviceName);
        }
        $this->assertTrue(CircuitBreaker::isAvailable($this->serviceName, $this->threshold));
    }

    public function testHalfOpen()
    {
        for ($i = 0; $i < CircuitBreaker::$maxError; $i++) {
            CircuitBreaker::failed($this->serviceName);
        }
        $this->assertFalse(CircuitBreaker::isAvailable($this->serviceName, $this->threshold));
        
        sleep(121);
        $this->assertTrue(CircuitBreaker::isAvailable($this->serviceName, $this->threshold));
        
        $this->assertFalse(CircuitBreaker::isAvailable($this->serviceName, $this->threshold));
        CircuitBreaker::success($this->serviceName);
        sleep(61);
        $this->assertTrue(CircuitBreaker::isAvailable($this->serviceName, $this->threshold));
    }
}

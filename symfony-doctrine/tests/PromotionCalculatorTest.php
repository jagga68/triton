<?php

namespace App\Tests;

use App\Services\PromotionCalculator;
use PHPUnit\Framework\TestCase;

class PromotionCalculatorTest extends TestCase
{
    public function testSomething(): void
    {
        $calculator = $this->getMockBuilder(PromotionCalculator::class)->setMethods(['getPromotionPercentage'])->getMock();

        $calculator->expects($this->any())
            ->method('getPromotionPercentage')
            ->willReturn(20);
        
        $result = $calculator->calculatePriceAfterPromotion(1,9);
        $this->assertEquals(8, $result);
        
        
        $result = $calculator->calculatePriceAfterPromotion(10,20,50);
        $this->assertEquals(64 , $result);

    }
}

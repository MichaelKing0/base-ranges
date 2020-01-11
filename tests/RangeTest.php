<?php

namespace Tests;

use MichaelKing0\BaseRanges\Range;
use PHPUnit\Framework\TestCase;

class RangeTest extends TestCase
{
    public function testGetRange()
    {
        $range = new Range(2, 10, null, 1);

        $this->assertEquals(['1'], $range->getRange());
        $this->assertEquals(null, $range->getRange(1));
    }

    public function testGetRangeComplex()
    {
        $range = new Range(2, 10, null, 2);
        $this->assertEquals(['01', '10', '11'], $range->getRange());
    }

    public function testGetRangePagination()
    {
        $range = new Range(2, 10, null, 8);
        $result1 = $range->getRange();
        $result2 = $range->getRange(1);
        $this->assertCount(10, $result1);
        $this->assertCount(10, $result2);

        // Make sure pagination/offset works
        $this->assertEquals(bindec($result1[9]) + 1, bindec($result2[0]));
    }

    public function testGetRangeWithMaxNumber()
    {
        $range = new Range(2, 10, 2, 2);
        $this->assertEquals(['01', '10'], $range->getRange());
    }

    public function testGetMaxPages()
    {
        $range = new Range(2, 50, null, 8);
        $this->assertEquals(6, $range->getMaxPages());
    }
}

<?php
/**
 * PriceTest для проверки класса Price
 * 
 * (c) Степан Карасов
*/

namespace common\tests\unit\services;

use common\services\Price;
use Codeception\Test\Unit;

class PriceTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    /**
    * @dataProvider providerCompare
    */
    public function testCompare($max_deviation, $current, $previous, $result)
    {
        $Price = new Price(['max_deviation' => $max_deviation, 'current' => $current, 'previous' => $previous]);
        //$this->assertEquals($result, $Price->compare);
        expect($Price->compare)->equals($result);
    }

    /**
    * @dataProvider providerTrendChange
    */
    public function testTrendChange($max_deviation, $current, $previous, $result)
    {
        $Price = new Price(['max_deviation' => $max_deviation, 'current' => $current, 'previous' => $previous]);
        $this->assertEquals($result, $Price->trend_change);
    }

    
    /**
    * Массив входных данных providerCompare
    * @params [[$max_deviation, $current, $previous, $result],]
    */
    public function providerCompare ()
    {
        return [
            [10, 250, 230, true],
            [10, 200, 250, false],
            [20, 220, 250, true],
            [10, 250, 250, true],
            [20, 5, null, true]
        ];
    }

    /**
    * Массив входных данных providerTrendChange
    * @params [[$max_deviation, $current, $previous, $result],]
    */
    public function providerTrendChange ()
    {
        return [
            [10, 230, 250, 1],
            [10, 200, 250, -1],
            [20, 220, 250, -1],
            [10, 250, 250, 0],
            [20, 100, null, false]
        ];
    }
}
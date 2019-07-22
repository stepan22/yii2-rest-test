<?php
namespace tests\unit\common\services;

use common\services\Price;
//require_once '/var/www/smartypanel.ru/common/services/Price.php';


class PriceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
    * @dataProvider providerCompare
    */
    public function testCompare($max_deviation, $current, $previous, $result)
    {
        $Price = new Price(['max_deviation' => $max_deviation, 'current' => $current, 'previous' => $previous]);
        $this->assertEquals($result, $Price->compare);
    }

    /**
    * @dataProvider providerTrendChange
    */
    public function testTrendChange($max_deviation, $current, $previous, $result)
    {
        $Price = new Price(['max_deviation' => $max_deviation, 'current' => $current, 'previous' => $previous]);
        $this->assertEquals($result, $Price->trend_change);
    }

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
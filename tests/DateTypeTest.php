<?php
/**
 * Created by PhpStorm.
 * User: xushengbin
 * Date: 2018/12/7
 * Time: 13:00
 */

use PHPUnit\Framework\TestCase;
use PhpDataType\DateType;

class DateTypeTest extends TestCase
{

    /**
     * @throws \PhpDataType\NotSupportDateTypeException
     */
    public function testDateType()
    {
        // 正常的工作日
        $DateType = new DateType('2018-12-07');
        $this->assertEquals(DateType::WORK_DAY_TYPE, $DateType->getType());
        $DateType = new DateType('2019-05-02');
        $this->assertEquals(DateType::WORK_DAY_TYPE, $DateType->getType());

        // 周末，但是要上班
        $DateType = new DateType('2018-12-29');
        $this->assertEquals(DateType::WORK_DAY_TYPE, $DateType->getType());

        // 法定节假日
        $DateType = new DateType('20190101');
        $this->assertEquals(DateType::STATUTORY_HOLIDAY_TYPE, $DateType->getType());

        $DateType = new DateType('2019-10-01');
        $this->assertEquals(DateType::STATUTORY_HOLIDAY_TYPE, $DateType->getType());

        $DateType = new DateType('2019-05-01');
        $this->assertEquals(DateType::STATUTORY_HOLIDAY_TYPE, $DateType->getType());

        // 休息日
        $DateType = new DateType('2018-12-31');
        $this->assertEquals(DateType::REST_DAY, $DateType->getType());

        // 周末
        $DateType = new DateType('2019-01-12');
        $this->assertEquals(DateType::WEEKEND_TYPE, $DateType->getType());
    }
}
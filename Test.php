<?php

namespace tipounet\bankHolidays;

use PHPUnit\Framework\TestCase;

require_once 'bankHolidays.php';


class Test extends TestCase
{

    public function testGetEasterDay()
    {
        $expected = new \DateTime('2017-04-16');
        $b = new BankHolidayUtils();
        $this->assertEquals($expected, $b->getEasterDayConwayMethod(2017));
        $this->assertEquals($expected, $b->getEasterDay(2017));
    }

    public function testGetEasterDay2016()
    {
        $expected = new \DateTime('2016-03-27');
        $b = new BankHolidayUtils();
        $this->assertEquals($expected, $b->getEasterDayConwayMethod(2016));
        $this->assertEquals($expected, $b->getEasterDay(2016));
    }

    public function testIsBankHolidays2017()
    {
        $b = new BankHolidayUtils();
        $this->assertTrue($b->isBankHoliday(new \DateTime('2017-01-01')));
        $this->assertTrue($b->isBankHoliday(new \DateTime('2017-04-17')));
        $this->assertTrue($b->isBankHoliday(new \DateTime('2017-05-01')));
        $this->assertTrue($b->isBankHoliday(new \DateTime('2017-05-08')));
        $this->assertTrue($b->isBankHoliday(new \DateTime('2017-05-25')));
        $this->assertTrue($b->isBankHoliday(new \DateTime('2017-06-05')));
        $this->assertTrue($b->isBankHoliday(new \DateTime('2017-07-14')));
        $this->assertTrue($b->isBankHoliday(new \DateTime('2017-08-15')));
        $this->assertTrue($b->isBankHoliday(new \DateTime('2017-11-01')));
        $this->assertTrue($b->isBankHoliday(new \DateTime('2017-11-11')));
        $this->assertTrue($b->isBankHoliday(new \DateTime('2017-12-25')));
        $this->assertTrue($b->isBankHoliday(new \DateTime('2017-12-31')));
        $this->assertTrue($b->isBankHoliday(new \DateTime('2017-04-16')));
    }

    public function testGetJulianEasterDay()
    {
        $expected = new \DateTime('2010-3-22');
        $b = new BankHolidayUtils();
        $this->assertEquals($expected, $b->getJulianEasterDay(2010));

        $expected = new \DateTime('2013-4-22');
        $b = new BankHolidayUtils();
        $this->assertEquals($expected, $b->getJulianEasterDay(2013));

        $expected = new \DateTime('2014-4-7');
        $b = new BankHolidayUtils();
        $this->assertEquals($expected, $b->getJulianEasterDay(2014));

        $expected = new \DateTime('2017-4-3');//16/04 grégorien
        $b = new BankHolidayUtils();
        $this->assertEquals($expected, $b->getJulianEasterDay(2017));

        $expected = new \DateTime('2018-3-26');//8/4 grégorien
        $b = new BankHolidayUtils();
        $this->assertEquals($expected, $b->getJulianEasterDay(2018));

        $expected = new \DateTime('2019-4-15'); // 28/04 grégorien
        $b = new BankHolidayUtils();
        $this->assertEquals($expected, $b->getJulianEasterDay(2019));


        $expected = new \DateTime('2040-4-23'); //6/5 grégorien
        $b = new BankHolidayUtils();
        $this->assertEquals($expected, $b->getJulianEasterDay(2040));
    }
}

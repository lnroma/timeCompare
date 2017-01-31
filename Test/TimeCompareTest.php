<?php
/**
 * unit test for TimeCompare class
 */
include('../vendor/autoload.php');
include('../classes/TimeCompare.php');

class TimeCompareTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider providerCompareTime
     */
    public function testCompareTime($range1, $range2, $result)
    {
        $compare = new TimeCompare();
        $this->assertEquals($result, $compare->compareTime($range1, $range2));
    }

    public function providerCompareTime()
    {
        return array(
            array(
                array('10:00', '12:00'),
                array('9:00', '11:00'),
                array('10:00', '11:00'),
            ),
            array(
                array('10:00', '12:00'),
                array('9:00', '10:00'),
                array('10:00', '10:00'),
            ),
            array(
                array('10:00', '12:00'),
                array('11:00', '13:00'),
                array('11:00', '12:00'),
            ),
            array(
                array('9:00', '13:00'),
                array('10:00', '11:00'),
                array('10:00', '11:00'),
            ),
            array(
                array('9:00', '11:00'),
                array('10:00', '12:00'),
                array('10:00', '11:00'),
            ),
            array(
                array('9:00', '10:00'),
                array('10:00', '12:00'),
                array('10:00', '10:00'),
            ),
            array(
                array('11:00', '13:00'),
                array('10:00', '12:00'),
                array('11:00', '12:00'),
            ),
            array(
                array('10:00', '11:00'),
                array('9:00', '13:00'),
                array('10:00', '11:00'),
            ),
        );
    }
}

<?php

/**
 * TimeCompare class for test task
 */
class TimeCompare
{
    const RANGE_2_CENTER = 1;
    const RANGE_1_LEFT = 2;
    const RANGE_1_RIGHT = 3;
    const RANGE_1_CENTER = 4;
    const RANGE_2_LEFT = 5;
    const RANGE_2_RIGHT = 6;

    /**
     * timeInterval1 and timeInterval2 this is array
     *
     * array(
     *  0 => 10:00 // start interval time
     *  1   => 12:00 // end interval time
     * )
     *
     * @param array $timeInterval1
     * @param array $timeInterval2
     * @param $formatTime
     */
    public function compareTime($timeInterval1, $timeInterval2)
    {
        // using for input time as standart
        $timeIntervalTmp1 = array(
            new DateTime($timeInterval1[0]),
            new DateTime($timeInterval1[1]),
        );

        $timeIntervalTmp2 = array(
            new DateTime($timeInterval2[0]),
            new DateTime($timeInterval2[1]),
        );

        $timeIL1 = (int)($timeIntervalTmp1[0]->format('Hi'));
        $timeIR1 = (int)($timeIntervalTmp1[1]->format('Hi'));
        $timeIL2 = (int)($timeIntervalTmp2[0]->format('Hi'));
        $timeIR2 = (int)($timeIntervalTmp2[1]->format('Hi'));

        switch ($this->_detectRange($timeIL1, $timeIR1, $timeIL2, $timeIR2)) {

            case self::RANGE_1_CENTER:
                return $timeInterval1;

            case self::RANGE_2_CENTER:
                return $timeInterval2;

            case self::RANGE_1_LEFT:
                return array(
                    $timeInterval2[0],
                    $timeInterval1[1],
                );

            case self::RANGE_2_LEFT:
                return array(
                    $timeInterval1[0],
                    $timeInterval2[1],
                );

            case self::RANGE_1_RIGHT:
                return array(
                    $timeInterval1[0],
                    $timeInterval2[1],
                );

            case self::RANGE_2_RIGHT:
                return array(
                    $timeInterval2[0],
                    $timeInterval1[1],
                );
        }
    }

    /**
     * detect range for math common range
     * @param $timeIL1
     * @param $timeIR1
     * @param $timeIL2
     * @param $timeIR2
     * @return int
     * @throws Exception
     */
    protected function _detectRange($timeIL1, $timeIR1, $timeIL2, $timeIR2)
    {
        if ($timeIL1 < $timeIL2 && $timeIR2 < $timeIR1) {
            return self::RANGE_2_CENTER;

        } elseif ($timeIL1 <= $timeIL2 && $timeIR1 < $timeIL2 && $timeIR2 < $timeIR1) {
            return self::RANGE_1_LEFT;

        } elseif ($timeIL2 < $timeIL1 && $timeIL1 <= $timeIR2 && $timeIR2 < $timeIR1) {
            return self::RANGE_1_RIGHT;

        } elseif ($timeIL2 < $timeIL1 && $timeIR1 < $timeIR2) {
            return self::RANGE_1_CENTER;

        } elseif ($timeIL2 <= $timeIL1 && $timeIR2 < $timeIL1 && $timeIR1 < $timeIR2) {
            return self::RANGE_2_LEFT;

        } elseif ($timeIL1 < $timeIL2 && $timeIL2 <= $timeIR1 && $timeIR1 < $timeIR2) {
            return self::RANGE_2_RIGHT;

        } else {
            throw new Exception('This time not have common range');
        }
    }
}
<?php

require_once('classes/TimeCompare.php');

class Index
{
    private $_arguments = array();

    public function __construct($arguments)
    {
        $this->_arguments = $arguments;
    }

    /**
     * run this script
     */
    public function run()
    {
        try {
            $format = $this->_getArg('--format', 24);
            $timeInterval1 = $this->_getArg('--interval1', null, true);
            $timeInterval2 = $this->_getArg('--interval2', null, true);

            $timeInterval1 = explode('-', $timeInterval1);
            $timeInterval2 = explode('-', $timeInterval2);

            $this->_validationIntervals($timeInterval1, $timeInterval2);

            $timeCompare = new TimeCompare();
            $result = $timeCompare->compareTime($timeInterval1, $timeInterval2, $format);

            $result = array_unique($result);

            echo 'Common range: ' . implode(' - ', $result) . PHP_EOL;

        } catch (Exception $error) {
            echo $error->getMessage() . PHP_EOL;
            $this->_help();
        }
    }

    private function _validationIntervals($interval1, $interval2)
    {
        if (!isset($interval1[1])) {
            throw new Exception('--interval1 have wrong format');
        }

        if (!isset($interval2[0])) {
            throw new Exception('--interval2 have wrong format');
        }
    }

    /**
     * get arguments from command line
     * @param $key
     * @param null $default
     * @param bool $required
     * @return null
     */
    private function _getArg($key, $default = null, $required = false)
    {
        foreach ($this->_arguments as $_argument) {
            if (strstr($_argument, $key) !== false) {
                $value = explode('=', $_argument, 2);
                return $value[1];
            } elseif ($default !== null) {
                return $default;
            }
        }

        if ($required) {
            $this->_help();
        }
    }

    /**
     * output help
     */
    private function _help()
    {
        $help = <<<HELP

run script:
 php index.php --interval1=10.00 --interval2=9:00-12:00
 
 options: 
   --interval1 = this is time interval for compare
   --interval2 = this is other interval for compare

HELP;
        echo $help;
        exit(128);
    }
}

(new Index($argv))->run();

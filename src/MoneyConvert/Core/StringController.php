<?php
/**
 * Created by PhpStorm.
 * User: renan
 * Date: 02/06/16
 * Time: 17:43
 */

namespace MoneyConvert\Core;

/**
 * Class StringController
 * @package MoneyConvert\Core
 */
abstract class StringController extends AbstractConverter
{
    public $specialCharacter;

    public $digitON;
    public $digitTE;
    public $digitTW;
    public $digitTH;
    public $stepsPoint;
    public $stepsPlural;
    public $stepsSingular;
    public $etc;
    public $divisor;
    public $realType;
    public $decimalsType;

    public function getOne($d1 = null, $d2 = null, $d3 = null)
    {
        if (($d3 != 0 || $d2 != 0) && $d1 == 0) {

            return null;
        }

        return $groupArray[] = $this->digitON[$d1];
    }

    public function getTen($d1 = null, $d2 = null)
    {
        if ($d2 == 0) {

            return null;
        }

        if ($d2 == 1 && $d1 != 0) {

            return $groupArray[] = $this->digitTE[$d1];
        }

        return $groupArray[] = $this->digitTW[$d2];
    }
    
    public function getHundred($d3 = null)
    {
        if ($d3 == 0) {

            return null;
        }

        return $groupArray[] = $this->digitTH[$d3];
    }

    /**
     * Convert number in text.
     *
     * @param int $number
     * @param int $decimalPoint
     * @return string
     */
    public function numberToString($number, $decimalPoint = 0)
    {
        $formatted = explode(
            '.',
            number_format(
                $number,
                null,
                ".",
                ","
            )
        );

        $groups = explode(',', $formatted[0]);

        $parts = array();
        foreach ($groups as $step => $group) {

            $groupWords = $this->groupToWords($group);

            if ($groupWords) {
                $part = $this->getComplement($groupWords);

                $part .= ' '.$this->getSuffix($groups, $step);

                $parts[] = $part;
            }
        }

        return implode(' ', $parts);
    }

    /**
     * Get the text of each number
     *
     * @param array $group
     * @return boolean|array
     */
    public function groupToWords($group)
    {
        $group = sprintf('%03d', $group);

        $d1 = (int) $group{2};
        $d2 = (int) $group{1};
        $d3 = (int) $group{0};

        $groupArray[] = $this->getHundred($d3);
        $groupArray[] = $this->getTen($d1, $d2);
        $groupArray[] = $this->getOne($d1, $d2, $d3);

        if (!count($groupArray)) {
            return false;
        }

        return $groupArray;
    }

    /**
     * Returns the correct sufix to the money value
     *
     * @example 54 = "reais"
     * @example 1 = "real"
     * @param $groups
     * @param $step
     * @return mixed
     */
    public function getSuffix($groups, $step)
    {
        $stepNum = count($groups) - 1;
        if($stepNum - $step == 0) {
            return null;
        }
        if (count($groups) >= 3 && $groups[0] == 1) {

            return $this->stepsSingular[$stepNum - $step] ? : null;
        } else {

            return $this->stepsPlural[$stepNum - $step] ? : null;
        }
    }

    public function getComplement($groupWords)
    {
        if (!empty($groupWords[1]) && !empty($groupWords[2])) {

            return $groupWords[0].' '.$groupWords[1].$this->etc['&'].$groupWords[2];
        }

        return implode(' ', $groupWords);
    }
}
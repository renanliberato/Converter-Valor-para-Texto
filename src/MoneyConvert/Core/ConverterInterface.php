<?php
/**
 * Created by PhpStorm.
 * User: renan
 * Date: 30/05/16
 * Time: 21:22
 */

namespace MoneyConvert\Core;

/**
 * Interface ConverterInterface
 * @package MoneyConvert\Core
 */
interface ConverterInterface
{
    /**
     * @param $group
     * @param int $groupPoint
     * @return mixed
     */
    public function groupToWords($group);

    /**
     * @param $number
     * @param int $decimalPoint
     * @return mixed
     */
    public function numberToString($number);
}
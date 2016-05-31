<?php
/**
 * Created by PhpStorm.
 * User: renan
 * Date: 30/05/16
 * Time: 21:22
 */

namespace MoneyConvert\i18n;

/**
 * Interface LanguageInterface
 * @package MoneyConvert\i18n
 */
interface LanguageInterface
{
    /**
     * @param $group
     * @param int $groupPoint
     * @return mixed
     */
    public function groupToWords($group, $groupPoint = 0);

    /**
     * @param $number
     * @param int $decimalPoint
     * @return mixed
     */
    public function numberToString($number, $decimalPoint = 0);
}
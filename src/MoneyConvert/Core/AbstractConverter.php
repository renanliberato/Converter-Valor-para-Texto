<?php
/**
 * Created by PhpStorm.
 * User: renan
 * Date: 30/05/16
 * Time: 21:17
 */

/**
 *
 */
namespace MoneyConvert\Core;

/**
 * Class AbstractConversor
 * @package MoneyConvert\Core
 */
abstract class AbstractConverter implements ConverterInterface
{
    abstract public function groupToWords($group);

    abstract public function numberToString($number);
}
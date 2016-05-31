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
namespace MoneyConvert\i18n;

/**
 * Class AbstractLanguage
 * @package MoneyConvert\i18n
 */
abstract class AbstractLanguage implements LanguageInterface
{
    /**
     * @var
     */
    public $specialCharacter;

    /**
     * @var
     */
    public $digitON;

    /**
     * @var
     */
    public $digitTE;

    /**
     * @var
     */
    public $digitTW;

    /**
     * @var
     */
    public $digitTH;

    /**
     * @var
     */
    public $stepsPoint;

    /**
     * @var
     */
    public $stepsPlural;

    /**
     * @var
     */
    public $stepsSingular;

    /**
     * @var
     */
    public $etc;

    /**
     * @var
     */
    public $divisor;

    /**
     * @var
     */
    public $realType;

    /**
     * @var
     */
    public $decimalsType;

    /**
     * @var
     */
    public $lang;

    /**
     * @var
     */
    public $decimalPoint;

    /**
     * @var
     */
    public $result;

    /**
     * @var
     */
    public $number;

    /**
     * @var
     */
    public $numberP;

    /**
     * @var \MoneyConvert\i18n\AbstractLanguage
     */
    public $langConvert;

    abstract public function groupToWords($group, $groupPoint = 0);

    abstract public function numberToString($number, $decimalPoint = 0);
}
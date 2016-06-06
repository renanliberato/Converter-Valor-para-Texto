<?php

namespace MoneyConvert\Core;

use Zend\Escaper\Escaper;

/**
 * @author Diego Brocanelli <contato@diegobrocanelli.com.br>
 */
class CoreController implements CoreControllerInterface
{
    /**
     * @var StringController
     */
    protected $stringController;

    /**
     * CoreController constructor.
     * @param $lang
     * @throws \Exception
     */
    public function __construct($lang)
    {
        $path = __DIR__.'/../i18n/'.$lang.'.php';

        try {
            if(!file_exists($path)){
                throw new \Exception("Class: {$lang} not fount.");
            }

            $namespace = "\\MoneyConvert\\i18n\\{$lang}";

            $this->stringController = new $namespace();

        } catch (\Exception $e) {

        }
    }

    /**
     * Convert numbers to words.
     *
     * @param float $number
     * @param int $decimalPoint
     * @return string
     */
    public function convert($number, $decimalPoint = 0)
    {
        try {

            $remove = $this->stringController->specialCharacter;
            foreach ($remove as $string) {
                $number = str_ireplace($string, '', $number);
            }

            if (substr_count($number, '.') > 1) {
                throw new \Exception('The number has more than one point.');
            }
            $numberArray = explode('.', $number);

            $rounds = null;
            if($numberArray[0] != 0 || !isset($numberArray[1])) {
                $rounds = $this->round($numberArray[0]);
            }

            $decimals = null;
            if (!empty($numberArray[1])) {
                $decimals = $this->decimals($numberArray[1]);
            }

            $and = null;
            if(!empty($rounds) && !empty($decimals)) {
                $and = $this->stringController->etc['and'];
            }
            $escaper = new Escaper('utf-8');
            
            return $escaper->escapeHtml($rounds . " {$and} " . $decimals);

        } catch (\Exception $e) {
                return $e->getMessage();
        }
    }

    /**
     * Treatment of values before the comma.
     *
     * @param int $number
     * @return string
     */
    private function round($number)
    {
        $rounds = $this->stringController->numberToString($number);

        //round
        if ($number == 1 || $number == 0) {
            $rounds .= ' '.$this->stringController->realType[0];
        } else {
            $rounds .= ' '.$this->stringController->realType[1];
        }

        return $rounds;
    }

    /**
     * Treatment decimals
     *
     * @param int $number
     * @return string
     */
    private function decimals($number)
    {
        $decimals = $this->stringController->numberToString($number);
        if ($number == 1 || $number == 0) {
            $decimals .= ' '.$this->stringController->decimalsType[0];
        } else {
            $decimals .= ' '.$this->stringController->decimalsType[1];
        }

        return $decimals;
    }
}

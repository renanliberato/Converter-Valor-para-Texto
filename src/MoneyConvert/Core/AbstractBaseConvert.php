<?php

namespace MoneyConvert\Core;

/**
 * @author Diego Brocanelli <contato@diegobrocanelli.com.br>
 */
class AbstractBaseConvert implements BaseConvertInterface
{
    protected $langConvert;

    /**
     * @param string $lang
     */
    public function __construct($lang)
    {
        $path = __DIR__.'/../i18n/'.$lang.'.php';

        if(!file_exists($path)){
            throw new \Exception("Class: {$lang} not fount.");
        }

        $nameSpace = "MoneyConvert\\i18n\\{$lang}";
        $langType  = new $nameSpace;


        $this->langConvert = $langType;
    }

    /**
     * Convert numbers to words.
     *
     * @param float $number
     * @param int $decimalPoint
     * @return string
     * @throws Exception
     */
    public function convert($number, $decimalPoint = 0)
    {
        if($number == 0){
            return 'Value informed is zero, please report value bigger than zero';
        }

        $langType = $this->langConvert;

        $remove = $langType->specialCharacter;

        foreach ($remove as $string) {
            $value = str_ireplace($string, '', $number);
        }

        if (substr_count($value, ',') > 1) {
            throw new Exception("The number has more than one comma.");
        }

        $values = explode('.', $value);

        $reais = $this->real($values);
        $cents = $this->cents($values);

        if(count($values) >= 2){
            $and = $langType->etc[$langType->lang]['&'];
        }

        return $reais." {$and} ".$cents;
    }

    /**
     * Treatment of values before the comma.
     *
     * @param type $values
     * @return string
     */
    private function real($values)
    {
        $langType = $this->langConvert;

        $reais = $this->numberToString($values[0]);

        //real
        if($values[0] == 1 && array_key_exists(0, $values)){

            $reais .= ' '.$langType->realType[0];

        }elseif(array_key_exists(0, $values)){

            $reais .= ' '.$langType->realType[1];

        }
        return $reais;
    }

    /**
     * Treatment cents
     *
     * @param type $values
     * @return string
     */
    private function cents($values)
    {
        $langType = $this->langConvert;

        $cents = $this->numberToString($values[1]);
        if($values[1] == 1 && array_key_exists(1, $values)){

            $cents .= ' '.$langType->centsType[0];

        }elseif(array_key_exists(1, $values)){

            $cents .= ' '.$langType->centsType[1];

        }


        return $cents;
    }


    /**
     * Convert number in text.
     *
     * @param type $number
     * @param type $decimalPoint
     * @return type
     */
    private function numberToString($number, $decimalPoint = 0)
    {
        $langType = $this->langConvert;

        list($formated, $point) = explode(
            '.',
            number_format(
                preg_replace("/[,]/", "", $number),
                $decimalPoint? : $langType->decimalPoint,
                ".",
                ","
            )
        );

        $langType->numberP = $formated . (empty($point) ? "" : "." . $point);

        $langType->number = $formated;

        $groups = explode(',', $formated);

        $stepNum = count($groups) - 1;

        $parts = array();
        foreach ($groups as $step => $group) {

            $groupWords = $this->langConvert->groupToWords($group);

            if ($groupWords) {

                $part = implode(' ' . $langType->etc[$langType->lang]['&'] . ' ', $groupWords);


                if(count($groups) >= 3 && $groups[0] == 1 ){
                    if (isset($langType->stepsSingular[$langType->lang][$stepNum - $step])) {
                        $part .= ' ' . $langType->stepsSingular[$langType->lang][$stepNum - $step];
                    }
                }else{
                    if (isset($langType->stepsPlural[$langType->lang][$stepNum - $step])) {
                        $part .= ' ' . $langType->stepsPlural[$langType->lang][$stepNum - $step];
                    }
                }

                $parts[] = $part;
            }
        }

        return ($langType->result = implode(' ' . $langType->etc[$langType->lang]['&'] . ' ', $parts));
    }

    
}

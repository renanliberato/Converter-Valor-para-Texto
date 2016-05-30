<?php

namespace MoneyConvert\i18n;

/**
 * Coin BRL
 *
 * @author Diego Brocanelli <contato@diegobrocanelli.com.br>
 */
class BRL 
{
    public $specialCharacter = array('r$', '$', '.', '(', ')', '#', ' ');


    public $digitON = array(
        "pt_BR" =>
            array('zero', 'um', 'dois', 'três', 'quatro', 'cinco', 'seis', 'sete', 'oito', 'nove'),
    );
    public $digitTE = array(
        "pt_BR" =>
            array(1 => 'onze', 'doze', 'treze', 'quatorze', 'quinze', 'dezesseis', 'dezessete', 'dezoito', 'dezenove'),
    );
    public $digitTW = array(
        "pt_BR" =>
            array(1 => 'dez', 'vinte', 'trinta', 'quarenta', 'cinquenta', 'sessenta', 'setenta', 'oitenta', 'noventa'),
    );
    public $digitTH = array(
        "pt_BR" =>
            array(1 => 'cento','cem', 'duzentos', 'trezentos', 'quatrocentos', 'quinhentos', 'seiscentos', 'setecentos', 'oitocentos', 'novecentos'),
    );
    public $stepsPoint = array(
        "pt_BR" =>
            array(
                1 => 'décimo',      // 10^1
                     'centésimo',   // 10^2
                     'milésimo'     // 10^3
            ),
    );
    public $stepsPlural = array(
        "pt_BR" =>
            array(
                1 => 'mil',          //	10^3
                     'milhões',      //	10^6
                     'bilhões',      //	10^9
                     'trilhões',     //	10^12
                     'quatrilhões',  //	10^15
                     'quintilhões',  //	10^18
                     'sextilhões',   //	10^21
                     'setilhões',    //	10^24
                     'octilhões',    //	10^27
                     'nonilhões',    //	10^30
                     'decilhões'     //	10^33
            )
    );
    public $stepsSingular = array(
        "pt_BR" =>
            array(
                1 => 'mil',        //	10^3
                     'milhão',     //	10^6
                     'bilhão',     //	10^9
                     'trilhão',    //	10^12
                     'quatrilhão', //	10^15
                     'quintilhão', //	10^18
                     'sextilhão',  //	10^21
                     'setilhão',   //	10^24
                     'octilhão',   //	10^27
                     'nonilhão',   //	10^30
                     'decilhão'    //	10^33
            )
    );
    public $etc = array(
        "pt_BR" =>
            array('&' => 'e', '.' => ''),
    );
    
    public $divisor = 'de';
    
    public $realType = array(
        'real',
        'reais'
    );
    public $centsType = array(
        'centavo',
        'centavos'
    );
    public $lang = "pt_BR"; // same name of the keys of the above arrays
    public $decimalPoint;
    public $result;
    public $number;
    public $numberP;

    /**
     * Get the text of each number
     *
     * @param type $group
     * @param type $groupPoint
     * @return boolean
     */
    public function groupToWords($group, $groupPoint = 0)
    {
        $group = sprintf('%03d', $group);

        $d1 = (int) $group{2};
        $d2 = (int) $group{1};
        $d3 = (int) $group{0};

        $groupArray = array();
        if (!$groupPoint) {
            if ($d3 != 0){
                if($d3 == 1) {
                    //if the word needed is 'cem'
                    if($d1 == 0 && $d2 == 0){
                        $groupArray[] = $this->digitTH[$this->lang][2];
                        //if the word needed is 'cento'
                    }else {
                        $groupArray[] = $this->digitTH[$this->lang][$d3];
                    }
                } else {
                    $groupArray[] = $this->digitTH[$this->lang][$d3 + 1];
                }
            }

            if ($d2 == 1 && $d1 != 0){ // 11-...-19
                $groupArray[] = $this->digitTE[$this->lang][$d1];

            }else if ($d2 != 0 && $d1 == 0){ // 1-...-9+0

                $groupArray[] = $this->digitTW[$this->lang][$d2];

            }else if ($d2 == 0 && $d1 == 0) {} // 00
            else if ($d2 == 0 && $d1 != 0) { // 1-...-9

                $groupArray[] = $this->digitON[$this->lang][$d1];

            } else {

                $groupArray[] = $this->digitTW[$this->lang][$d2];
                $groupArray[] = $this->digitON[$this->lang][$d1];

            }
        } elseif ($groupPoint) {
            if ($d3 != 0){
                $groupArray[] = $this->digitTH[$this->lang][$d3];
            }

            if ($d2 == 1 && $d1 != 0){ // 11-19

                $groupArray[] = $this->digitTE[$this->lang][$d1];

            }else if ($d2 != 0 && $d1 == 0){ // 10-20-...-90

                $groupArray[] = $this->digitTW[$this->lang][$d2];

            }else if ($d2 == 0 && $d1 == 0) {} // 00
            else if ($d2 == 0 && $d1 != 0) // 1-9

                $groupArray[] = $this->digitON[$this->lang][$d1];

            else { // Others

                $groupArray[] = $this->digitTW[$this->lang][$d2];
                $groupArray[] = $this->digitON[$this->lang][$d1];

            }
        }

        if (!count($groupArray)){
            return false;
        }

        return $groupArray;
    }

}

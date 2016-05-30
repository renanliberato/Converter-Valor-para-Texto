<?php

namespace MoneyConvert\i18n;

/**
 * Coin EN
 *
 * @author Diego Brocanelli <contato@diegobrocanelli.com.br>
 */
class EN 
{
    public $specialCharacter = array('r$', '$', '.', '(', ')', '#', ' ');

    public $digitON = array(
        "en"=>
  	    array('zero','one','two','three','four','five','six','seven','eight','nine'),
    );
    public $digitTE = array(
        "en"=>
	    array(1 =>'eleven','twelve','thirteen','fourteen','fifteen','sixteen','seventeen','eighteen','nineteen'),
    );
    public $digitTW = array(
        "en"=>
	     array(1 =>'ten','twenty','thirty','forty','fifty','sixty','seventy','eighty','ninety'),
    );
    public $digitTH = array(
        "en"=>
 	     array(1 =>'one hundred','two hundred','three hundred','four hundred','five hundred','six hundred','seven hundred','eighthundred','nine hundred'),
    );
    public $stepsPoint = array(
        "en" =>
        array(
            1 =>'tenth',     // 10^1
		        'hundredth', //10^2
		        'thousandth' // 10^3
        ),
    );
    public $stepsPlural = array(
        "en" =>
        array(
            1 =>'thousand',	    //	10^3
		        'million',	    //	10^6
		        'billion',	    //	10^9
        		'trillion',	    //	10^12
        		'quadrillion',	//	10^15
        		'quintillion',	//	10^18
        		'sextillion',	//	10^21
        		'septillion',	//	10^24
        		'octillion',	//	10^27
        		'nonillion',	//	10^30
        		'decillion'	    //	10^33
        )
    );
    public $stepsSingular = array(
        "en" =>
        array(
            1 =>'thousand',	    //	10^3
        		'millions',	    //	10^6
        		'billions',	    //	10^9
        		'trillions',	//	10^12
        		'quadrillions',	//	10^15
        		'quintillions',	//	10^18
        		'sextillions',	//	10^21
        		'septillions',	//	10^24
        		'octillions',	//	10^27
        		'nonillions',	//	10^30
        		'decillions'	//	10^33
        )
    );
    public $etc = array(
        "en" =>
        array('&' => 'and', '.' => ''),
    );
    
    public $divisor = 'and';
    
    public $realType = array(
        'dollar',
        'dollars'
    );
    public $centsType = array(
        'cent',
        'cents'
    );
    public $lang = "en"; // same name of the keys of the above arrays
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

            if ($d3 != 0) {
                $groupArray[] = $this->digitTH[$this->lang][$d3];
            }

            if ($d2 == 1 && $d1 != 0) { // 11-...-19
                $groupArray[] = $this->digitTE[$this->lang][$d1];

            } else if ($d2 != 0 && $d1 == 0) { // 1-...-9+0

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

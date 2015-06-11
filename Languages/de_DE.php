<?php

class de_DE extends Language {

    public function __construct(){
        parent::__construct("German", "de_DE");
    }

    public function sayNumber($number){
        if(is_numeric($number)){
            if(in_array($number, $this->getRequired())){
                return [$number];
            } else {
                $numberArray = str_split($number);
                $numberSounds = [];
                $length = strlen($number);

                $one = $numberArray[$length - 1];
                $tens = (isset($numberArray[$length - 2]) ? $numberArray[$length - 2] : 0);
                $hundred = (isset($numberArray[$length - 3]) ? $numberArray[$length - 3] : 0);
                $thousands = (isset($numberArray[$length - 4]) ? $numberArray[$length - 4] : 0);

                if($thousands > 0){
                    $numberSounds = array_merge($numberSounds, $this->getThousand($thousands));
                }

                if($hundred > 0){
                    $numberSounds = array_merge($numberSounds, $this->getHundreds($hundred));
                }

                if($tens > 0){
                    $numberSounds = array_merge($numberSounds, $this->getTens($tens, $one));
                } else {
                    $numberSounds = array_merge($numberSounds, [$one]);
                }

                return $numberSounds;
            }
        }
        return false;
    }

    public function getThousand($thousands){
        return [$thousands, "1000"];
    }

    public function getHundreds($hundreds){
        return [$hundreds, "100"];
    }

    public function getTens($tens, $one){
        return [$one, "und", $tens."0"];
    }

    public function getRequired(){
        return [0, 1, 2, 3, 4, 5, 6, 7, 8,
                9, 10, 11, 12, 13, 14, 15,
                16, 17, 18, 19, 20, 30, 40,
                50, 60, 70, 80, 90, 100, 1000,
                "und"];
    }

} 
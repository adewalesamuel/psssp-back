<?php

namespace App;

class Utils {
    public static function generateRandAlnum(int $length=6): string {
        $letterList = str_split('AZERTYUIOPMLKJHGFDSQWXCVBN');
        $numberList = str_split('1234567890');
        $randomAlnum = '';

        for ($i=0; $i < floor($length/2); $i++) {
            $lI = rand(0, count($letterList) - 1);
            $nI = rand(0, count($numberList) - 1);
            $randomAlnum .= $numberList[$nI] . $letterList[$lI];
        }

        return $randomAlnum;
    }
}

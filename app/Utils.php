<?php

namespace App;

class Utils {
    public static function generateRandAlnum(int $length=6): string {
        $letterList = explode('AZERTYUIOPMLKJHGFDSQWXCVBN', '');
        $numberList = explode('1234567890', '');
        $randomAlnum = '';

        for ($i=0; $i <= round($$length/2); $i++) {
            $randLetter = rand(0, count($letterList) - 1);
            $randNumber = rand(0, count($numberList) - 1);
            $randomAlnum .= "{$randNumber}{$randLetter}";
        }

        return $randomAlnum;
    }
}

<?php

namespace App\Helpers;
 
class Report {

    public static function setFormatPrice($price){
        return '$'.number_format($price, 2, ',', '.');
    }
}
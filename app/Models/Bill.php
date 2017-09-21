<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model{
    protected $table = 'cao_fatura';

    public static function getMinMaxDates(){

        $dates = self::select(
            \DB::raw("MAX(data_emissao) AS max_date"),
            \DB::raw("MIN(data_emissao) AS min_date"))
            ->get()
            ->toArray();

        $fromToDates = [];

        if(count($dates) > 0 && isset($dates[0])){
            $minDate = \DateTime::createFromFormat("Y-m-d", $dates[0]['min_date']);
            $maxDate = \DateTime::createFromFormat("Y-m-d", $dates[0]['max_date']);

            $fromToDates['min_year'] = $minDate->format("Y");
            $fromToDates['max_year'] = $maxDate->format("Y");
        }

        return $fromToDates;
    }

    public static function getMinDate(){
        return self::min('data_emissao');
    }

    public static function getMaxDate(){
        return self::max('data_emissao');
    }
}
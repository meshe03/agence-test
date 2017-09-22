<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permission;
use App\Models\Bill;

class UsersController extends Controller{

    public function index(){

        $months = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
        ];
        
        $users = User::join('permissao_sistema', 'cao_usuario.co_usuario', '=', 'permissao_sistema.co_usuario')
                    ->where([
                        ['permissao_sistema.in_ativo', 'S'],
                        ['permissao_sistema.co_sistema', 1]
                    ])
                    ->whereIn('permissao_sistema.co_tipo_usuario', [0,1,2])
                    ->get();

        $yearsRange = $this->getDatesRange(Bill::getMinMaxYears());

        return view('users.index', compact('users', 'yearsRange', 'months'));
    }

    public function postPerformance(Request $request){

        $performances = [];
 
        foreach($request['sellers'] as $seller){
            $periods['Enero 2007'] = [
                'liquid_profit' => 1222,
                'cost' => 1333,
                'commission' => '10%',
                'profit' => 1444
            ];

            $periods['Febrero 2007'] = [
                'liquid_profit' => 1222,
                'cost' => 1333,
                'commission' => '10%',
                'profit' => 1444
            ];

            $performances[$seller] = [
                'name' => $seller,
                'periods' => $periods,
                'total' => [
                    'liquid_profit' => 1222,
                    'cost' => 1333,
                    'commission' => '10%',
                    'profit' => 1444
                ]
            ];
        }

        return view('users.performance', compact('performances'));
    }


    public function getDatesRange($minMaxYears){
        $yearsRange = [];

        for($i = $minMaxYears['min_year']; $i <= $minMaxYears['max_year']; $i++){
            $yearsRange[] = $i;
        }

        return $yearsRange;
    }

}

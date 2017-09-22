<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permission;
use App\Models\Bill;
use DB;

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
        
        $fromDate = date('Y-m-d', strtotime($request['from-year'].'-'.$request['from-month'].'-01'));
        $toDate =  date('Y-m-d', strtotime($request['to-year'].'-'.$request['to-month'].'-01'));

        $bills = User::join('cao_os', 'cao_usuario.co_usuario', '=', 'cao_os.co_usuario')
                    ->leftJoin('cao_fatura', 'cao_fatura.co_os', '=', 'cao_os.co_os')
                    ->leftJoin('cao_salario', 'cao_salario.co_usuario', '=', 'cao_usuario.co_usuario')
                    ->select('cao_usuario.co_usuario', 'cao_usuario.no_usuario', 'cao_salario.brut_salario','cao_fatura.*')
                    ->where('cao_fatura.data_emissao', '<=', $toDate)
                    ->where('cao_fatura.data_emissao', '>=', $fromDate)
                    ->whereIn('cao_usuario.co_usuario', $request['sellers'])
                    ->orderBy('cao_fatura.data_emissao', 'ASC')
                    ->get();


        
        foreach($bills as $bill){

            $period =  $this->getMonth($bill->data_emissao).' '.$this->getYear($bill->data_emissao);
            
            $name = $bill->no_usuario;
            $liquidProfit = $bill->valor - $bill->total_imp_inc;
            $cost = $bill->brut_salario;
            $commission = ($bill->valor - ($bill->valor * $bill->total_imp_inc)) * $bill->comissao_cn;
            $profit =  $liquidProfit - ($cost + $commission);


            print_r($period.'<br>');
            print_r($liquidProfit.'<br>');
            print_r($cost.'<br>');
            print_r($commission.'<br>');
            print_r($profit.'<br>');
            print_r('------ <br>');

            if(isset($performances[$bill->co_usuario])){
                $performances[$bill->co_usuario]['total'] = [
                    'liquid_profit' => $performances[$bill->co_usuario]['total']['liquid_profit'] + $liquidProfit,
                    'cost' => $cost,
                    'commission' => $performances[$bill->co_usuario]['total']['commission'] + $commission,
                    'profit' => $performances[$bill->co_usuario]['total']['profit'] + $profit
                ];
                
            }else{
                $performances[$bill->co_usuario]['name'] = $name;
                
                $performances[$bill->co_usuario]['total'] = [
                    'liquid_profit' => $liquidProfit,
                    'cost' => $cost,
                    'commission' => $commission,
                    'profit' => $profit
                ];
            }


            if(isset($performances[$bill->co_usuario]['periods'][$period])){
                $performances[$bill->co_usuario]['periods'][$period] = [
                    'liquid_profit' => $performances[$bill->co_usuario]['periods'][$period]['liquid_profit'] + $liquidProfit,
                    'cost' => $cost,
                    'commission' => $performances[$bill->co_usuario]['periods'][$period]['commission'] + $commission,
                    'profit' => $performances[$bill->co_usuario]['periods'][$period]['profit'] + $profit
                ];

            }else{
                $performances[$bill->co_usuario]['periods'][$period] = [
                    'liquid_profit' => $liquidProfit,
                    'cost' => $cost,
                    'commission' => $commission,
                    'profit' => $profit
                ];
            }
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

    public function getMonth($dateValue){
        $month=date("m", strtotime($dateValue));

        switch ($month) {
            case '01':
                $month = "Enero";
                break;

            case '02':
                $month = "Febrero";
                break;

            case '03':
                $month = "Marzo";
                break;

            case '04':
                $month = "Abril";
                break;

            case '05':
                $month = "Mayo";
                break;

            case '06':
                $month = "Junio";
                break;

            case '07':
                $month = "Julio";
                break;
            
            case '08':
                $month = "Agosto";
                break;

            case '09':
                $month = "Septiembre";
                break;

            case '10':
                $month = "Octubre";
                break;

            case '11':
                $month = "Noviembre";
                break;

            case '12':
                $month = "Diciembre";
                break;
        }

        return $month;

    }

    public function getYear($dateValue){
        return date("Y", strtotime($dateValue));
        
    }

}

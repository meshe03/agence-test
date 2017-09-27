<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permission;
use App\Models\Bill;

class UsersController extends Controller{

    //Funcion pantalla  principal -------------------------------
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

    //Calculo del desempeño de consultores ----------------------
    public function postPerformance(Request $request){

        $performances = [];

        //Si hay consultores se obtienen las facturas asociadas a los OS
        if(count($request['sellers']) > 0){

            $bills = User::join('cao_os', 'cao_usuario.co_usuario', '=', 'cao_os.co_usuario')
                    ->leftJoin('cao_fatura', 'cao_fatura.co_os', '=', 'cao_os.co_os')
                    ->leftJoin('cao_salario', 'cao_salario.co_usuario', '=', 'cao_usuario.co_usuario')
                    ->select('cao_usuario.co_usuario', 'cao_usuario.no_usuario', 'cao_salario.brut_salario','cao_fatura.*')
                    ->whereYear('cao_fatura.data_emissao', '>=', $request['from-year'])
                    ->whereMonth('cao_fatura.data_emissao', '>=', $request['from-month'])
                    ->whereYear('cao_fatura.data_emissao', '<=', $request['to-year'])
                    ->whereMonth('cao_fatura.data_emissao', '<=', $request['to-month'])
                    ->whereIn('cao_usuario.co_usuario', $request['sellers'])
                    ->orderBy('cao_fatura.data_emissao', 'ASC')
                    ->get();

            //dd($bills);

            foreach($bills as $bill){

                $period =  $this->getMonth($bill->data_emissao).' '.$this->getYear($bill->data_emissao); //Periodo (Mes, año)
                $tax = $bill->total_imp_inc/100; //obtencion de porcentaje
                $comissionCN = $bill->comissao_cn/100; //obtencion de porcentaje

                $liquidProfit = $bill->valor - $tax; //ganancia liquida
                $cost = $bill->brut_salario; //salario bruto
                $commission = ($bill->valor - ($bill->valor * $tax)) * $comissionCN; //comisión
                $profit =  $liquidProfit - ($cost + $commission); //ganancia

                //Nombre consultor
                if(!isset($performances[$bill->co_usuario]['name'])){
                    $performances[$bill->co_usuario]['name'] = $bill->no_usuario;
                }


                //Periodos -----------------------------------------------------------
                $currentPeriod = &$performances[$bill->co_usuario]['periods'][$period];
                
                $currentPeriod = [
                    'liquid_profit' => $currentPeriod['liquid_profit'] + $liquidProfit,
                    'cost' => $cost,
                    'commission' => $currentPeriod['commission'] + $commission,
                    'profit' => $currentPeriod['profit'] + $profit
                ];

                //NUEVO PROFIT
                /*$profit = $currentPeriod['liquid_profit'] - ($cost + $currentPeriod['commission']);
                $currentPeriod ['profit'] = $profit;*/

                //Totales ------------------------------------------------------------
                $currentTotal = &$performances[$bill->co_usuario]['total'];
                
                $currentTotal = [
                    'liquid_profit' => $currentTotal['liquid_profit'] + $liquidProfit,
                    'cost' => $cost,
                    'commission' => $currentTotal['commission'] + $commission,
                    'profit' => $currentTotal['profit'] + $profit
                ];

            }
        }

        return view('users.performance', compact('performances'));
    }

    //Rango de fechas para mostrar en selects -------------------
    public function getDatesRange($minMaxYears){
        $yearsRange = [];

        for($i = $minMaxYears['min_year']; $i <= $minMaxYears['max_year']; $i++){
            $yearsRange[] = $i;
        }

        return $yearsRange;
    }

    //Obtiene mes en español ------------------------------------
    public function getMonth($dateValue){
        $month = date("m", strtotime($dateValue));

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

    //Obtiene año -----------------------------------------------
    public function getYear($dateValue){
        return date("Y", strtotime($dateValue));   
    }

}

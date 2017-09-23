<?php /*$totalProfit = 0;*/ ?>

@foreach($performances as $performance)
    <div class="col-xs-12">
        <table class="table table-bordered">
            <thead>
                <tr >
                    <th>{{ $performance['name'] }}</th>
                </tr>
            </thead>
            
            <tbody>
                <tr class="active">
                    <th>Periodo</th>
                    <th>Ganancia líquida</th>
                    <th>Costo fijo</th>
                    <th>Comisión</th>
                    <th>Beneficio</th>
                </tr>

                @foreach($performance['periods'] as $key => $period)
                    <tr>
                        <td>{{ $key }}</td>
                        <td>{{ $period['liquid_profit'] }}</td>
                        <td>{{ $period['cost'] }}</td>
                        <td>{{ $period['commission'] }}</td>
                        <td>{{ $period['profit'] }}</td>
                    </tr>
                    <?php /*$totalProfit += $period['profit']*/ ?>
                @endforeach

                <tr class="active">
                    <td>Saldo</td>
                    @foreach($performance['total'] as $totalData)
                        <td>{{ $totalData }}</td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
@endforeach

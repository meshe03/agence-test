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
                        <td>{{ Report::setFormatPrice($period['liquid_profit']) }}</td>
                        <td>{{ Report::setFormatPrice($period['cost']) }}</td>
                        <td>{{ Report::setFormatPrice($period['commission']) }}</td>
                        <td>{{ Report::setFormatPrice($period['profit']) }}</td>
                    </tr>
                @endforeach

                <tr class="active">
                    <td>Saldo</td>
                    @foreach($performance['total'] as $totalData)
                        <td>{{ Report::setFormatPrice($totalData) }}</td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
@endforeach

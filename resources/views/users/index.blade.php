@extends('layouts.main')

@section('content')

<div class="page-header">

    <div class="row">
        <div class="title-container col-xs-12">
            <h1>Reporte - Desempeño consultores</h1>
        </div>
    </div>

    <div class="form-container row">
        <div class="col-xs-3">
            <h3>Periodo</h3>
        </div>

        <div class="col-xs-5">
            <h3>Consultores</h3>
        </div>

        <div class="col-xs-offset-1 col-xs-2">
            <h3>Acciones</h3>
        </div>

    </div>


    <div id="sellers-content" class="form-container row">
        <div class="col-xs-3">
            <div class="row">
                <div class="col-xs-12">
                    Desde
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <select id="from-month" class="form-control">
                        <option>Enero</option>
                        <option>Febrero</option>
                        <option>Marzo</option>
                        <option>Abril</option>
                        <option>Mayo</option>
                        <option>Junio</option>
                        <option>Julio</option>
                        <option>Agosto</option>
                        <option>Septiembre</option>
                        <option>Octubre</option>
                        <option>Noviembre</option>
                        <option>Diciembre</option>
                    </select>
                </div>

                <div class="col-lg-6">
                    <select id="from-year" class="form-control">
                        @foreach($datesRange as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-container row">
                <div class="col-xs-12">
                    Hasta
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <select id="t0-month" class="form-control">
                        <option>Enero</option>
                        <option>Febrero</option>
                        <option>Marzo</option>
                        <option>Abril</option>
                        <option>Mayo</option>
                        <option>Junio</option>
                        <option>Julio</option>
                        <option>Agosto</option>
                        <option>Septiembre</option>
                        <option>Octubre</option>
                        <option>Noviembre</option>
                        <option>Diciembre</option>
                    </select>
                </div>

                <div class="col-lg-6">
                    <select id="to-year" class="form-control">
                        @foreach($datesRange as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>


        <div class="col-xs-5">
            <div class="well bs-content">
                @foreach($users as $user)
                    <div class="row">
                        <div class="col-xs-12">
                            <label>
                                <input type="checkbox"> {{ $user->no_usuario }}
                            </label>
                        </div>
                    </div> 
                @endforeach

            </div>
        </div>

        <div class="col-xs-offset-1 col-xs-2">
            <div class="row">
                <a href="#" class="action-button btn btn-primary btn-block">Informe</a>
            </div>
            <!--<div class="row">
                <a href="#" class="action-button btn btn-primary btn-block">Gráfico</a>
            </div>
            <div class="row">
                <a href="#" class="action-button btn btn-primary btn-block">Pizza</a>
            </div>-->
        </div>
    </div>

    <hr>

    <div id="seller-performance" class="form-container row">
            <div class="col-xs-12">
                <table class="table table-bordered">
                    <thead>
                        <tr >
                            <th>Ana Mora</th>
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
                        <tr>
                            <td>Column content</td>
                            <td>Column content</td>
                            <td>Column content</td>
                            <td>Column content</td>
                            <td>Column content</td>
                        </tr>
                        <tr>
                            <td>Column content</td>
                            <td>Column content</td>
                            <td>Column content</td>
                            <td>Column content</td>
                            <td>Column content</td>
                        </tr>
                        <tr class="active">
                            <td>Saldo</td>
                            <td>Column content</td>
                            <td>Column content</td>
                            <td>Column content</td>
                            <td>Column content</td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </div>
              
</div>


@endsection
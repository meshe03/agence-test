@extends('layouts.main')

@section('content')

<div class="page-header">

    <form id="form-sellers-performance" action="/users/performance" method="post">

        {{ csrf_field() }}

        <div class="row">
            <div class="title-container col-xs-12">
                <h1>Reporte - Desempeño consultores</h1>
            </div>
        </div>
    
        <div class="hidden-xs hidden-sm form-container row">
            <div class="col-md-4">
                <h3>Periodo</h3>
            </div>
    
            <div class="col-md-5">
                <h3>Consultores</h3>
            </div>
    
            <div class="col-md-offset-1 col-md-2">
                <h3>Acciones</h3>
            </div>
        </div>
    
        <div id="sellers-content" class="form-container row">
    
            <!-- PERIODO -->
            <div class="period-container col-sm-12 col-md-4">
                <div class="row">
                    <div class="col-xs-12">
                        Desde
                    </div>
                </div>
    
                <div class="row">
                    <div class="col-xs-6">
                        <select name="from-month" class="form-control">
                            @foreach($months as $key => $month)
                                <option value="{{ $key }}">{{ $month }}</option>
                            @endforeach
                        </select>
                    </div>
    
                    <div class="col-xs-6">
                        <select name="from-year" class="form-control">
                            @foreach($yearsRange as $year)
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
                    <div class="col-xs-6">
                        <select name="to-month" class="form-control">
                            @foreach($months as $key => $month)
                                <option value="{{ $key }}">{{ $month }}</option>
                            @endforeach
                        </select>
                    </div>
    
                    <div class="col-xs-6">
                        <select name="to-year" class="form-control">
                            @foreach($yearsRange as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
    
            <!-- CONSULTORES -->
    
            <div class="col-sm-12 col-md-5">
                <div class="well bs-content">
                    @foreach($users as $user)
                        <div class="row">
                            <div class="col-xs-12">
                                <label>
                                    <input name="sellers[]" type="checkbox" value="{{ $user->co_usuario }}"> {{ $user->no_usuario }}
                                </label>
                            </div>
                        </div> 
                    @endforeach
    
                </div>
            </div>
    
            <!-- ACCIONES -->
    
            <div class="col-sm-12 col-md-offset-1 col-md-2">
                <input type="submit" id="send-form" class="action-button btn btn-primary btn-block" value="Informe" />
            </div>
        </div>
    </form>

    <hr>

    <!-- CONTENIDO DESEMPEÑO -->

    <div id="mini-loader" class="row text-center" style="display:none; margin-top: 10px;">
        <img src="/images/loader.gif" style="width: 30px; height: 30px;"/>
    </div>

    <div id="seller-performance" class="form-container row">
            
    </div>
              
</div>

@endsection

@push('scripts')
<script>

$(function () {

    $("#form-sellers-performance").submit(function(e) {
        e.preventDefault();

        $('#mini-loader').show();
        $("#seller-performance").empty();

        var form = $(this);
        
        $.ajax({
            data: form.serialize(),
            cache: false,
            url: form.attr('action'),
            type: form.attr('method'),
            success: function (response) {
                $('#mini-loader').hide();
                $("#seller-performance").html(response);
            }
        });

    });
});

</script>
@endpush
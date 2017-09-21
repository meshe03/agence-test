<!DOCTYPE html>
<html>
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Prueba Agence</title>

        <link rel="stylesheet" href="/themes/bootstrap/css/flat_theme.css">
        <link rel="stylesheet" href="/themes/styles.css">
    </head>

    <body>
        <div class="navbar navbar-default navbar-fixed-top">
            <div class="container">

                <div class="navbar-header">
                <a href="http://www.agence.com.br/es/" class="navbar-brand" target="_blank">Agence</a>
                </div>

                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">Mercedes Rodríguez <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="https://github.com/meshe03" target="_blank">Github</a></li>
                                <li><a href="https://www.linkedin.com/in/mercedes-rodr%C3%ADguez-1223a557/" target="_blank">LinkedIn</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container">
            @yield('content')
        </div>

        <!-- scripts -->

        <script src="/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="/themes/bootstrap/js/bootstrap.js"></script>

    </body>

</html>
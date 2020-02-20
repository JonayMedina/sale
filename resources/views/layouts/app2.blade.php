<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema Ventas Laravel Vue Js">
    <meta name="author" content="jonaymedina.com.ve">
    <meta name="keyword" content="Sistema ventas Laravel Vue Js, Sistema compras Laravel Vue Js">
    <link rel="shortcut icon" href="img/jm.png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistema Ventas - Jonay Medina</title>
    <!-- Icons -->
    
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/template.css') }}" rel="stylesheet">
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <div id="app">
        <header class="app-header navbar">
            <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
              <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
              <span class="navbar-toggler-icon"></span>
            </button>
            
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item d-md-down-none">
                    <a class="nav-link" href="#" data-toggle="dropdown">
                        <i class="icon-bell"></i>
                        <span class="badge badge-pill badge-danger">5</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-header text-center">
                            <strong>Notificaciones</strong>
                        </div>
                        <a class="dropdown-item" href="#">
                            <i class="fa fa-envelope-o"></i> Ingresos
                            <span class="badge badge-success">3</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fa fa-tasks"></i> Ventas
                            <span class="badge badge-danger">2</span>
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <img src="img/avatars/6.png" class="img-avatar" alt="">
                        <span class="d-md-down-none">{{ Auth::user()->user }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-header text-center">
                            <strong>Cuenta</strong>
                        </div>
                        
                        <a class="dropdown-item" href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit(); "><i class="fa fa-lock"></i> Cerrar sesión</a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            @csrf
                            
                        </form>
                    </div>
                </li>
            </ul>
        </header>

        <div class="app-body">
            @if (Auth::check())
                @if (Auth::user()->role_id == 1)
                    @include('layouts.adminsidebar')
                @elseif (Auth::user()->role_id == 2)
                    @include('layouts.sellersidebar')
                @elseif (Auth::user()->role_id == 3)
                    @include('layouts.storersidebar')
                @endif
            @endif
            
            <!-- Contenido Principal -->
           @yield('content')
            <!-- /Fin del contenido principal -->
        </div>

    </div> <!-- /div id="app--> 
    

    <footer class="app-footer">

        <span><img src="img/jm.png" width="30px" height="30px">&nbsp;&nbsp;Jonay Medina</a> &copy; 2019</span>
        <span class="ml-auto">Desarrollado por <a href="http://www.jonaymedina.com.ve/">JonayMedina.com.ve</a>&nbsp;&nbsp;<img src="img/jm.png" width="30px" height="20px"></span>

    </footer>

    <!-- Bootstrap and necessary plugins -->
    
    
    
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/template.js') }}" defer></script>
    <script src="{{ asset('js/Chart.min.js') }}" defer></script>
</body>

</html>
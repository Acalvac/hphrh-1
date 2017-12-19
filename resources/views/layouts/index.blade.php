<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">
        
        <title>H&aacute;bitat para la Humanidad</title>

        @section('estilos')
        <link rel="shortcut icon" href="{{asset('assets/images/habitat.ico')}}">

        <link href="{{asset('assets/plugins/switchery/switchery.min.css')}}" rel="stylesheet" />
        <link href="{{asset('assets/plugins/jquery-circliful/css/jquery.circliful.css')}}" rel="stylesheet" type="text/css" />

        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/css/core.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/css/components.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/css/pages.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/css/menu.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/css/responsive.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/css/spinners.css')}}" rel="stylesheet" type="text/css">

        @show

    </head>
    @if(isset($mensaje))
        @if($mensaje->conteo > 0)
        <body class="fixed-left" onload="$.Notification.autoHideNotify('info', 'top right', 'Notificaciones','Hay actividades que requieren su atención')">
        @else
        <body class="fixed-left">
        @endif
    @else
    <body class="fixed-left">
    @endif

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                       <a href="#" class="logo">
                       <!--
                       <i class="icon-uRdebe4TIM"></i>
                       -->
                       <span>
                       <img src="{{asset('assets/images/Habitat/logoh.png')}}" alt="" />
                       </span>
                       </a>
                    </div>
                </div>
                

                <!-- Navbar -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="">
                            <div class="pull-left">
                                <button class="button-menu-mobile open-left waves-effect">
                                    <i class="md md-menu"></i>
                                </button>
                                <span class="clearfix"></span>
                            </div>
                         
                            <!--
                            <ul class="nav navbar-nav hidden-xs">
                                <li><a href="#" class="waves-effect">Files</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle waves-effect" data-toggle="dropdown"
                                       role="button" aria-haspopup="true" aria-expanded="false">Projects <span
                                            class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Web design</a></li>
                                        <li><a href="#">Projects two</a></li>
                                        <li><a href="#">Graphic design</a></li>
                                        <li><a href="#">Projects four</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <form role="search" class="navbar-left app-search pull-left hidden-xs">
                                 <input type="text" placeholder="Search..." class="form-control app-search-input">
                                 <a href=""><i class="fa fa-search"></i></a>
                            </form>
                            -->
                            <ul class="nav navbar-nav navbar-right pull-right">
                                <li class="hidden-xs">
                                    <a href="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                                        {{ Auth::user()->name }}

                                    </a>
                                </li>
                                <li class="dropdown hidden-xs" id="">

                                    <a href="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" onclick="cargarnotificacion(1);">
                                        <i class="md md-notifications"></i> 
                                        <span class="badge badge-xs badge-pink"> {{Session::get('mensaje','0')}}</span>
                                    </a>
                                    
                                    <ul class="dropdown-menu dropdown-menu-lg" id="noti">
                                    </ul>

                                </li>
                                
                                <li class="hidden-xs">
                                    <a href="#" class="right-bar-toggle waves-effect waves-light">
                                        <i class="md md-settings"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <div id="sidebar-menu">
                        <ul>
                            <li class="menu-title"><strong>Principal</strong></li>

                            <li>
                                <a href="{{ url('/home')}}" class="waves-effect waves-primary">&nbsp;&nbsp;&nbsp;<i
                                class="md md-dashboard"></i><span> Tablero </span></a>
                            </li>

                            <li>
                                <a href="{{ url('/empleado/perfil')}}" class="waves-effect waves-primary">&nbsp;&nbsp;&nbsp;<i
                                class="md md-insert-emoticon"></i><span>Mi perfil </span></a>
                            </li>
                            
                            <li>
                            <a href="{{ url('/empleado/contacto')}}" class="waves-effect waves-primary">&nbsp;&nbsp;&nbsp;<i
                                class="md-perm-contact-cal"></i><span>Contactos </span></a>
                            </li>
                             
                        <!-- // Solicitudes___ // -->

                            <li>
                                <a href="{{url('/empleado/solicitud')}}" class="waves-effect waves-primary">&nbsp;&nbsp;
                                <i class="md md-assignment"></i><span>Solicitud</span>
                                </a> 
                            </li>
                            
                            <li>
                                <a href="{{url('/empleado/viaje')}}" class="waves-effect waves-primary">&nbsp;&nbsp;
                                <i class="md md-airplanemode-on"></i><span>Movilizaci&oacute;n</span>
                                </a> 
                            </li>
                            
                          

                        <!-- // Gestiones___ // -->

                            
                            @role('jefeinmediato') 
                            <li class="menu-title">Gesti&oacute;n</li>

                             <li>
                                <a href="{{url('/empleado/autorizaciones')}}" class="waves-effect waves-primary">&nbsp;&nbsp;&nbsp;
                                <i class="md md-assignment"></i><span>Autorizaciones</span>
                                </a> 
                            </li>
                            
                        

                            <li class="has_sub"> 
                                <a href="{{ url('/empleado/listadoR')}}" class="waves-effect waves-primary">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-drivers-license-o"></i><span>Reclutamiento</span>
                                </a>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect waves-primary" onclick="cargarvacante(1);">&nbsp;&nbsp;&nbsp;
                                    <i class="fa fa-file-text"></i><span>Solicitar puesto</span>
                                </a>
                            </li>
                        
                            <li class="has_sub">
                                <a href="{{ url('/ji/viajejf')}}" class="waves-effect waves-primary" onclick="cargarvacante(1);">&nbsp;&nbsp;&nbsp;
                                    <i class="md md-local-library"></i><span>Liquidaci&oacute;n</span>
                                </a>
                            </li>
 
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect waves-primary">&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-folder-open"></i> <span>Reportes</span>
                                     <span class="menu-arrow"></span>
                                </a>
                                <ul class="list-unstyled">
                                    <li><a href="{{ url('/ji/reporte/vpempleado')}}">Vacaciones y permiso</a></li>
                                </ul>
                            </li>
                        
                            @endrole

                            @role('asistente') 
                                <li class="menu-title"><strong>Movilización</strong></li>
                                <li>
                                    <a href="{{url('/asistente/cajachica')}}" class="waves-effect waves-primary">&nbsp;&nbsp;&nbsp;<i class="fa fa-credit-card-alt"></i><span>caja chica</span></a>
                                </li>
                                <li><a href="{{ url('/asistete/viaje')}}" class="waves-effect waves-primary">&nbsp;&nbsp;<i class="md md-insert-emoticon"></i><span>Avances</span></a></li>
                            @endrole
 

                        <!-- // Recurso Humano___ // -->


                            @role('recurso') 

                                <li class="menu-title"><strong>Recursos Humanos</strong></li>

                                <li>
                                    <a href="{{ url('/rh/listado')}}" class="waves-effect waves-primary">&nbsp;&nbsp;<i
                                    class="md md-insert-emoticon"></i><span>Empleados</span></a>
                                </li>

                                <li>
                                <a href="{{ url('/rh/listadoPV')}}" class="waves-effect waves-primary">&nbsp;&nbsp;<i
                                    class="fa fa-id-card"></i><span>Permiso y vacaciones</span></a>
                                </li>
                                
                                <li>
                                <a href="{{ url('/empleado/listadoR')}}" class="waves-effect waves-primary">&nbsp;&nbsp;<i
                                    class="md-perm-contact-cal"></i><span>Reclutamiento</span></a>
                                </li>

                                <li>
                                <a href="{{ url('/rh/vacante')}}" class="waves-effect waves-primary">&nbsp;&nbsp;<i
                                    class="ion-briefcase"></i><span>Habilitar puesto</span></a>
                                </li>

                                <li class="has_sub">
                                    <a href="javascript:void(0);" class="waves-effect waves-primary">&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-file"></i><span>Reportes</span> 
                                             <span class="menu-arrow"></span>
                                    </a><!--<span
                                            class="label label-success pull-right">6</span> -->
                                    <ul class="list-unstyled">
                                        <li><a href="{{ url('/empleado/Rmintrab')}}">Mintrab</a></li>
                                        <li><a href="{{ url('/rh/reporte/vpempleado')}}">Vacaciones y permiso</a></li>
                                    </ul>                                
                                </li>

                            @endrole

                            


                            @role('jefeinmediato')
                                @role('reporte')

                                <li class="menu-title">Reporte Financieros</li>


                                <li class="has_sub">
                                    <a href="javascript:void(0);" class="waves-effect waves-primary">&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-folder-open"></i> <span>Reportes</span>
                                     <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="list-unstyled">
                                        <li><a href="{{ url('/empleado/reporteEmpleado')}}">Empleado_general</a></li>
                                    </ul>
                                </li>
                                @endrole
                            @endrole

                            @role('informatica') 
                            <li class="menu-title">Panel de control</li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect waves-primary">&nbsp;&nbsp;&nbsp;<i
                                        class="md md-assignment"></i><span>Panel de control</span> 
                                         <span class="menu-arrow"></span>
                                </a><!--<span
                                        class="label label-success pull-right">6</span> -->
                                <ul class="list-unstyled">
                                    <li><a href="{{ url('/seguridad/usuario')}}">Registro usuario</a></li>
                                    <li><a href="{{ url('/seguridad/proyecto/')}}">Proyectos</a></li>
                                </ul>
                            </li>
                            @endrole
                        </ul>
                        <div class="clearfix"></div>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="user-detail">
                    <div class="dropup">
                     @if (Auth::guest())
                     <li><a href="{{ url('/login') }}">Login</a></li>
                     @else
                        <a href="" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true">
                            @include('hr.foto')

                            <span class="user-info-span">
                                <h5 class="m-t-0 m-b-0">{{ Auth::user()->name }}</h5>
                                <h5 class="m-t-0 m-b-0"> </h5>
                                <p class="text-muted m-b-0">
                                    <small><i class="fa fa-circle text-success"></i> <span>Online</span></small>
                                </p>                              
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('/empleado/perfil')}}"><i class="md md-face-unlock"></i> Perfil</a></li>
                            <li><a href="{{ url('/logout') }}"><i class="md md-settings-power"></i> Cerrar sesion</a></li>
                        </ul>
                    @endif
                    </div>
                </div>
            </div>
            <!-- Left Sidebar End --> 

            <!-- ============================================================== -->
            <!-- Start right Content here -->


            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container" id="contenidoprincipal">
                        @yield('contenido')
                    </div><!-- /.row -->
                </div>
                <footer class="footer text-right">
                    2017 © Solera.
                </footer><!-- /.box-body -->
            </div><!-- /.box -->
            <!-- Primer cargador en utilizar -->
            <div style="display: none;" id="cargador_empresa" align="center">
                <br>
                <label style="color:#FFF; background-color:#ABB6BA; text-align:center">&nbsp;&nbsp;&nbsp;Espere... &nbsp;&nbsp;&nbsp;</label>
                <img src="{{asset('imagenes/cargando.gif')}}" align="middle" alt="cargador"> &nbsp;<label style="color:#ABB6BA">Realizando tarea solicitada ...</label>
                <br>
                <hr style="color:#003" width="50%">
                <br>
            </div>

            <!-- Acutal cargador en utilizar -->
            <div style="display: none;" id="cargador1" align="center">
                <br>
                <label style="color:#FFF; background-color:#ABB6BA; text-align:center">&nbsp;&nbsp;&nbsp;Espere... &nbsp;&nbsp;&nbsp;</label>
                &nbsp;<label style="color:#ABB6BA">Realizando tarea solicitada ...</label>
                <br>
                <hr style="color:#003" width="50%">
                <br>

                <div class="ibox-content text-center">
                    <div class="h1 m-t-xs text-navy">
                        <span class="loading star"></span>
                    </div>
                </div>
            </div>

            <div id="listadoVacante"></div>
             
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->
            
            
            <!-- Right Sidebar -->
            <!--
            <div class="side-bar right-bar">
                <div class="nicescroll">
                    <ul class="nav nav-tabs tabs">
                        <li class="active tab">
                            <a href="#home-2" data-toggle="tab" aria-expanded="false">
                                <span class="visible-xs"><i class="fa fa-home"></i></span>
                                <span class="hidden-xs">Activity</span>
                            </a>
                        </li>
                        <li class="tab">
                            <a href="#profile-2" data-toggle="tab" aria-expanded="false">
                                <span class="visible-xs"><i class="fa fa-user"></i></span>
                                <span class="hidden-xs">Chat</span>
                            </a>
                        </li>
                        <li class="tab">
                            <a href="#messages-2" data-toggle="tab" aria-expanded="true">
                                <span class="visible-xs"><i class="fa fa-envelope-o"></i></span>
                                <span class="hidden-xs">Settings</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="home-2">
                            <div class="timeline-2">
                                <div class="time-item">
                                    <div class="item-info">
                                        <small class="text-muted">5 minutes ago</small>
                                        <p><strong><a href="#" class="text-info">John Doe</a></strong> Uploaded a photo <strong>"DSC000586.jpg"</strong></p>
                                    </div>
                                </div>

                                <div class="time-item">
                                    <div class="item-info">
                                        <small class="text-muted">30 minutes ago</small>
                                        <p><a href="" class="text-info">Lorem</a> commented your post.</p>
                                        <p><em>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam laoreet tellus ut tincidunt euismod. "</em></p>
                                    </div>
                                </div>

                                <div class="time-item">
                                    <div class="item-info">
                                        <small class="text-muted">59 minutes ago</small>
                                        <p><a href="" class="text-info">Jessi</a> attended a meeting with<a href="#" class="text-success">John Doe</a>.</p>
                                        <p><em>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam laoreet tellus ut tincidunt euismod. "</em></p>
                                    </div>
                                </div>

                                <div class="time-item">
                                    <div class="item-info">
                                        <small class="text-muted">1 hour ago</small>
                                        <p><strong><a href="#" class="text-info">John Doe</a></strong>Uploaded 2 new photos</p>
                                    </div>
                                </div>

                                <div class="time-item">
                                    <div class="item-info">
                                        <small class="text-muted">3 hours ago</small>
                                        <p><a href="" class="text-info">Lorem</a> commented your post.</p>
                                        <p><em>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam laoreet tellus ut tincidunt euismod. "</em></p>
                                    </div>
                                </div>

                                <div class="time-item">
                                    <div class="item-info">
                                        <small class="text-muted">5 hours ago</small>
                                        <p><a href="" class="text-info">Jessi</a> attended a meeting with<a href="#" class="text-success">John Doe</a>.</p>
                                        <p><em>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam laoreet tellus ut tincidunt euismod. "</em></p>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="tab-pane fade" id="profile-2">
                            <div class="contact-list nicescroll">
                                <ul class="list-group contacts-list">
                                    <li class="list-group-item">
                                        <a href="#">
                                            <div class="avatar">
                                                <img src="{{asset('assets/images/users/avatar-1.jpg')}}" alt="">
                                            </div>
                                            <span class="name">Chadengle</span>
                                            <i class="fa fa-circle online"></i>
                                        </a>
                                        <span class="clearfix"></span>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#">
                                            <div class="avatar">
                                                <img src="{{asset('assets/images/users/avatar-2.jpg')}}" alt="">
                                            </div>
                                            <span class="name">Tomaslau</span>
                                            <i class="fa fa-circle online"></i>
                                        </a>
                                        <span class="clearfix"></span>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#">
                                            <div class="avatar">
                                                <img src="{{asset('assets/images/users/avatar-3.jpg')}}" alt="">
                                            </div>
                                            <span class="name">Stillnotdavid</span>
                                            <i class="fa fa-circle online"></i>
                                        </a>
                                        <span class="clearfix"></span>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#">
                                            <div class="avatar">
                                                <img src="{{asset('assets/images/users/avatar-4.jpg')}}" alt="">
                                            </div>
                                            <span class="name">Kurafire</span>
                                            <i class="fa fa-circle online"></i>
                                        </a>
                                        <span class="clearfix"></span>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#">
                                            <div class="avatar">
                                                <img src="{{asset('assets/images/users/avatar-5.jpg')}}" alt="">
                                            </div>
                                            <span class="name">Shahedk</span>
                                            <i class="fa fa-circle away"></i>
                                        </a>
                                        <span class="clearfix"></span>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#">
                                            <div class="avatar">
                                                <img src="{{asset('assets/images/users/avatar-6.jpg')}}" alt="">
                                            </div>
                                            <span class="name">Adhamdannaway</span>
                                            <i class="fa fa-circle away"></i>
                                        </a>
                                        <span class="clearfix"></span>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#">
                                            <div class="avatar">
                                                <img src="{{asset('assets/images/users/avatar-7.jpg')}}" alt="">
                                            </div>
                                            <span class="name">Ok</span>
                                            <i class="fa fa-circle away"></i>
                                        </a>
                                        <span class="clearfix"></span>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#">
                                            <div class="avatar">
                                                <img src="{{asset('assets/images/users/avatar-8.jpg')}}" alt="">
                                            </div>
                                            <span class="name">Arashasghari</span>
                                            <i class="fa fa-circle offline"></i>
                                        </a>
                                        <span class="clearfix"></span>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#">
                                            <div class="avatar">
                                                <img src="{{asset('assets/images/users/avatar-9.jpg')}}" alt="">
                                            </div>
                                            <span class="name">Joshaustin</span>
                                            <i class="fa fa-circle offline"></i>
                                        </a>
                                        <span class="clearfix"></span>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#">
                                            <div class="avatar">
                                                <img src="{{asset('assets/images/users/avatar-10.jpg')}}" alt="">
                                            </div>
                                            <span class="name">Sortino</span>
                                            <i class="fa fa-circle offline"></i>
                                        </a>
                                        <span class="clearfix"></span>
                                    </li>
                                </ul>
                            </div>
                        </div>



                        <div class="tab-pane fade" id="messages-2">

                            <div class="row m-t-20">
                                <div class="col-xs-8">
                                    <h5 class="m-0">Notifications</h5>
                                    <p class="text-muted m-b-0"><small>Do you need them?</small></p>
                                </div>
                                <div class="col-xs-4 text-right">
                                    <input type="checkbox" checked data-plugin="switchery" data-color="#3bafda" data-size="small"/>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-xs-8">
                                    <h5 class="m-0">API Access</h5>
                                    <p class="m-b-0 text-muted"><small>Enable/Disable access</small></p>
                                </div>
                                <div class="col-xs-4 text-right">
                                    <input type="checkbox" checked data-plugin="switchery" data-color="#3bafda" data-size="small"/>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-xs-8">
                                    <h5 class="m-0">Auto Updates</h5>
                                    <p class="m-b-0 text-muted"><small>Keep up to date</small></p>
                                </div>
                                <div class="col-xs-4 text-right">
                                    <input type="checkbox" checked data-plugin="switchery" data-color="#3bafda" data-size="small"/>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-xs-8">
                                    <h5 class="m-0">Online Status</h5>
                                    <p class="m-b-0 text-muted"><small>Show your status to all</small></p>
                                </div>
                                <div class="col-xs-4 text-right">
                                    <input type="checkbox" checked data-plugin="switchery" data-color="#3bafda" data-size="small"/>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            -->
            <!-- /Right-bar -->

        </div>

        <!-- END wrapper -->


    <div id="modalbuscar"></div>
    <input type="hidden"  id="url_raiz_proyecto" value="{{ url("/") }}" />
    @section('fin') 
        
    <!-- Plugins  -->
        <script src="{{asset('assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/js/detect.js')}}"></script>
        <script src="{{asset('assets/js/fastclick.js')}}"></script>
        <script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script>
        <script src="{{asset('assets/js/jquery.blockUI.js')}}"></script>
        <script src="{{asset('assets/js/waves.js')}}"></script>
        <script src="{{asset('assets/js/wow.min.js')}}"></script>
        <script src="{{asset('assets/js/jquery.nicescroll.js')}}"></script>
        <script src="{{asset('assets/js/jquery.scrollTo.min.js')}}"></script>
        <script src="{{asset('assets/plugins/switchery/switchery.min.js')}}"></script>
        
    <!-- Counter Up  -->
        <script src="{{asset('assets/plugins/waypoints/lib/jquery.waypoints.js')}}"></script>
        <script src="{{asset('assets/plugins/counterup/jquery.counterup.min.js')}}"></script>

        <!-- circliful Chart -->
        <script src="{{asset('assets/plugins/jquery-circliful/js/jquery.circliful.min.js')}}"></script>
        <script src="{{asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>

        <!-- skycons -->
        <script src="{{asset('assets/plugins/skyicons/skycons.min.js')}}" type="text/javascript"></script>
        
        <!-- Page js  -->
        <script src="{{asset('assets/pages/jquery.dashboard.js')}}"></script>

        <!-- Custom main Js -->
        <script src="{{asset('assets/js/jquery.core.js')}}"></script>
        <script src="{{asset('assets/js/jquery.app.js')}}"></script>
        <script src="{{asset('assets/js/modernizr.min.js')}}"></script>
        <script src="{{asset('assets/js/JefeInmediato/modal.js')}}"></script>
        <script src="{{asset('assets/js/notificacion.js')}}"></script>


        <!-- Notification js -->
        <script src="{{asset('assets/plugins/notifyjs/dist/notify.min.js')}}"></script>
        <script src="{{asset('assets/plugins/notifications/notify-metro.js')}}"></script>
        <meta name="_token" content="{!! csrf_token() !!}" />


        @show

        @section('text') 
        <script>
            var resizefunc = [];
        </script>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('.counter').counterUp({
                    delay: 100,
                    time: 1200
                });
                $('.circliful-chart').circliful();
            });
            // BEGIN SVG WEATHER ICON
            if (typeof Skycons !== 'undefined'){
            var icons = new Skycons(
                {"color": "#00b19d"},
                {"resizeClear": true}
                ),
                    list  = [
                        "clear-day", "clear-night", "partly-cloudy-day",
                        "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
                        "fog"
                    ],
                    i;
                for(i = list.length; i--; )
                icons.set(list[i], list[i]);
                icons.play();
            };
           
          
        </script>
        @show
    </body>
</html>
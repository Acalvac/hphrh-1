@extends ('layouts.index')
@section('estilos')
    @parent
        <link href="{{asset('assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" />
        <link href="{{asset('assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.standalone.css')}}" rel="stylesheet" />
@endsection
@section ('contenido')

<div class="row"> 
    
    <div class="col-lg-3 col-md-4">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Cambiar Fotografia</h3>
            </div>             
            <div id="notificacion_resul_fci"></div>
            <form  id="f_subir_imagen" name="f_subir_imagen" method="post"  action="updatefoto" class="formarchivo" enctype="multipart/form-data" >
                <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
                <input type="hidden" id="id" name="idusuario" value="{{Auth::user()->id}}">  
                <div class="text-center card-box">
                    <div class="member-card">
                        <div class="thumb-xl member-thumb m-b-10 center-block">
                            @if (Auth::user()->fotoperfil==="")
                                <img  src="{{asset('imagenes/avatar.jpg')}}" alt="user-img" class="img-circle" width="118px height 118px" id="fotografiaus">
                            @else
                                <img  src="{{asset('fotografias/'.Auth::user()->fotoperfil)}}" alt="user-img" class="img-circle" width="118px height 118px" id="fotografiaus">
                            @endif
                    
                        </div>
                        <div class="form-group">
                            <label>Imagen</label>
                            <input type="file" name="fotoperfil" class="archivo form-control" id="imagen" required><br /><br />
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-sm w-sm waves-effect m-t-10 waves-light">Guardar</button>
                        </div>
                    </div>

                </div> <!-- end card-box -->
            </form>
        </div>

        <div class="card-box">
            <h4 class="m-t-0 m-b-20 header-title">Cambiar password</h4>
            <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}" ALIGN=lef>
            {{ csrf_field() }}
            <div class="p-b-10">
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="control-label">E-Mail Address</label>

                    <div class="col-md-12">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="control-label">Password</label>

                    <div class="col-md-12">
                        <input id="password" type="password" class="form-control" name="password" required>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="password-confirm" class=" control-label" ALIGN="lef">Confirm Password</label>

                    <div class="col-md-12">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-2">
                        <button type="submit" class="btn btn-primary">
                            Cambiar datos
                        </button>
                    </div>
                </div>
                  </form>
            </div>
        </div>

    </div> <!-- end col -->


    <div class="col-md-8 col-lg-9">
        <div class="">
            <div class="">
                <ul class="nav nav-tabs navtab-custom">
                    <li class="">
                        <a href="#home" data-toggle="tab" aria-expanded="true">
                            <span class="visible-xs"><i class="fa fa-user"></i></span>
                            <span class="hidden-xs">Sobre Mi</span>
                        </a>
                    </li>
                    <li class=""> <a href="javascript:void(0);" onclick="cargarlistado(1,1);">
                    
                        <a href="#profile" data-toggle="tab" aria-expanded="false" >
                            <span class="visible-xs"><i class="fa fa-photo"></i></span>
                            <span class="hidden-xs">GALLERY</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="#settings" data-toggle="tab" aria-expanded="false">
                            <span class="visible-xs"><i class="fa fa-cog"></i></span>
                            <span class="hidden-xs">Ajustes</span>
                        </a>
                    </li>

                    <li class=""> <a href="javascript:void(0);" onclick="cargaracademico(1,1);">
                    
                        <a href="#academicos" data-toggle="tab" aria-expanded="false">
                            <span class="visible-xs"><i class="fa fa-cog"></i></span>
                            <span class="hidden-xs">Academico</span>
                        </a>
                    </li>
                   
                    <li class=""> <a href="javascript:void(0);" onclick="cargarfamilia(1,1);">

                        <a href="#familiares" data-toggle="tab" aria-expanded="false">
                            <span class="visible-xs"><i class="fa fa-cog"></i></span>
                            <span class="hidden-xs">Familia</span>
                        </a>
                    </li>
                    <li class="">
                    <a href="#" data-toggle="tab" aria-expanded="false">
                            <span class="visible-xs"><i class="fa fa-cog"></i></span>
                            <span class="hidden-xs">acor</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="home">
                        <p class="m-b-5">Hi I'm Johnathn Deo,has been the industry's standard dummy text ever
                            since the 1500s, when an unknown printer took a galley of type.
                            Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.
                            In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.
                            Nullam dictum felis eu pede mollis pretium. Integer tincidunt.Cras
                            dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend
                            tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend
                            ac, enim.</p>

                        <div class="m-t-30">
                            <h4>Experience</h4>

                            <div class=" p-t-10">
                                <h5 class="text-primary m-b-5">Lead designer / Developer</h5>
                                <p class="">websitename.com</p>
                                 <p><b>2010-2015</b></p>

                                <p class="text-muted font-13 m-b-0">Lorem Ipsum is simply dummy text
                                of the printing and typesetting industry. Lorem Ipsum has
                                been the industry's standard dummy text ever since the
                                1500s, when an unknown printer took a galley of type and
                                scrambled it to make a type specimen book.
                                </p>
                            </div>

                            <hr>

                            <div class="">
                                <h5 class="text-primary m-b-5">Senior Graphic Designer</h5>
                                <p class="">coderthemes.com</p>
                                <p><b>2007-2009</b></p>

                                <p class="text-muted font-13">Lorem Ipsum is simply dummy text
                                    of the printing and typesetting industry. Lorem Ipsum has
                                    been the industry's standard dummy text ever since the
                                    1500s, when an unknown printer took a galley of type and
                                    scrambled it to make a type specimen book.
                                </p>
                            </div>
                        </div>
                    </div>
                    @include('hr.galeria')
                    <div class="tab-pane" id="settings">
                        <form role="form">
                            <div class="form-group">
                                <label for="name">Nombre usuario</label>
                            </div>
                            <div class="form-group">
                                <label for="Password">Contraseña</label>
                            </div>
                            <div class="form-group">
                                <label for="RePassword">Re-Password</label>
                            </div>
                            <div class="form-group">
                                <label for="AboutMe">About Me</label>
                                <textarea style="height: 125px" id="AboutMe" class="form-control">Loren gypsum dolor sit mate, consecrate disciplining lit, tied diam nonunion nib modernism tincidunt it Loretta dolor manga Amalia erst volute. Ur wise denim ad minim venial, quid nostrum exercise ration perambulator suspicious cortisol nil it applique ex ea commodore consequent.</textarea>
                            </div>
                            <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Save</button>
                        </form>
                    </div>
                    @include('hr.academico')
                    @include('hr.familia')

                 

                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div>
@endsection

@section('fin')
    @parent
    <meta name="_token" content="{!! csrf_token() !!}" />
    <script src="{{asset('assets/js/foto.js')}}"></script>
    <script src="{{asset('assets/js/academico.js')}}"></script>
    <script src="{{asset('assets/js/familia.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js')}}"></script>
    
    <script>cargarlistado(1);   </script>
    <script>cargaracademico(1); </script>
    <script>cargarfamilia(1);   </script>
    


@endsection
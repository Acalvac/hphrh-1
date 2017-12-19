<link href="{{asset('assets/plugins/select2/select2.css')}}" rel="stylesheet" />
<div class="card-box" id="VPJF">
    @if($liquidar == 1)
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="navbar-form navbar-left pull-left">
            <button class="btn btn-success btn-md"onclick="cargar_formularioviaje(23);"><i class="fa fa-reply-all"></i></button>
        </div>
        <h4 class="box-title" align="center">Liquidaci&oacute;n viaje revisado</h4>
        <hr style="border-color:black;" />
    </div>
    <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>" />
    <input type="hidden" id="idempleado" value="{{$proyecto->idempleado}}">
    <input type="hidden" id="idgastocabeza" value="{{$proyecto->idgastocabeza}}">
    <input type="hidden" id="idgastoviaje" value="{{$proyecto->idgastoviaje}}">
    <div class="panel">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="navbar-form navbar-left pull-left">
                <div class="row">
                    <div class="col-sm-4">
                        <button class="btn btn-info waves-effect waves-light btn-NuevoL" value="{{$proyecto->idempleado}}">Agregar <i class="fa fa-plus"></i></button>
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-success waves-effect waves-light btn-on" id="btnEnviarL">Aceptar</button>
                    </div>
                    <div class="col-sm-4">
                        <button class="btn btn-danger waves-effect waves-light btn-of" id="btnEnviarL">Rechazar</button>
                    </div>
                </div>
            </div>
            <div class="navbar-form navbar-left pull-right">
                <div class="form-group col-lg-6">
                    <label>Monto solicitado</label>
                    <label>{{$proyecto->monto}}</label>            
                </div>
                <div class="form-group col-lg-6">
                    <label>Tipo Proyecto</label>
                    <label>{{$proyecto->nombreproyecto}}</label>            
                </div>
                <div class="form-group col-lg-6">
                    <label>Fecha inicio</label>
                    <label>{{\Carbon\Carbon::createFromFormat('Y-m-d',$proyecto->fechainicio)->format('d/m/Y')}}</label>
                </div>
                <div class="form-group col-lg-6">
                    <label>Fecha final</label>
                    <label>{{\Carbon\Carbon::createFromFormat('Y-m-d',$proyecto->fechafin)->format('d/m/Y')}}</label>
                </div>
            </div>            
        </div>
        <div class="panel-body">
            <div class="row">
            </div>
            @if(isset($vehiculo))
            @if(count($vehiculo) > 0)
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr>
                                <th style="width: 2%">id</th>
                                <th style="width: 50%">vehiculo</th>
                                <th style="width: 24%">kilometraje inicial</th>
                                <th style="width: 24%">kilometraje final</th>
                                <th style="width: 5%">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vehiculo as $veh)
                            <tr id="vehiculos{{$veh->idviajevehiculo}}">
                                <td>{{$veh->idviajevehiculo}}</td>
                                <td>{{$veh->marca.' '.$veh->color.' '.$veh->modelo}}</td>
                                <td>{{$veh->kilometrajeini}}</td>
                                <td>{{$veh->kilometrajefin}}</td>
                                <td>
                                <a href="javascript:void(0);" onclick="vehiculo({{$veh->idviajevehiculo}});"><i class="fa fa-pencil"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            @endif
            <div class="pull-right">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed table-hover">
                        <tr>
                            <th><p style="color:green;" align="center">Fondo Efectivo</p></th><td id="montot">{{$proyecto->monto}}</td>
                        </tr>
                        <tr>
                            <th bgcolor="#BCF5A9"><p style="color:green;" align="center">Liquidación</p></th><td bgcolor="#BCF5A9" id="liquidacion"><strong>{{$liquidacion->liquidacion}}</strong></td>

                        </tr>
                        <tr>
                            <th><p style="color:green;" align="center">Disponible</p></th><td id="disponible">{{$proyecto->monto - $liquidacion->liquidacion}}</td>
                        </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive" id="mainTable">
                    <table class="table table-striped table-bordered table-condensed table-hover" id="tabprueba">
                        <thead>
                            <tr>
                                <th style="width: 2%">Id</th>
                                <th style="width: 4%">Fecha</th>
                                <th style="width: 15%">Descripci&oacute;n</th>
                                <th style="width: 10%"># Factura</th>
                                <th style="width: 13%">Empleado</th>
                                <th style="width: 13%">Cuenta</th>
                                <th>Eventos</th>
                                <th style="width: 8%">Línea de presupuesto</th>
                                <th style="width: 11%">Proyecto L9</th>
                                <th style="width: 8%">Funci&oacute;n L2</th>
                                <th style="width: 6%">Monto</th>
                                <th style="width: 2%"><i class="ti-check-box"></i></th>
                                <th style="width: 2%"><i class="glyphicon glyphicon-eye-open"></i></th>
                                <th style="width: 4%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gastoviajeemp as $gvi)
                            <tr>
                                <td>{{$gvi->idgastoempleado}}</td>
                                <td>{{\Carbon\Carbon::createFromFormat('Y-m-d',$gvi->fecha)->format('d/m/Y')}}</td>
                                <td>{{$gvi->descripcion}}</td>
                                <td>{{$gvi->factura}}</td>
                                <td>{{$gvi->nombre1.' '.$gvi->nombre2.' '.$gvi->nombre3.' '.$gvi->apellido1.' '.$gvi->apellido2.' '.$gvi->apellido3}}</td>
                                <td>{{$gvi->cuenta}}</td>
                                <td>{{$gvi->evento}}</td>
                                <td>{{$gvi->donante}}</td>
                                <td>{{$gvi->proyecto}}</td>
                                <td>10</td>
                                <td>{{$gvi->monto}}</td>
                                @if($gvi->check1 == 1)
                                <td><input id="checkbox1" class="checkbox1" type="checkbox" disabled checked value="{{$gvi->idgastoempleado}}"></td>
                                @else
                                <td><input id="checkbox1" class="checkbox1" type="checkbox" disabled value="{{$gvi->idgastoempleado}}"></td>
                                @endif
                                @if($gvi->check2 == 1)
                                <td><input id="checkbox2" class="checkbox2" type="checkbox" checked disabled value="{{$gvi->idgastoempleado}}"></td>
                                @else
                                <td><input id="checkbox2" class="checkbox2" type="checkbox" disabled value="{{$gvi->idgastoempleado}}"></td>
                                @endif
                                <td class="actions">
                                    <a href="#" class="hidden on-editing save-row"><i class="fa fa-save"></i></a>
                                    <a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>
                                    <a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                    <a href="#" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- end: page -->
    </div> 
    @else
        <br/><div class='rechazado' align="center"><label style='color:#FA206A'>...No se ha encontrado ninguna liquidacion...</label>  </div> 
    @endif
</div>
<div class="col-lg-12 col-md-12" id="modales">
    <div class="modal fade" id="formModalLiquidar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" align="center" id="inputTitleLiquidar"></h4>
                </div>
                <div id="modaliq"></div>
                <div class="modal-footer">
                    <div class="col-md-12">
                        <div><br></div>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                         <button id="Glempleado" class="btn btn-primary waves-effect waves-light">Guardar</i></button>
                        <input type="hidden" id="idgastoemp" value="0"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12 col-md-12" id="modalveh">
    <div class="modal fade" id="formModalVehiculo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" align="center" id="inputTitleVeh"></h4>
                </div>

                <form role="form" id="formLiquidarVeh">
                    <div class="modal-header">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Kilometraje final</label>
                            <input id="kfinal" type="number" min="0" value="0" class="form-control" onkeypress="return valida(event)">
                        </div>
                    </div>
                </form>

                <div class="modal-footer">
                    <div class="col-md-12">
                        <div><br></div>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="Glvehiculo" class="btn btn-primary waves-effect waves-light btn-Glvehiculo">Guardar</i></button>
                        <input type="hidden" id="idviajveh" value="0"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="erroresModal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="inputError">Errores</h4>
            </div>
            <div class="modal-body">
                <ul style="list-style-type:circle" id="erroresContent"></ul>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<meta name="_token" content="{!! csrf_token() !!}" />
<script src="{{asset('assets/js/valida.js')}}"></script>
<script src="{{asset('assets/js/JefeInmediato/liquidarJI.js')}}"></script>
<script src="{{asset('assets/js/JefeInmediato/respuestaviaje.js')}}"></script>
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js')}}"></script>
<script type="text/javascript">
    var urlraiz=$("#url_raiz_proyecto").val();
    $(document).on('click','.btn-NuevoL',function(e){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        var ids=$("#idgastocabeza").val()
        var id=$(this).val();
        var miurl = urlraiz+"/asistete/viaje/liquidar/add/"+id+"/"+ids;
        $.get(miurl,function(data){
            $("#modaliq").html(data);
            $('#inputTitleLiquidar').html("Agregar registro liquidación");
            $('#formAgregarLiquidar').trigger("reset");
            $('#formModalLiquidar').modal('show');
            $('#Glempleado').val('add');

        });
    });
    function vehiculo(id)
    {
        var miurl = urlraiz+"/empleado/viaje/vehiculo/edit/"+id;
        $.get(miurl,function(data){
            $('#idviajveh').val(id);
            $('#kfinal').val(data.kilometrajefin);
            
            $('#inputTitleVeh').html("Modificar kilometraje final");
            $('#formModalVehiculo').modal('show');
        });        
    }
    $(document).on('click','a.veh-edit',function(e){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        alert("mensaje");
    });
</script>
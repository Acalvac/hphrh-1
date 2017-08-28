<div class="card-box">
    <div class="box-header with-border my-box-header">
        <h3 class="box-title"><strong>Asignar y/o quitar jefe inmediato</strong></h3>
    </div>

    <hr style="border-color:black;" />

    <div id="zona_etiquetas_nombramiento" style="background-color:white;" >
        Jefes asignados:
        @foreach($jefeasignado as $jfa)
            <span class="label label-warning" style="margin-left:10px;">{{ $jfa->nombre1.' '.$jfa->nombre2.' '.$jfa->apellido1.' '.$jfa->apellido2 }} </span> 
        @endforeach
    </div>
    <br>

    <div class="box-body">

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-sm-2" for="tipo">Jefe inmediato a asignar</label>
                <div class="col-sm-6" >         
                    <select name="jefe1" id="jefe1" class="form-control select2" data-live-search="true">
                        @foreach($jefes as $co)
                            <option value="{{$co->identificacion}}">{{$co->nombre1.' '.$co->nombre2.' '.$co->apellido1.' '.$co->apellido2}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-1" >
                    <label> Notificar <br> </label>
                    <div>
                        <input type="checkbox" id="confirma1" value="1"> Si
                    </div>
                </div>
                <div class="col-sm-2" >
                    <button type="button" class="btn btn-xs btn-primary" onclick="asignar_jefeinmediato( {{$empleado->idempleado}} );" >Asignar jefe inmediato</button>    
                </div>
            </div>
        </div>
        <hr>

        <div class="col-md-12">
             <div class="form-group">
                <label class="col-sm-2" for="tipo">Jefe inmediato a quitar</label>
                <div class="col-sm-7" >         
                    <select id="jefe2" name="jefe2" class="form-control select2" data-live-search="true">
                    @foreach($jefeasignado as $jfa)
                        <option value="{{ $jfa->identificacion }}">{{ $jfa->nombre1.' '.$jfa->nombre2.' '.$jfa->apellido1.' '.$jfa->apellido2 }}</option>
                    @endforeach
                    </select>    
                </div>
                
                <div class="col-sm-2" >         
                    <button type="button" class="btn btn-xs btn-primary" onclick="quitar_jefeinmediato({{$empleado->idempleado}});" >Quitar jefe inmediato</button>    
                </div>
            </div>
        </div>
    </div>
    

    <br><br><br>

    <div class="box-header with-border my-box-header">
        <h3 class="box-title"><strong>Agregar nuevo nombramiento y/o asecenso</strong></h3>
    </div>   

    <hr style="border-color:black;" />
    <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label>Empleado</label>
                        <select name="idempleado" id="idempleado" class="form-control select2" data-live-search="true">
                                <option value="{{$empleado->idempleado}}">{{$empleado->nombre1.' '.$empleado->nombre2.' '.$empleado->apellido1.' '.$empleado->apellido2}}</option>
                        </select>
                    </div>                                                
                </div>

                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label>Afiliado al que aplica</label>
                        <select name="idafiliado" id="idafiliado" class="form-control select2" data-live-search="true"">
                            @foreach($afiliados as $af)
                                @if($af->idafiliado == $empleado->idafiliado)
                                    <option value="{{$af->idafiliado}}" selected>{{$af->nombre}}</option>
                                @else
                                    <option value="{{$af->idafiliado}}">{{$af->nombre}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label>Puesto</label>
                        <select name="idpuesto" id="idpuesto" class="form-control select2" data-live-search="true"">
                            @foreach($puestos as $pu)
                                @if($pu->idpuesto == $empleado->idpuesto)
                                    <option value="{{$pu->idpuesto}}" selected>{{$pu->nombre}}</option>
                                @else
                                    <option value="{{$pu->idpuesto}}">{{$pu->nombre}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label>Caso</label>
                        <select name="idcaso" id="idcaso" class="form-control select2" data-live-search="true" >
                            @foreach($caso as $co)
                                <option value="{{$co->idcaso}}">{{$co->nombre}}</option>
                            @endforeach
                        </select>
                    </div>                                                
                </div>

                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <label for="salario">Salario</label>
                    <div class="input-group">
                        <span class="input-group-addon">Q</i></span>
                        <input type="text" onkeypress="return valida(event)" min="0" name="salario" id="salario" class="form-control">
                    </div>
                    @if($errors->has('salario'))
                        <span style="color: red;">{{$errors->first('salario')}}</span>
                    @endif
                </div>

                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="fecha">Fecha </label>
                        <input id="dato1" type="text" class="form-control" name="fecha">
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label>Jefe inmediato</label>
                        <select name="idjefe" id="jefe" class="form-control select2" data-live-search="true"">
                            @foreach($jefes as $co)
                                <option value="{{$co->identificacion}}">{{$co->nombre1.' '.$co->nombre2.' '.$co->apellido1.' '.$co->apellido2}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-1 col-md-4 col-sm-6 col-xs-12">
                    <label> Notificar <br> </label>
                    <div>
                        <input type="checkbox" id="confirma" value="1"> Si
                    </div>
                </div>

                <div class="col-lg-1 col-md-4 col-sm-6 col-xs-12">
                    
                    <div class="form-group">
                        <button type="button" id="bt_add1"  onclick="AsignajefeAsecenso();" style="background-color: #E6E6E6" class="btn">Asignar</button>
                    </div>                 
                </div>
                <div class="col-lg-5 col-sm-12 col-md-12 col-xs-12">
                    <div class="table-responsive">             
                        <table id="detalle7" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th>opciones</th>
                                    <th>Jefe</th>
                                    <th>Identificaci&oacute;n</th>
                                    <th>Notifica</th>
                                </tr>
                            </thead>
                            <tr>
                                
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="descripcion">Observaciones</label>
                    <div class="form-group">
                        <textarea class="form-control" maxlength="100" name="descripcion" id="descripcion" placeholder=".........." rows="3"></textarea>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">

                        <button class="btn btn-primary btn-guardarAsecenso" id="btnguardar">Guardar</button>
                        <a href=""><button class="btn btn-danger " id="btncancelar" type="button">Cancelar</button></a>
                    </div>
                </div>
            </div>
    </div>
</div>

        <script src="{{asset('assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
        <script src="{{asset('assets/plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js')}}"></script>
        <script src="{{asset('assets/plugins/bootstrap-datepicker/dist/js/datapickerf.js')}}"></script>
        <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
        <script src="{{asset('assets/plugins/bootstrap-sweetalert/sweet-alert.min.js')}}"></script>
        <script src="{{asset('assets/pages/jquery.sweet-alert.init.js')}}"></script>

        <script type="text/javascript">
            $(".select2").select2();

            $("#btnguardar").hide();
            $("#btncancelar").hide();
        </script>

       
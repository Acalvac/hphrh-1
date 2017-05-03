<div class="tab-pane" id="academicos">
    <div class="panel-heading">
        <button class="btn btn-success" id="btnAgregar"><i class="icon-user icon-white" ></i> Agregar estudios</button>
    </div>
  <div class=class="col-lg-8 col-md-8 col-sm-8 col-xs-12" >
    <div class="table-responsive" id="tabla">
      <table class="table table-striped table-bordered table-condensed table-hover" id="dataTableItems">
        <thead>
          <th>Titulo</th>
          <th>Institucion</th>
          <th>Duracion</th>
          <th>Nivel</th>
          <th>Fecha Ingreso</th>
          <th>Fecha Salida</th>
        </thead>
        <tbody>
          @if (isset($empleado))
            @for ($i=0;$i<count($empleado);$i++)
              <tr class="even gradeA" id="ite">
                <td>{{$empleado[$i]->titulo}}</td>
                <td>{{$empleado[$i]->establecimiento}}</td>
                <td>{{$empleado[$i]->duracion.': '.$empleado[$i]->periodo}}</td>
                <td>{{$empleado[$i]->nombrena}}</td>
                <td>{{\Carbon\Carbon::createFromFormat('Y-m-d',$empleado[$i]->fingreso)->format('d-m-Y')}}</td>
                <td>{{\Carbon\Carbon::createFromFormat('Y-m-d',$empleado[$i]->fsalida)->format('d-m-Y')}}</td>
              </tr>
            @endfor
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>
  <div class="col-lg-12">
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="inputTitle"></h4>
          </div>
          <div class="modal-body">
              <form role="form" id="formAgregar">
                @if (isset($empleado))
                  @foreach ($empleado as $emp)
                  <input type="hidden" id="idempleado" name="idempleado" value="{{$emp->idempleado}}">
                  <input type="hidden" id="identificacion" name="identificacion" value="{{$emp->identificacion}}">
                  @endforeach
                @endif

                  <div class="form-group">
                      <label>Titulo</label>
                      <input class="form-control" id="titulo" name="titulo">
                  </div>                                          
                                                
                  <div class="form-group">
                      <label>Establecimiento</label>
                      <input class="form-control" id="establecimiento" name="establecimiento"/>
                  </div>                                                           
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label for="duracion">Duracion</label>
                      <div class="form-group">
                        
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="duracion" id="duracion" class="form-control" onkeypress="return valida(event)">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <select id="periodo" name="periodo" class="form-control">
                            <option value="Dia">Día</option>
                            <option value="Mes">Mes</option>
                            <option value="Año">Año</option>
                          </select>
                        </div>
                      </div>
                  </div>
                  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
                    <label for="nivel">Nivel</label>
                    <div class="form-group">
                      <select name="idnivel" id="idnivel" class="form-control selectpicker" data-live-search="true" data-style="btn-info">
                      @if (isset($nivelacademico))
                        @foreach($nivelacademico as $depa)
                        <option value="{{$depa->idnivel}}">{{$depa->nombrena}}</option>
                        @endforeach
                      @endif
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group ">
                      <label >Fecha de ingreso</label>
                      <input type="text" id="fecha_ingreso" class="form-control" name="fecha_ingreso">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group ">
                      <label for="fsalida">Fecha de salida</label>
                      <input type="text" id="fecha_salida" name="fecha_salida" class="form-control">
                    </div>
                  </div> 
                  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label>Departamento</label>
                      <select name="iddepartamento" id="iddepartamento1" class="form-control selectpicker" data-live-search="true" data-style="btn-info">
                      @if (isset($departamento))
                        @foreach($departamento as $depa)
                          <option value="{{$depa->iddepartamento}}">{{$depa->nombre}}</option>
                        @endforeach
                      @endif  
                      </select>
                    </div>                                                
                  </div>      
                  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
                      <div class="form-group">
                          <label>Municipio</label>
                              {!! Form::select('pidmunicipio',['placeholder'=>'Selecciona'],null,['id'=>'pidmunicipio','class'=>'form-control']) !!}
                      </div>
                  </div>
              </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" id="btnGuardar">Guardar</button>
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
        <h4 class="modal-title">Errores</h4>
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

<script src="{{asset('assets/js/academico.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-datepicker/dist/js/datapickerf.js')}}"></script>
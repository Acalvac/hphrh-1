<div class="tab-pane" id="familiares">
    <div class="panel-heading">
        <button class="btn btn-success" id="btnagregarF"><i class="icon-user icon-white" ></i> Agregar Familiar</button>
    </div>
  <div class=class="col-lg-8 col-md-8 col-sm-8 col-xs-12" >
    <div class="table-responsive" id="tabla">
      <table class="table table-striped table-bordered table-condensed table-hover" id="dataTablefamilia">
        <thead>
          <th>Parentezco</th>
          <th>Nombre</th>
          <th>Ocupacion</th>
          <th>Edad</th>
          <th>Telefono</th>
          <th>Emergencia</th>
        </thead>
        <tbody>
          @if (isset($empleado))
            @for ($i=0;$i<count($empleado);$i++)
              <tr class="even gradeA" id="ite">
                <td>{{$empleado[$i]->parentezco}}</td>
                <td>{{$empleado[$i]->nombref.' '.$empleado[$i]->apellidof}}</td>
                <td>{{$empleado[$i]->ocupacion}}</td>
                <td>{{$empleado[$i]->edad}}</td>
                <td>{{$empleado[$i]->telefonof}}</td>
                <td>{{$empleado[$i]->emergencia}}</td>
              </tr>
            @endfor
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="col-lg-12">
  <div class="modal fade" id="formModalF" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="inputTitleF"></h4>
        </div>
        <div class="modal-body">
          <form role="form" id="formAgregarF">
            @if (isset($empleado))
              @foreach ($empleado as $emp)
                <input type="hidden" id="idempleado" name="idempleado" value="{{$emp->idempleado}}">
                <input type="hidden" id="identificacion" name="identificacion" value="{{$emp->identificacion}}">
              @endforeach
            @endif                             
            <div class="form-group">
              <label for="nombref">Nombres de familiar</label>
              <input type="text" id="nombref" name="nombref" maxlength="30" class="form-control" onkeypress="return validaL(event)">
            </div>
            <div class="form-group">
              <label for="apellidof">Apellidos de familiar</label>
              <input type="text" id="apellidof" name="apellidof" maxlength="30" class="form-control" onkeypress="return validaL(event)">
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="edad">Edad</label>
                <input type="text" maxlength="3" id="edad" name="edad" class="form-control" onkeypress="return valida(event)">
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label>Parentezco</label>
                <select name="parentezco" id="parentezco" class="form-control">
                  <option value="Padre">Padre</option>
                  <option value="Madre">Madre</option>
                  <option value="Hermano">Hermano</option>
                  <option value="Conyuge">Conyuge</option>
                  <option value="Hijo">Hijo(a)</option>
                </select>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <label for="telefonof">Telefono de familiar</label>
              <div class="input-group">
                <span class="input-group-addon">502</i></span>
                <input type="text" id="telefonof" name="telefonof" class="form-control" maxlength="8" onkeypress="return valida(event)">
              </div>
              <label class="radio-inline">LLamar en caso de emergencias </label>
              <input type="checkbox" id="emergencia" name="emergencia" value="no">
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="ocupacion">Ocupacion</label>
                <input type="text" id="ocupacion" name="ocupacion" maxlength="40" class="form-control" onkeypress="return validaL(event)">
              </div>
            </div>                                                                         
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="btnGuardarF">Guardar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="erroresModalF" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Errores</h4>
      </div>

      <div class="modal-body">
        <ul style="list-style-type:circle" id="erroresContentF"></ul>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

 
<script src="{{asset('assets/js/familia.js')}}"></script>




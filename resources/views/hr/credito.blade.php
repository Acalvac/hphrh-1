<div class="tab-pane" id="creditos">
    <div class="panel-heading">
        <button class="btn btn-success" id="btnAgregarC"><i class="icon-user icon-white" ></i> Agregar credito</button>
    </div>
  <div class=class="col-lg-8 col-md-8 col-sm-8 col-xs-12" >
    <div class="table-responsive" id="tabla">
      <table class="table table-striped table-bordered table-condensed table-hover" id="dataTableItemsC">
        <thead>
          <th>Acreedor</th>
          <th>Amortizacion mensual</th>
          <th>Monto deuda</th>

        </thead>
        <tbody>
          @if (isset($deuda))
            @for ($i=0;$i<count($deuda);$i++)
              <tr class="even gradeA" id="ite">
                <td>{{$deuda[$i]->acreedor}}</td>
                <td>{{$deuda[$i]->amortizacionmensual}}</td>
                <td>{{$deuda[$i]->montodeuda}}</td>
              </tr>
            @endfor
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>
  <div class="col-lg-12">
    <div class="modal fade" id="formModalC" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="inputTitleC"></h4>
          </div>
          <div class="modal-body">
             	<form role="form" id="formAgregarC">
                @if (isset($empleado))
                  <input type="hidden" id="idempleado" name="idempleado" value="{{$empleado->idempleado}}">
                  <input type="hidden" id="identificacion" name="identificacion" value="{{$empleado->identificacion}}">
                  
                @endif


                  <div class="form-group">
                      <label for="acreedor">Acreedor</label>
                      <input type="text" id="acreedor" name="acreedor" class="form-control" onkeypress="return validaL(event)">
                  </div>

                  <div class="form-group">
                  <label for="amortizacionmensual">Amortizacion mensual</label>
                  <div class="input-group">

                      <span class="input-group-addon">Q</i></span>
                      <input type="text" min="0" id="amortizacionmensual" name="amortizacionmensual" class="form-control" onkeypress="return valida(event)">
                      </div>
                  </div>
              
                  <div class="form-group">
                   
                    <label for="montodeuda">Monto deuda</label>
                    <div class="input-group">
                       <span class="input-group-addon">Q</i></span>
                      <input type="text" min="0" id="montodeuda" name="montodeuda" class="form-control" onkeypress="return valida(event)">
                    </div>
                  </div>                    
              </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" id="btnGuardarC">Guardar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

<div class="modal fade" id="erroresModalC" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Errores</h4>
      </div>

      <div class="modal-body">
        <ul style="list-style-type:circle" id="erroresContentC"></ul>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script src="{{asset('assets/js/credito.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-datepicker/dist/js/datapickerf.js')}}"></script>
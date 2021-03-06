<div class="row" id="tblsolicitante">
<form  role="form" id="formUpdate" >
  <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <label >Nombre Completo</label>
        <div class="row">
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <input type="textt" id="nombre1" value="{{$persona->nombre1}}">
                <input type="textt" id="apellido1" value="{{$persona->apellido1}}">
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <input type="textt" id="nombre2" value="{{$persona->nombre2}}">
                <input type="textt" id="apellido2" value="{{$persona->apellido2}}">
            </div>
          </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <div class="form-group">
        <label >Identificación</label><br>
        {{$empleado->identificacion}}
        <input type="hidden" id="identificacionup" value="{{$empleado->identificacion}}">
        <input type="hidden" id="idempleado" value="{{$empleado->idempleado}}">
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <div class="form-group">
      <label>Nit</label>
        <input type="textt" id="nit" maxlength="9" value="{{$empleado->nit}}">
        <input type="hidden" id="nit" value="{{$empleado->idstatus}}">
      </div>
    </div>
  </div>

    <div class="row">
      <div class="table-responsive">
            <table id="detalles" class="table table-striped m-b-0 table-bordered table-condensed table-hover table-responsive" >
            <p><h2 ALIGN=center>Datos Personales</h2></p>
              <thead style="background-color:#A9D0F5">
                <th>Dirección </th>
                <th style="width: 4%">Teléfono</th>
                <th style="width: 6%">Fecha Nacimiento</th>
                <th>Departamento</th>
                <th>Municipio</th>
                <th style="width: 6%">Estado Civil</th>
                <th style="width: 7%">Afiliado</th>
                <th>Puesto Aplicar</th>
                <th style="width: 7%">IGSS</th>
                <th style="width: 6%">Dependientes</th>
                <th style="width: 5%">Aporte Mensual</th>
                <th style="width: 6%">Vivienda</th>
                <th style="width: 5%">Alquiler Mensual</th>
                <th style="width: 5%">Otros Ingresos</th>
                <th>Pretensión</th>
                <th style="width: 5%">Fecha de solicitud</th>
              </thead>
              <tbody>
                <tr>
                  <td><input type="textt" id="barriocolonia" value="{{$persona->barriocolonia}} "></td>
                  <td><input type="textt" id="telefono" maxlength="8" value="{{$persona->telefono}}"></td>
                  <td><input type="textt" id="fechanac" value="{{ \Carbon\Carbon::createFromFormat('Y-m-d', $persona->fechanac)->format('d-m-Y')}}"></td>
                  @if (!empty($persona->departamento))
                    <td>{{$persona->departamento}}</td>
                    <td>{{$persona->municipio}}</td>
                  @else
                    <td>Extranjero</td>
                    <td>Extranjero</td>
                  @endif
                  <td>
                    <select class="form-control selectpicker1">
                      
                      @foreach($estadocivil as $cat)
                        @if($cat->idcivil == $empleado->idcivil)
                          <option value="{{$cat->idcivil}}" selected>{{$cat->estado}}</option>
                        @else
                          <option value="{{$cat->idcivil}}">{{$cat->estado}}</option>
                        @endif
                      @endforeach
                    </select>
                  </td>
                  <td>{{$persona->afiliado}}</td>
                  <td>{{$persona->puesto}}</td>
                  <td><input type="textt" maxlength="13" id="iggs" value="{{$empleado->afiliacionigss}}"></td>
                  <td><input type="textt" id="dependientes" value="{{$empleado->numerodependientes}}"></td>
                  <td><input type="textt" id="aportemensual" value="{{$empleado->aportemensual}}"></td>
                  <td><input type="textt" id="vivienda" value="{{$empleado->vivienda}}"></td>
                  <td><input type="textt" id="alquilermensual" value="{{$empleado->alquilermensual}}"></td>
                  <td><input type="textt" id="otrosingresos" value="{{$empleado->otrosingresos}}"></td>
                  <td>{{$empleado->pretension}}</td>
                  <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d',$empleado->fechasolicitud)->format('d-m-Y')}}</td>
                </tr>
              </tbody>
            </table>
      </div>

      <div class="table-responsive">  
            <table id="detallesF" class="table table-striped table-bordered table-condensed table-hover table-responsive" >
            <p><h2 ALIGN=center>Datos Familiares</h2></p>
              <thead style="background-color:#A9D0F5">
                <th style="width:0%"></th>
                <th>Nombre</th>
                <th>Parentezco</th>
                <th>Teléfono</th>
                <th>Ocupación</th>
                <th>Edad</th>
                <th>Emergencia</th>
              </thead>
              <tbody>
              @foreach($familiares as $fam)
                <tr class="filaTableF">
                  <td><input type="hidden" class="idpfamilia" value="{{$fam->idpfamilia}}"></td>
                  <td><input type="textt" class="nombref" value="{{$fam->nombref}}"></td>
                  <td><input type="textt" class="parentezco" value="{{$fam->parentezco}}"></td>
                  <td><input type="textt" class="telefonof" value="{{$fam->telefonof}}"></td>
                  <td><input type="textt" class="ocupacion" value="{{$fam->ocupacion}}"></td>
                  <td><input type="textt" class="edad" value="{{$fam->edad}}"></td>
                  <td>{{$fam->emergencia}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
      </div>

      <!-- -->
      <div class="table-responsive">
            <table id="detallesA" class="table table-striped table-bordered table-condensed table-hover table-responsive" >
            <p><h2 ALIGN=center>Datos Académicos</h2></p>
              <thead style="background-color:#A9D0F5">
                <th style="width: 1%"></th>
                <th>Título</th>
                <th>Institución</th>
                <th>Duración</th>
                <th>Nivel</th>
                <th>Fecha Ingreso</th>
                <th>Fecha Salida</th>
              </thead>
              <tbody>
                @foreach($academicos as $aca)
                <tr class="filaTableA">
                  <td><input type="hidden" class="idpacademico" value="{{$aca->idpacademico}}"></td>
                  <td><input type="textt" class="titulo" value="{{$aca->titulo}}"></td>
                  <td><input type="textt" class="establecimiento" value="{{$aca->establecimiento}}"></td>
                  <td><input type="textt" class="duracion" value="{{$aca->duracion}}"></td>
                  <td>
                    <select class="form-control selectpicker">
                        <option value="{{$aca->idnivel}}">{{$aca->nivel}}</option>
                        @foreach($nivelacademico as $ac)
                        <option value="{{$ac->idnivel}}">{{$ac->nombrena}}</option>
                        @endforeach
                    </select>
                  </td>
                  <td><input type="textt" class="fingreso" value="{{$aca->fingreso}}"></td>
                  <td><input type="textt" class="fsalida" value="{{$aca->fsalida}}"></td>
                 </tr>
                 @endforeach
              </tbody>
              <thead style="background-color:#A9D0F5">
                <th></th>
                <th>Idiomas Que Maneja</th>
                <th>Nivel</th>
              </thead>
                <tfoot>
                  <th></th>
                  <th></th>
                </tfoot>
                <tbody>
                  @foreach($idiomas as $idi)
                  <tr>
                  <td></td>
                   <td>{{$idi->idioma}}</td>
                   <td>{{$idi->nivel}}</td>                
                  </tr>
                  @endforeach              
                </tbody>
            </table>
      </div>

      <div class="table-responsive">      
            <table id="detallesR" class="table table-striped table-bordered table-condensed table-hover table-responsive" >
            <p><h2 ALIGN=center>Referencia Personales Y Laborales</h2></p>
              <thead style="background-color:#A9D0F5">
                <th style="width:0%"></th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Profesión</th>
                <th>Tipo de referencia</th>
                <th>¿Lo recomiendan?</th>
                <th>Confirmado por</th>
                <th>Observació</th>
              </thead>
              <tbody>
              @foreach($referencias as $ref)
                <tr class="filaTableR">
                  <td><input type="hidden" class="idpreferencia" value="{{$ref->idpreferencia}}"></td>
                  <td><input type="textt" class="nombrer" value="{{$ref->nombrer}}"></td>
                  <td><input type="textt" class="telefonor" value="{{$ref->telefonor}}"></td>
                  <td><input type="textt" class="profesion" value="{{$ref->profesion}}"></td>
                  <td><input type="textt" class="tiporeferencia" value="{{$ref->tiporeferencia}}"></td>

                  <td><input type="textt" class="recomiendaPL" name="recomiendaPL" maxlength="2" placeholder="Si ó No" value="{{$ref->recomiendaper}}"></td>
                  <td><input type="textt" class="confirmadorref" maxlength="50" value="{{$ref->confirmadorref}}"></td>
                  <td><input type="textt" class="observacionr" maxlength="300" value="{{$ref->observacion}}"></td>                  
                </tr>
                @endforeach
              </tbody>
            </table>
      </div>

      <div class="form-group">
          <button class="btn btn-info" type="button" id="btncomentarioR" >Agregar una observación</button>
      </div>
      <div class="table-responsive">
        <table id="detalle6" class="table table-striped table-bordered table-condensed table-hover">
          <thead>
            <th>Observación</th>
          </thead>
          <tbody id="productsref" name="productsref"> 
            @foreach($observaR as $obR)
              <tr class="even gradeA">
                @if (!empty($obR->descripcion))
                  <td>{{$obR->descripcion}}</td>
                @else
                  <td></td>
                @endif
              </tr>
            @endforeach        
          </tbody>
        </table>
      </div>
      <div class="table-responsive">    
            <table id="detallesEL" class="table table-striped table-bordered table-condensed table-hover table-responsive" >
            <p><h2 ALIGN=center>Jefes inmediatos</h2></p>
              <thead style="background-color:#A9D0F5">
                <th style="width: 0%"></th>
                <th>Empresa</th>
                <th>Puesto</th>
                <th>Jefe Inmediato</th>
                <th>Teléfono</th>
                <th>Motivo Retiro</th>
                <th>Ultimo Salario</th>
                <th>Fecha Ingreso</th>
                <th>Fecha Salida</th>
                <th>¿Lo recomiendan?</th>
                <th>Confirmado por</th>
                <th>Observació</th>
              </thead>
              <tbody>
                @foreach($experiencias as $exp)
                <tr class="filaTableEL">
                  <td><input type="hidden" class="idpexperiencia" value="{{$exp->idpexperiencia}}"></td>
                  <td><input type="textt" class="empresa" value="{{$exp->empresa}}"></td>
                  <td><input type="textt" class="puesto" value="{{$exp->puesto}}"></td>
                  <td><input type="textt" class="jefeinmediato" value="{{$exp->jefeinmediato}}"></td>
                  <td><input type="textt" class="teljefeinmediato" maxlength="8" value="{{$exp->teljefeinmediato}}"></td>
                  <td><input type="textt" class="motivoretiro" value="{{$exp->motivoretiro}}"></td>
                  <td><input type="textt" class="ultimosalario" value="{{$exp->ultimosalario}}"></td>
                  <td><input type="textt" class="fingresoex" value="{{$exp->fingresoex}}"></td>
                  <td><input type="textt" class="fsalidaex" value="{{$exp->fsalidaex}}"></td>
                  <td><input type="textt" name="recomiendaP" class="recomiendaexp" maxlength="2" placeholder="Si ó No" value="{{$exp->recomiendaexp}}"></td>
                  <td><input type="textt" class="confirmadorexp" value="{{$exp->confirmadorexp}}"></td>
                  <td><input type="textt" class="observacionel" value="{{$exp->observacion}}"></td>
                 </tr>
                 @endforeach
              </tbody>
            </table>
      </div>

      <div class="form-group">
        <button class="btn btn-info" type="button" id="btncomentarioEL" >Agregar una observación</button>
      </div>
      <div class="table-responsive">
        <table id="detalle6" class="table table-striped table-bordered table-condensed table-hover">
          <thead>
            <th>Observación</th>
          </thead>
          <tbody id="productsel" name="productsel">
            @foreach($observaE as $obE) 
              <tr class="even gradeA">
                @if (!empty($obE->descripcion))
                  <td>{{$obE->descripcion}}</td>
                @else
                  <td></td>
                @endif
              </tr>
            @endforeach          
          </tbody>
        </table>
      </div>

      <div class="table-responsive">
            <table id="detallesD" class="table table-striped table-bordered table-condensed table-hover table-responsive" >
            <p><h2 ALIGN=center>Deudas</h2></p>
              <thead style="background-color:#A9D0F5">
                <th style="width: 0%"></th>
                <th>Acreedor</th>
                <th>Amortización mensual</th>
                <th>Monto crédito</th>
                <th>Motivo de crédito</th>
              </thead>
              <tbody>
                @foreach($deudas as $deu)
                <tr class="filaTableD">
                  <td><input type="hidden" class="idpdeudas" value="{{$deu->idpdeudas}}"></td>
                  <td><input type="textt" class="acreedor" value="{{$deu->acreedor}}"></td>
                  <td><input type="textt" class="pago" value="{{$deu->pago}}"></td>
                  <td><input type="textt" class="montodeuda" value="{{$deu->montodeuda}}"></td>
                  <td><input type="textt" class="motivodeuda" value="{{$deu->motivodeuda}}"></td>
                 </tr>
                 @endforeach
              </tbody>
            </table>
      </div>

      <div class="table-responsive">
            <table id="detallesPad" class="table table-striped table-bordered table-condensed table-hover table-responsive" >
            <p><h2 ALIGN=center>Padecimientos</h2></p>
              <thead style="background-color:#A9D0F5">
                <th style="width: 0.01%"></th>
                <th>Padecimientos</th>
              </thead>
              <tbody>
                @foreach($padecimientos as $pad)
                <tr class="filaTable">
                  <td><input type="hidden" class="idpad" value="{{$pad->idppadecimientos}}"></td>
                  <td><input type="textt" class="nombrepa" value="{{$pad->nombre}}"></td>
                </tr>
                 @endforeach
              </tbody>
            </table>
      </div>

      <div class="table-responsive">
        <table id="detalles" class="table table-striped table-bordered table-condensed table-hover table-responsive" >
          <p><h2 ALIGN=center>Experiencia en el extranjero</h2></p>
            <thead style="background-color:#A9D0F5">
              <th>Nombre</th>
              <th>Forma en la que trabajo</th>
              <th>Motivo de finalizacion</th>
              <th>País</th>
            </thead>
     
            <tfoot>
              <th></th>
            </tfoot>
            <tbody>
              @foreach($pais as $pas)
                <tr>
                  <td>{{$pas->trabajoext}}</td>
                  <td>{{$pas->forma}}</td>
                  <td>{{$pas->motivofin}}</td>
                  <td>{{$pas->nombre}}</td>
                </tr>
              @endforeach
            </tbody>
        </table>
      </div>

      <div class="table-responsive">
        <table id="detalles" class="table table-striped table-bordered table-condensed table-hover table-responsive" >
          <p><h2 ALIGN=center>Pariente Político</h2></p>
            <thead style="background-color:#A9D0F5">
              <th>Nombre</th>
              <th>Puesto</th>
              <th>Dependencia</th>
            </thead>
            <tfoot>
              <th></th>
            </tfoot>
            <tbody>
              @foreach($pariente as $par)
                <tr>
                  <td>{{$par->nombre}}</td>
                  <td>{{$par->puesto}}</td>
                  <td>{{$par->dependencia}}</td>
                </tr>
              @endforeach
            </tbody>
        </table>
      </div>

      <div class="table-responsive">
        <table id="" class="table table-striped table-bordered table-condensed table-hover table-responsive" >
          <p><h2 ALIGN=center>Licencias de conducir</h2></p>
            <thead style="background-color:#A9D0F5">
              <th style="width: 15%">Licencia</th>
              <th>Vigencia</th>
            </thead>
            <tbody>
              @foreach($licencias as $lic)
                <tr>
                  <td>{{$lic->tipolicencia}}</td>
                  <td>{{$lic->vigencia}}</td>
                </tr>
              @endforeach
            </tbody>
        </table>
      </div>

    </div>
</form>
</div>
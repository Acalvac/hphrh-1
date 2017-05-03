@extends ('layouts.index')
@section ('contenido')

<div class="row">
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <div class="form-group">
      <label for="nombre">Solicitante</label>
      <p>{{$persona->nombre1.' '.$persona->nombre2.' '.$persona->apellido1.' '.$persona->apellido2}}</p>
    </div>
  </div>
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <div class="form-group">
      <label for="serie_comprobante">Identificacion</label>
      <p>{{$empleado->identificacion}}</p>
    </div>
  </div>
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <div class="form-group">
    <label for="serie_comprobante">Nit</label>
      <p>{{$empleado->nit}}</p>
    </div>
  </div>
</div>

<div class="row">

  <div class="table-responsive">
  
        <table id="detalles" class="table table-striped table-bordered table-condensed table-hover table-responsive" >
        <p><h2 ALIGN=center>Datos Personales</h2></p>
          <thead style="background-color:#A9D0F5">
            <th>Direccion </th>
            <th>Telefono</th>
            <th>Fecha Nacimiento</th>
            <th>Departamento</th>
            <th>Municipio</th>
            <th>Estado Civil</th>
            <th>Afiliado</th>
            <th>Puesto Aplicar</th>
            <th>IGSS</th>

            <th>Dependientes</th>
            <th>Aporte Mensual</th>
            <th>Vivienda</th>
            <th>Alquiler Mensual</th>
            <th>Otros Ingresos</th>
            <th>Pretension</th>
            <th>Fecha Solicitud</th>
          </thead>
 
          <tfoot>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tfoot>
          <tbody>
            <tr>
           

            @if($persona->avenida != '' and $persona->calle =='')
              <td>              
                 {{'av'.' '.$persona->avenida.' '.$persona->nomenclatura.' '.'Zona'.' '.$persona->zona.' '.$persona->barriocolonia}}              
              </td>
            @endif

            @if($persona->calle != '' and $persona->avenida == '')
              <td>              
                 {{'calle'.' '.$persona->calle.' '.$persona->nomenclatura.' '.'Zona'.' '.$persona->zona.' '.$persona->barriocolonia}}              
              </td>
            @endif

            @if($persona->calle != '' and $persona->avenida != '')
              <td>              
                 {{'calle'.' '.$persona->calle.' '.'av'.' '.$persona->avenida.' '.$persona->nomenclatura.' '.'Zona'.' '.$persona->zona.' '.$persona->barriocolonia}}              
              </td>
            @endif
 

            @if($persona->calle == '' and $persona->avenida == '' and $persona->zona == '' and $persona->nomenclatura == '' and $persona->barriocolonia != '')
              <td>              
                 {{$persona->barriocolonia}}              
              </td>
            @endif


              <td>{{$persona->telefono}}</td>
              <td>{{$persona->fechanac}}</td>
              <td>{{$persona->departamento}}</td>
              <td>{{$persona->municipio}}</td>
              <td>{{$empleado->estadocivil}}</td>
              <td>{{$persona->afiliado}}</td>
              <td>{{$persona->puesto}}</td>
              <td>{{$empleado->afiliacionigss}}</td>

              <td>{{$empleado->numerodependientes}}</td>
              <td>{{$empleado->aportemensual}}</td>
              <td>{{$empleado->vivienda}}</td>
              <td>{{$empleado->alquilermensual}}</td>
              <td>{{$empleado->otrosingresos}}</td>
              <td>{{$empleado->pretension}}</td>
              <td>{{$empleado->fechasolicitud}}</td>
            </tr>
          </tbody>
        </table>
  </div>
  
  <div class="table-responsive">  
        <table id="detalles" class="table table-striped table-bordered table-condensed table-hover table-responsive" >
        <p><h2 ALIGN=center>Datos Familiares</h2></p>
          <thead style="background-color:#A9D0F5">
            <th>Nombre</th>
            <th>Parentezco</th>
            <th>Telefono</th>
            <th>Ocupacion</th>
            <th>Edad</th>
          </thead>
 
          <tfoot>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tfoot>
          <tbody>
          @foreach($familiares as $fam)
            <tr>
              <td>{{$fam->nombref}}</td>
              <td>{{$fam->parentezco}}</td>
              <td>{{$fam->telefonof}}</td>
              <td>{{$fam->ocupacion}}</td>
              <td>{{$fam->edad}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
  </div>
        <!-- -->
  <div class="table-responsive">
        <table id="detalles" class="table table-striped table-bordered table-condensed table-hover table-responsive" >
        <p><h2 ALIGN=center>Datos Academicos</h2></p>
          <thead style="background-color:#A9D0F5">
            <th>Titulo</th>
            <th>Institucion</th>
            <th>Duracion</th>
            <th>Nivel</th>
            <th>Fecha Ingreso</th>
            <th>Fecha Salida</th>
          </thead>
 
          <tfoot>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tfoot>
          <tbody>
            @foreach($academicos as $aca)
            <tr>
              <td>{{$aca->titulo}}</td>
              <td>{{$aca->establecimiento}}</td>
              <td>{{$aca->duracion}}</td>
              <td>{{$aca->nivel}}</td>
              <td>{{$aca->fingreso}}</td>
              <td>{{$aca->fsalida}}</td>
             </tr>
             @endforeach
          </tbody>
          <thead style="background-color:#A9D0F5">
            <th>Idiomas Que Maneja</th>
            <th>Nivel</th>
            <tfoot>
              <th></th>
              <th></th>
            </tfoot>
            <tbody>
              @foreach($idiomas as $idi)
              <tr>
               <td>{{$idi->idioma}}</td>
               <td>{{$idi->nivel}}</td>                
              </tr>
              @endforeach              
            </tbody>
          </thead>
        </table>
  </div>
  <div class="table-responsive">      
        <table id="detalles" class="table table-striped table-bordered table-condensed table-hover table-responsive" >
        <p><h2 ALIGN=center>Referencia Personales Y Laborales</h2></p>
          <thead style="background-color:#A9D0F5">
            <th>Nombre</th>
            <th>Telefono</th>
            <th>Profesion</th>
            <th>tiporeferencia</th>
          </thead>
 
          <tfoot>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tfoot>
          <tbody>
          @foreach($referencias as $ref)
            <tr>
              <td>{{$ref->nombrer}}</td>
              <td>{{$ref->telefonor}}</td>
              <td>{{$ref->profesion}}</td>
              <td>{{$ref->tiporeferencia}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
  </div>
  <div class="table-responsive">    
        <table id="detalles" class="table table-striped table-bordered table-condensed table-hover table-responsive" >
        <p><h2 ALIGN=center>Experiencia Laboral</h2></p>
          <thead style="background-color:#A9D0F5">
            <th>Empresa</th>
            <th>Puesto</th>
            <th>Jefe Inmediato</th>
            <th>Motivo Retiro</th>
            <th>Ultimo Salario</th>
            <th>Fecha Ingreso</th>
            <th>Fecha Salida</th>
          </thead>
 
          <tfoot>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tfoot>
          <tbody>
            @foreach($experiencias as $exp)
            <tr>
              <td>{{$exp->empresa}}</td>
              <td>{{$exp->puesto}}</td>
              <td>{{$exp->jefeinmediato}}</td>
              <td>{{$exp->motivoretiro}}</td>
              <td>{{$exp->ultimosalario}}</td>
              <td>{{$exp->fingresoex}}</td>
              <td>{{$exp->fsalidaex}}</td>
             </tr>
             @endforeach
          </tbody>
        </table>
  </div>
  <div class="table-responsive">
        <table id="detalles" class="table table-striped table-bordered table-condensed table-hover table-responsive" >
        <p><h2 ALIGN=center>Deudas</h2></p>
          <thead style="background-color:#A9D0F5">
            <th>Acreedor</th>
            <th>amortizacion mensual</th>
            <th>Monto Deuda</th>
          </thead>
 
          <tfoot>
            <th></th>
            <th></th>
          </tfoot>
          <tbody>
            @foreach($deudas as $deu)
            <tr>
              <td>{{$deu->acreedor}}</td>
              <td>{{$deu->pago}}</td>
              <td>{{$deu->montodeuda}}</td>
             </tr>
             @endforeach
          </tbody>
        </table>
  </div>
  <div class="table-responsive">
        <table id="detalles" class="table table-striped table-bordered table-condensed table-hover table-responsive" >
        <p><h2 ALIGN=center>Padecimeintos</h2></p>
          <thead style="background-color:#A9D0F5">
            <th>Padecimientos</th>
          </thead>
 
          <tfoot>
            <th></th>
          </tfoot>
          <tbody>
            @foreach($padecimientos as $pad)
            <tr>
              <td>{{$pad->nombre}}</td>
             </tr>
             @endforeach
          </tbody>
        </table>
  </div>   
</div>
@endsection

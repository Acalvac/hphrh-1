<!DOCTYPE html>
<html>
<head>
	<title>Descarga Solicitante</title>
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/responsive.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/core.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="content-page">
		<div class="content">
        	<div class="container">
        		<div class="row">
        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        				<div class="form-group">
          					<div class="col-md-2 col-md-12 col-sm-12 col-xs-12">
            					<img src="https://unsplash.imgix.net/photo-1422513391413-ddd4f2ce3340?w=1024&amp;q=50&amp;fm=jpg&amp;s=282e5978de17d6cd2280888d16f06f04" width="75" height="50">
          					</div>
          					<div class="col-md-10 col-md-12 col-sm-12 col-xs-12">
            					<h2 class="text-center">SOLICITUD DE EMPLEO</h2>
            					<h4 class="text-center">Afiliado: {{$persona->afiliado}}</h4>
            					<h4 class="text-center">Puesto aplicar: {{$persona->puesto}}</h4>
            				</div>
          				</div>
        			</div>
    			</div>	
   	
    			<div class="row">
        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            			<h3>Datos personales</h3>
	 					<table width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="border-collapse:collapse;border-color:#ddd;">
	 						<tbody>
								<tr>
								<th>Nombre</th>
									@if($persona->nombre3 == '')
										<td colspan="3">{{$persona->nombre1.' '.$persona->nombre2.' '.$persona->apellido1.' '.$persona->apellido2}}</td>
									@else
										<td colspan="3">{{$persona->nombre1.' '.$persona->nombre2.' '.$persona->nombre3.' '.$persona->apellido1.' '.$persona->apellido2}}</td>
									@endif
								</tr>

								<tr><th>Direccion</th>
									@if($persona->avenida != '' and $persona->calle =='')
              							<td colspan="3">              
                 							{{'av'.' '.$persona->avenida.' '.$persona->nomenclatura.' '.'Zona'.' '.$persona->zona.' '.$persona->barriocolonia}}              
              							</td>
            						@endif

            						@if($persona->calle != '' and $persona->avenida == '')
              							<td colspan="3">              
                 							{{'calle'.' '.$persona->calle.' '.$persona->nomenclatura.' '.'Zona'.' '.$persona->zona.' '.$persona->barriocolonia}}              
              							</td>
            						@endif

            						@if($persona->calle != '' and $persona->avenida != '')
              							<td colspan="3">              
                 							{{'calle'.' '.$persona->calle.' '.'av'.' '.$persona->avenida.' '.$persona->nomenclatura.' '.'Zona'.' '.$persona->zona.' '.$persona->barriocolonia}}              
              							</td>
            						@endif
 

            						@if($persona->calle == '' and $persona->avenida == '' and $persona->zona == '' and $persona->nomenclatura == '' and $persona->barriocolonia != '')
              							<td colspan="3">              
                 							{{$persona->barriocolonia}}              
              							</td>
            						@endif
            					</tr>
								<tr>
									<th>No. de Dpi</th>	<td>{{$empleado->identificacion}}</td>
									<th>Nit</th><td>{{$empleado->nit}}</td>
								</tr>

								<tr>
									<th>Telefono</th><td>{{$persona->telefono}}</td>
									<th>Movil</th><td>{{$persona->celular}}</td>
								</tr>
								<tr>
                <!--Año/mes/día-->
									<th>No.de Afiliacion al IGGS</th><td>{{$empleado->afiliacionigss}}</td>
									<th>Edad</th><td>
                  {{$fnac }}</td>
									
								</tr>

								<tr>
									<th>Fecha de nacimiento</th><td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $persona->fechanac)->format('d-m-Y')}}</td>
									<th>Estado civil</th><td>{{$empleado->estadocivil}}</td>
								</tr>
								<tr>
									<th>Pretensión salarial</th><td>Q {{$empleado->pretension}}.00</td>
									<th>Fecha solicitud</th><td>{{ \Carbon\Carbon::createFromFormat('Y-m-d',$empleado->fechasolicitud)->format('d-m-Y')}}</td>
								</tr>
								<tr>
									<th>Departamento</th><td>{{$persona->departamento}}</td>
									<th>Municipio</th><td>{{$persona->municipio}}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
    
    			<div class="row">
        			<div class="col-md-12">
        				<h3>Datos familiares</h3>
            			<table width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="border-collapse:collapse;border-color:#ddd;">
             				<thead>
                			<tr>
                				<th>Nombre</th>
                  				<th>Parentezco</th>
                  				<th>Telefono</th>
                  				<th>Ocupacion</th>
                  				<th>Edad</th>
                  				<th>Emergencia</th>
                			</tr>
              				</thead>
              				<tbody>
              				@foreach($familiares as $fam)
            				<tr>
              					<td>{{$fam->nombref}}</td>
              					<td>{{$fam->parentezco}}</td>
              					<td>{{$fam->telefonof}}</td>
              					<td>{{$fam->ocupacion}}</td>
              					<td>{{$fam->edad}}</td>
              					<td>{{$fam->emergencia}}</td>
            				</tr>
            				@endforeach
          	   				</tbody>
             
            			</table>
         			</div>
    			</div>
		
    			<div class="row">
		        	<div class="col-md-12">
		            	<h3>Datos Academicos</h3>
		            	<table width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="border-collapse:collapse;border-color:#ddd;">
		            		<thead>
		                		<tr>
		                  			<th>Nivel</th>
		                  			<th>Titulo/Diploma</th>
		                  			<th>Establecimiento</th>
		                  			<th>Duración</th>
		                  			<th>Fecha ingreso</th>
		                  			<th>Fecha salida</th>
		                		</tr>
		              		</thead>
		              		<tbody>
		            		@foreach($academicos as $aca)
		            		<tr>
		            			<td>{{$aca->nivel}}</td>
		              			<td>{{$aca->titulo}}</td>
		              			<td>{{$aca->establecimiento}}</td>
		              			<td>{{$aca->duracion}}</td>
		              			<td>{{ \Carbon\Carbon::createFromFormat('Y-m-d',$aca->fingreso)->format('d-m-Y')}}</td>
		              			<td>{{ \Carbon\Carbon::createFromFormat('Y-m-d',$aca->fsalida)->format('d-m-Y')}}</td>
		             		</tr>
		            		@endforeach
		          			</tbody>
		            	</table>
		        	</div>
    			</div> 
   
    			<div class="row">
        			<div class="col-md-12">
          				<h3>Experiencia Laboral</h3>
          				<table width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="border-collapse:collapse;border-color:#ddd;">
          					<thead>
              					<tr>
                					<th>Empresa</th>
                					<th>Puesto</th>
                					<th>Jefe inmediato</th>
                					<th>Motivo retiro</th>
                					<th>Ultimo salario</th>
                					<th>Fecha ingreso</th>
                					<th>Fecha salida</th>
              					</tr>
            				</thead>
            				<tbody>
            					@foreach($experiencias as $exp)
            					<tr>
              						<td>{{$exp->empresa}}</td>
              						<td>{{$exp->puesto}}</td>
              						<td>{{$exp->jefeinmediato}}</td>
              						<td>{{$exp->motivoretiro}}</td>
              						<td>Q. {{$exp->ultimosalario}}</td>
              						<td>{{$exp->fingresoex}}</td>
              						<td>{{$exp->fsalidaex}}</td>
             					</tr>
             					@endforeach
          					</tbody>
          				</table>
        			</div>
    			</div>    
    
    			<div class="row">
        			<div class="col-md-12">
            			<h3>Referencia Personal y Laboral</h3>
            			<table width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="border-collapse:collapse;border-color:#ddd;">
            				<thead>
                				<tr>
                  					<th>Nombre</th>
                  					<th>Telefono</th>
                  					<th>Profesion</th>
                  					<th>Tipo referencia</th>
                				</tr>
              				</thead>
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
    			</div>
  
    			<div class="row">
       				<div class="col-md-6">
        				<h3>Deudas</h3>
            			<table width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="border-collapse:collapse;border-color:#ddd;">
                			<thead>
                				<tr>
                    				<th>Acreedor</th>
                    				<th>Amortizacion mensual</th>
                    				<th>Monto</th>
                  				</tr>
                			</thead>
                			<tbody>
            					@foreach($deudas as $deu)
            					<tr>
              						<td>{{$deu->acreedor}}</td>
              						<td>Q {{$deu->pago}}</td>
              						<td>Q {{$deu->montodeuda}}</td>
             					</tr>
            					@endforeach
          					</tbody>
            			</table>
        			</div>
        			<div class="col-md-6">
            			<h3>Padecimientos</h3>
            			<table width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="border-collapse:collapse;border-color:#ddd;">
            				<thead>
            					<tr>
            					<th>Padecimientos</th>
            					</tr>
          					</thead>
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
   			</div>
    	</div>

    	<footer class="footer text-right">
    		Habitat para la humanidad
        	{{$factual}} by:solera
        	<br>
    		<strong>Copyright &copy; <a href="www.solera.com">Solera</a>.</strong> All rights reserved.
    	</footer>
	</div>

    <!--  -->
	<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
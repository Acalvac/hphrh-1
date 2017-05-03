@extends ('layouts.index')
@section('estilos')
    @parent
 
        <link href="{{asset('assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" />

        <link href="{{asset('assets/plugins/timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/plugins/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet">
        <link href="{{asset('assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.standalone.css')}}" rel="stylesheet">
        <link href="{{asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">

        <link href="{{asset('assets/plugins/switchery/switchery.min.css')}}" rel="stylesheet" />
   

@endsection

@section ('contenido')
<div class="card-box">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Solictud de permiso</h3>
		@if (count($errors)>0)
			<div class="alert alert-danger">
            <ul>
				@foreach ($errors->all() as $error)
				<li>{{$error}}</li>
				@endforeach
			</ul>
			</div>
		@endif
       </div>
    </div>
</div>

<div class="text-success" id='result'>
    @if(Session::has('message'))
        {{Session::get('message')}}
    @endif
</div>

<div id='message-error' class="alert alert-danger danger" role='alert' style="display: none">
      <strong id="error"></strong>
</div>
        
{!!Form::open(array('url'=>'empleado/permiso','method'=>'POST','autocomplete'=>'off','id'=>'form')) !!}
{{Form::token()}}

<div class="card-box">
    <div class="row">
        
        <input type="hidden" name="idempleado" value="{{$usuarios->idempleado}}">
        <input type="hidden" name="idmunicipio" value="{{$usuarios->idmunicipio}}">
      

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label>Motivo ausencia</label>
                <select name="idtipoausencia" id="idtipoausencia" class="form-control selectpicker" data-live-search="true">
                    @foreach($tausencia as $tau)
                        <option value="{{$tau->idtipoausencia}}">{{$tau->ausencia}}</option>
                    @endforeach
                </select>
            </div>
            </div> 
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label>Juzgado o Institución</label>
                <input type="text" name="juzgadoinstitucion" id="Jusgado" class="form-control" placeholder="">                
            </div>
            </div>             
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="nombre">Tipo caso</label>
                <input type="text" name="tipocaso" class="form-control" placeholder="" id="tipocaso">                
            </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="control-label">Fecha inicio</label>
                    <div class="input-group">
                        <input type="text" id="fechaini" class="form-control" name="fini">
                        <span class="input-group-addon bg-primary b-0 text-white"><i class="ion-calendar"></i></span>
                    </div>
                    <div class="text-danger" id="error_fechaini">{{$errors->formulario->first('fechainicio')}}</div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="control-label">Fecha final</label>
                    <div class="input-group">
                        <input type="text" id="fechafin" class="form-control" name="ffin">
                        <span class="input-group-addon bg-primary b-0 text-white"><i class="ion-calendar"></i></span>
                    </div>
                    <div class="text-danger" id="error_fechafin">{{$errors->formulario->first('fechafin')}}</div>
                </div>
            </div>  
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                <div><label>Concurrencia</label></div>
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12"> 
                    <select name="concurrencia" class="form-control" id="concurrencia">
                    <option value="No">No</option>
                    <option value="Si">Si</option>
                    </select>
                </div>
            </div>


            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                <div><label for="horainicio">Hora inicio</label></div>
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <select name="horainicio" id="hinicio" class="form-control">
                        <option value="00">00</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                    </select>
                </div>
            </div>

           
            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                <div><label>Minutos inicio</label></div>               
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12"> 
                    <select name="mini" class="form-control" id="mini">
                        <option value="00">00</option>
                        <option value="15">15</option>
                        <option value="30">30</option>
                        <option value="45">45</option>
                    </select>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                <div><label for="horainicio">Hora fin</label></div>
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <select name="horafin" id="hfin" class="form-control" >
                        <option value="00">00</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                    </select>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                <div>
                <label>Minutos finales</label>
                </div>
                <div class="col-lg-8 col-md-3 col-sm-3 col-xs-12">
                    <select name="mfin" class="form-control" id="mfin">
                        <option value="00">00</option>
                        <option value="15">15</option>
                        <option value="30">30</option>
                        <option value="45">45</option>
                    </select>
               </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label>Observaciones</label>
                <textarea class="form-control" placeholder=".........." rows="3"></textarea>
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
    </div>
</div>    
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="form-group">
        <button class="btn btn-info" id="btnguardar" type="submit">Guardar</button>
        <button class="btn btn-danger" type="reset">Cancelar</button>
    </div>
</div>  
           
{!!Form::close()!!}		
            

@endsection

@section('fin')
    @parent
       
        <script src="{{asset('assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
       
        <script src="{{asset('assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js')}}" type="text/javascript"></script>

        <script src="{{asset('assets/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
        <script src="{{asset('assets/plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js')}}"></script>       
        <!--<script src="{{asset('assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>-->   
        <script src="{{asset('assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
       
        <script src="{{asset('assets/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/plugins/moment/moment.js')}}"></script>
        <script src="{{asset('assets/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
        <script src="{{asset('assets/plugins/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
     
        <script src="{{asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
        <script src="{{asset('assets/js/fecha.js')}}"></script>
        <script src="{{asset('assets/plugins/bootstrap-datepicker/dist/js/conversion.js')}}"></script>
        <meta name="_token" content="{!! csrf_token() !!}" />


        <script>

        $(function(){
            $("#form").submit(function(e){

                var fields = $(this).serialize();

                $.post("{{url('empleado/permiso')}}", fields, function(data){

                    if(data.valid !== undefined){
                        $("#result").html("En hora buena formulario enviado correctamente");
                        
                        $("#form")[0].reset();
                        $("#error_fechaini").html('');
                        $("#error_fechafin").html('');
                    }
                    else{
                        $("#error_fechaini").html('');
                        $("#error_fechafin").html('');
                        if (data.fini !== undefined){
                            $("#error_fechaini").html(data.fini); 
                        }
                        if (data.ffin !== undefined){
                            $("#error_fechafin").html(data.ffin);
                        }
                    }
                    var errHTML="";
                 
                

                    if(typeof data.error != 'undefined')
                    {
                        for(e in data.error){
                            errHTML+=data.error[e];
                            //$("#result").html("la fecha inicio no puede ser mayor a la fecha final");
                    }
                    
                    $("#erroresContent").html(errHTML);
                    $('#erroresModal').modal('show');
                }
                      
                });

                return false;
            });
        });        
        </script>



@endsection

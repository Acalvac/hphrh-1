function irarriba(){
$('html, body').animate({scrollTop:0}, 300);
}
    
    $(document).on("submit",".formarchivo",function(e){
       
        e.preventDefault();
        var formu=$(this);
        var nombreform=$(this).attr("id");
        
        var rs=false;
      
        if(nombreform=="f_subir_imagen" ){ var miurl="updatefoto";  var divresul="notificacion_resul_fci";   }

        var formData = new FormData($("#"+nombreform+"")[0]);       

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });            
        
        $.ajax({
            url: miurl,
            type: 'POST',
            //dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,

            beforeSend: function(){
              $("#"+divresul+"").html($("#cargador_empresa").html());                
            },
            //una vez finalizado correctamente
            success: function(data){  
              $("#"+divresul+"").html(data);
              //$('#fotografia_usuario').removeAttr('src');
              //$('#fotografia_usuario').attr('src',"{{asset('fotografias/'.Auth::user()->fotoperfil)}}");
             // {{asset('fotografias/'.Auth::user()->fotoperfil)}}
              $("#fotografia_usuario").attr('src', $("#fotografia_usuario").attr('src') + '?' + Math.random() ,true );
              $("#fotografiaus").attr('src', $("#fotografiaus").attr('src') + '?' + Math.random() ,true );  
              //
            
            },
            //si ha ocurrido un error
            error: function(data){
               alert("ha ocurrido un error") ;
                
            }
        });
        irarriba();
    });

    function cargarlistado(listado){
        $("#profile").html($("#cargador_empresa").html());
        if(listado==1){var url = "galeria";}
        $.get(url,function(resul){
            $("#profile").html(resul);
        })
    }
    
    


    /*
    $("#btnfoto").click(function(){
        ///$("input[name='file']").on("change", function(){
        var id = $("#id").val();
        var f = $("#imagen").val();
        alert(f);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
    
        var formData = {
            fotoperfil: $("#imagen").val()
        };
        var route = "updatefoto";
        var my_url = route += '/' + id;
        $.ajax({
            url: my_url,
            type: 'PUT',
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,

            success: function(data){
               
                console.log(data.fotoperfil);
            }
        });
    });
    */





$(document).ready(function(){
   	$('#btnagregarF').click(function(){
    	$('#inputTitleF').html("Agregar informacion familiar");
    	$('#formAgregarF').trigger("reset");
    	$('#formModalF').modal('show');
	});


    $("#btnGuardarF").click(function(e){
        var miurl="agregarfamiliar";

        nombref =  $("#nombref").val();
        apellidof =  $("#apellidof").val();

        var formData = {
            nombre: $("#nombref").val(),
            apellido: $("#apellidof").val(),
            parentezco: $("#parentezco").val(),           
            edad: $("#edad").val(),
            ocupacion : $("#ocupacion").val(),
            idempleado: $("#idempleado").val(),
            identificacion: $("#identificacion").val(),
            emergencia :$("#emergencia").val(),
            telefonof: $("#telefonof").val(),

        };
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: miurl,
            data: formData,
            dataType: 'json',

            success: function (data) {
                document.getElementById("dataTablefamilia").innerHTML += "<tr class='fila'><td>" +data.parentezco+ "</td><td>" +nombref + " " + apellidof + "</td><td>" +data.ocupacion + "</td><td>" +data.edad + "</td><td>" +data.telefonof + "</td><td>" +data.emergencia + "</td></tr>";
       

                $('#formModalF').modal('hide');

                //$('#tabla').load("#dataTableItems");

                //cargaracademico(1,1);
                
            },
            error: function (data) {
                $('#loading').modal('hide');
                var errHTML="";
                if((typeof data.responseJSON != 'undefined')){
                    for( var er in data.responseJSON){
                        errHTML+="<li>"+data.responseJSON[er]+"</li>";
                    }
                }else{
                    errHTML+='<li>Error al borrar el &aacute;rea de atenci&oacute;n.</li>';
                }
                $("#erroresContentF").html(errHTML); 
                $('#erroresModalF').modal('show');
            }
        });
    });

});

function cargarfamilia(listado){
    
    $("#familiares").html($("#cargador_empresa").html());
    if(listado==1){var url = "listarfamilia";}
    $.get(url,function(resul){
    $("#familiares").html(resul);
    });
    
}
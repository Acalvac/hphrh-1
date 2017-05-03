function cargaracademico(listado){
	$("#academicos").html($("#cargador_empresa").html());
    if(listado==1){var url = "listaracademico";}
    $.get(url,function(resul){
    $("#academicos").html(resul);
    });
}

$(document).ready(function(){
   	$('#btnAgregar').click(function(){
    	$('#inputTitle').html("Agregar informacion academico");
    	$('#formAgregar').trigger("reset");
    	$('#formModal').modal('show');
	});

 $("#iddepartamento1").change(event => {
    $.get(`towns/${event.target.value}`, function(res, sta){
        $("#pidmunicipio").empty();
            res.forEach(element => {
                $("#pidmunicipio").append(`<option value=${element.idmunicipio}> ${element.nombre} </option>`);
            });
        });
    });

    $("#btnGuardar").click(function(e){
        var miurl="agregaracademico";
        nivel=$("#idnivel option:selected").text();
        fingreso = $("#fecha_ingreso").val();
        fsalida = $("#fecha_salida").val();

        var formData = {
            titulo: $("#titulo").val(),
            establecimiento: $("#establecimiento").val(),
            duracion: $("#duracion").val(),           
            fecha_ingreso: $("#fecha_ingreso").val(),
            fecha_salida : $("#fecha_salida").val(),
            idmunicipio: $("#pidmunicipio").val(),
            idempleado: $("#idempleado").val(),
            identificacion: $("#identificacion").val(),
            idnivel: $("#idnivel").val(),
            periodo: $("#periodo").val(),
        


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
                document.getElementById("dataTableItems").innerHTML += "<tr class='fila'><td>" +data.titulo+ "</td><td>" +data.establecimiento + "</td><td>" +data.duracion + ": " + data.periodo + "</td><td>" +nivel + "</td><td>" +fingreso + "</td><td>" +fsalida + "</td></tr>";
    
                $('#formModal').modal('hide');
                
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
                $("#erroresContent").html(errHTML); 
                $('#erroresModal').modal('show');
            }
        });
    });
});

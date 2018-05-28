var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

		$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});

	$.post("../ajax/detalle_tarjeta.php?op=listarART", function(r){
	            $("#art_codigo").html(r);
	            $('#art_codigo').selectpicker('refresh');
	});


	$.post("../ajax/detalle_tarjeta.php?op=listarMP", function(r){
	            $("#codpro").html(r);
	            $('#codpro').selectpicker('refresh');
	});




	
}

//Función limpiar
function limpiar()
{
	$("#idcotizacion").val("");
	$("#idarticulo").val("");
	$("#cantidad").val("");
	$("#precio_cotizacion").val("");
	$("#descuento").val("");
	$("#iddetalle_cotizacion").val("");
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}


//Función Listar
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/detalle_tarjeta.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 20,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}

//Función para guardar o editar
function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/detalle_tarjeta.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}


function mostrar(idtarjeta)
{
	$.post("../ajax/detalle_tarjeta.php?op=mostrar",{idtarjeta : idtarjeta}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#art_codigo").val(data.art_codigo);
		$('#art_codigo').selectpicker('refresh');

		$("#codpro").val(data.codpro);
		$('#codpro').selectpicker('refresh');

		$("#cantidad").val(data.cantidad);

		
		$("#idtarjeta").val(data.idtarjeta);
 		

 	})
}

//Función para eliminar registros
function eliminar(idtarjeta)
{
	bootbox.confirm("¿Está Seguro de eliminar el item?", function(result){
		if(result)
        {
        	$.post("../ajax/detalle_tarjeta.php?op=eliminar", {idtarjeta : idtarjeta}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}


init();
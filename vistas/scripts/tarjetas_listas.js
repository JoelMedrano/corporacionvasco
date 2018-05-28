var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});

}


//Función para anular registros
function revisar(idtarjeta)
{
	bootbox.confirm("¿Está Seguro de cambiar a revisar la tarjeta?", function(result){
		if(result)
        {
        	$.post("../ajax/tb_tarjetacab.php?op=revisar", {idtarjeta : idtarjeta}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}


//Función para anular registros
function aprobar(idtarjeta)
{
	bootbox.confirm("¿Está Seguro de Aprobar la tarjeta?", function(result){
		if(result)
        {
        	$.post("../ajax/tb_tarjetacab.php?op=aprobar", {idtarjeta : idtarjeta}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}


//Función para anular registros
function editarTarjeta(idarticulo)
{
	bootbox.confirm("¿Está Seguro de editar la Tarjeta?", function(result){
		if(result)
        {
        	$.post("../ajax/tarjetav2.php?op=editarTarjeta", {idarticulo : idarticulo}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para anular registros
function desactivarTarjeta(idarticulo)
{
	bootbox.confirm("¿Está Seguro de desactivar la Tarjeta?", function(result){
		if(result)
        {
        	$.post("../ajax/tarjetav2.php?op=desactivarTarjeta", {idarticulo : idarticulo}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función limpiar
function limpiar()
{
	$("#idarticulo").val("");
	$("#articulo").val("");
	$('#idarticulo').selectpicker('refresh');
	$("#total_cotizacion").val("");
	$(".filas").remove();
	$("#total").html("0");

	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_creacion').val(today);

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
		listarArticulos();

		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").show();
		detalles=0;
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
					url: '../ajax/tb_tarjetacab.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 0, "asc" ]]//Ordenar (columna,orden)
	}).DataTable();
}


//Función ListarArticulos
function listarArticulos()
{
	tabla=$('#tblarticulos').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            
		        ],
		"ajax":
				{
					url: '../ajax/tb_tarjetacab.php?op=listarMPTarjeta',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/tb_tarjetacab.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarform(false);
	          listar();
	    }

	});
	limpiar();
}

function mostrar(idtarjeta)
{
	$.post("../ajax/tb_tarjetacab.php?op=mostrar",{idtarjeta : idtarjeta}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#art_codigo").val(data.art_codigo);
		$("#art_modelo").val(data.art_modelo);
		$("#art_nombre").val(data.art_nombre);
		$("#col_nombre").val(data.col_nombre);
		$("#art_nom_talla").val(data.art_nom_talla);
		$("#art_marca").val(data.art_marca);
		$("#art_estado").val(data.art_estado);
		$("#login").val(data.login);
		$("#estado").val(data.estado);
		$("#total").val(data.total);

		$("#fecha_creacion").val(data.fecha);
		$("#idtarjeta").val(data.idtarjeta);

			//Ocultar y mostrar los botones
			$("#btnGuardar").hide();
			$("#btnCancelar").show();
			$("#btnAgregarArt").hide();
 	});

 	$.post("../ajax/tb_tarjetacab.php?op=listarDetalle&id="+idtarjeta,function(r){
	        $("#detalles").html(r);
	});	
}



  

init();
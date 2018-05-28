var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})
}

//Función limpiar
function limpiar()
{
		$("#art_codigo").val("");
		$("#art_marca").val("");
		$("#art_nombre").val("");
		$("#col_nombre").val("");
		$("#art_nom_talla").val("");
		$("#pretot").val("");
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
					url: '../ajax/tarjetav.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 20,//Paginación
	    "order": [[ 0, "asc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/tarjetav.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarform(false);
	          $("#tbllistado").dataTable().api().ajax.reload();
	    }

	});
	limpiar();
}

function mostrar(idarticulo)
{
	$.post("../ajax/tarjetav.php?op=mostrar",{idarticulo : idarticulo}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#idarticulo").val(data.idarticulo);
		$("#art_codigo").val(data.art_codigo);
		$("#art_marca").val(data.art_marca);
		$("#art_nombre").val(data.art_nombre);
		$("#col_nombre").val(data.col_nombre);
		$("#art_nom_talla").val(data.art_nom_talla);
		$("#pretot").val(data.pretot);

		//Ocultar y mostrar los botones
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").hide();		

 	});

 	$.post("../ajax/tarjetav.php?op=listarDetalle&id="+idarticulo,function(r){
	        $("#detalles").html(r);
	});	 	
}

//Función para desactivar registros
function desactivar(art_codigo)
{
	bootbox.confirm("¿Está Seguro de desactivar el detalle?", function(result){
		if(result)
        {
        	$.post("../ajax/tarjetav.php?op=desactivar", {art_codigo : art_codigo}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(art_codigo)
{
	bootbox.confirm("¿Está Seguro de activar el Detalle?", function(result){
		if(result)
        {
        	$.post("../ajax/tarjetav.php?op=activar", {art_codigo : art_codigo}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}


init();
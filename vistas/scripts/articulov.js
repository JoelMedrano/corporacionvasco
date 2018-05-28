var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})



    //cargamos los items al select articulos
    $.post("../ajax/articulov.php?op=selectColor", function(r){
                $("#art_color").html(r);
                $('#art_color').selectpicker('refresh');
 
    });


    $.post("../ajax/articulov.php?op=selectTalla", function(r){
                $("#art_talla").html(r);
                $('#art_talla').selectpicker('refresh');
 
    });



    $.post("../ajax/articulov.php?op=selectCaracteristica", function(r){
                $("#art_caracteristica").html(r);
                $('#art_caracteristica').selectpicker('refresh');
 
    });



   


}

//Función limpiar
function limpiar()
{
	$("#codigo").val("");
	$("#nombre").val("");
	$("#descripcion").val("");
	$("#stock").val("");
	$("#imagenmuestra").attr("src","");
	$("#imagenactual").val("");
	$("#print").hide();
	$("#idarticulo").val("");
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
					url: '../ajax/articulov.php?op=listar',
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
		url: "../ajax/articulov.php?op=guardaryeditar",
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
	$.post("../ajax/articulov.php?op=mostrar",{idarticulo : idarticulo}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$("#idarticulo").val(data.idarticulo);
		$("#art_modelo").val(data.art_modelo);
		$("#art_color").val(data.art_color);
		$('#art_color').selectpicker('refresh');
		$("#art_codigo").val(data.art_codigo);
		$("#art_talla").val(data.art_talla);
		$('#art_talla').selectpicker('refresh');
		$("#art_marca").val(data.art_marca);
		$("#art_caracteristica").val(data.art_caracteristica);
		$('#art_caracteristica').selectpicker('refresh');
		$("#art_nombre").val(data.art_nombre);
		$("#art_cod_bar").val(data.art_cod_bar);
		$("#art_unidad").val(data.art_unidad);
		$("#art_stock_min").val(data.art_stock_min);
		$("#art_stock_max").val(data.art_stock_max);


 	})
}

//Función para desactivar registros
function desactivar(idarticulo)
{
	bootbox.confirm("¿Está Seguro de desactivar el articulo?", function(result){
		if(result)
        {
        	$.post("../ajax/articulov.php?op=desactivar", {idarticulo : idarticulo}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idarticulo)
{
	bootbox.confirm("¿Está Seguro de activar el articulo?", function(result){
		if(result)
        {
        	$.post("../ajax/articulov.php?op=activar", {idarticulo : idarticulo}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//funcion para generar barcode

function generarbarcode(){

	codigo=$("#codigo").val();
	JsBarcode("#barcode",codigo);
	$("#print").show();
}

//funcion para imprimir codigo de barras
function imprimir(){

	$("#print").printArea();
}

init();


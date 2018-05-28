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
    $.post("../ajax/tarjeta.php?op=selectArticulo", function(r){
                $("#art_codigo").html(r);
                $('#art_codigo').selectpicker('refresh');
 
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

//Función mostrar formulario - Principal para los llamado
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		//$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		listarMateriasPrimas(); // Llama a la lista del modal

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
					url: '../ajax/tarjeta.php?op=listar',
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


//Función Listar Materias Primas(Llama al listado del modal de materias primas desde el modal de la vista - id de modal ) 
function listarMateriasPrimas()
{
	tabla=$('#tblmateriasprimas').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            
		        ],
		"ajax":
				{
					url: '../ajax/tarjeta.php?op=listarMateriaPrimaTarjeta',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
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
		url: "../ajax/tarjeta.php?op=guardaryeditar",
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

function mostrar(art_codigo)
{
	$.post("../ajax/tarjeta.php?op=mostrar",{art_codigo : art_codigo}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);


		
		$("#art_codigo").val(data.art_codigo);
		$("#art_codigo").selectpicker('refresh');




		$("#id_tarjeta").val(data.id_tarjeta);


		


				//Ocultar y mostrar los botones
		$("#btnGuardar").show();
		$("#btnCancelar").show();
		$("#btnAgregarArt").show(); // Mostrar para agregar mas MP a la tarjeta ya creada

 		

 	});


 	$.post("../ajax/tarjeta.php?op=listarDetalle&id="+art_codigo,function(r){
	        $("#detalles").html(r);
	});	

	//INICIO 06022018

	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);

	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/tarjeta.php?op=guardaryeditar",
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


//Función para desactivar registros
function desactivar(idarticulo)
{
	bootbox.confirm("¿Está Seguro de desactivar la tarjeta?", function(result){
		if(result)
        {
        	$.post("../ajax/articulo.php?op=desactivar", {idarticulo : idarticulo}, function(e){
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
        	$.post("../ajax/articulo.php?op=activar", {idarticulo : idarticulo}, function(e){
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


var cont=0;



//funcion para agregar detalle del modal selleccionado a la tabla de detalle 
function agregarDetalle(CodPro,CodFab,DesPro,Color,Unidad)
  {
  	var cantidad=1;
    var descuento=0;

    if (CodPro!="")
    {
    	
    

    	var fila='<tr class="filas" id="fila'+cont+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
    	'<td><input type="hidden" name="CodPro[]" value="'+CodPro+'">'+CodPro+'</td>'+
    	'<td><input type="hidden" name="mp_codigo[]" value="'+CodFab+'">'+CodFab+'</td>'+
    	'<td><input type="hidden" name="DesPro[]" value="'+DesPro+'">'+DesPro+'</td>'+
    	'<td><input type="hidden" name="Color[]" value="'+Color+'">'+Color+'</td>'+
    	'<td><input type="hidden" name="Unidad[]" value="'+Unidad+'">'+Unidad+'</td>'+
    	'<td><input type="number" name="tar_consumo[]"  step="0.01" min="0" ></td>'+
    	'<td><button type="button" onclick="modificarSubototales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>'+
    	'</tr>';
    	cont++;
    	detalles=detalles+1;
    	$('#detalles').append(fila);
    	//Agregado para mostrar el boton de Guardar
    	evaluar();
    }
    else
    {
    	alert("Error al ingresar el detalle, revisar los datos de la materia prima");
    }
  }

  function evaluar(){
  	if (detalles>0)
    {
      $("#btnGuardar").show();
    }
    else
    {
      $("#btnGuardar").hide(); 
      cont=0;
    }
  }



//funcion para eliminar el detalle del dato seleccionado del modal 

  function eliminarDetalle(indice){
  	$("#fila" + indice).remove();
  	detalles=detalles-1;
  	evaluar()
  }





init();


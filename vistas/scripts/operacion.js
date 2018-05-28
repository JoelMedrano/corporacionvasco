var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});


	//cargamos los items al select Modelo de Operacion
    $.post("../ajax/operacion.php?op=selectModeloOperacion", function(r){
	            $("#art_modelo").html(r);
	            $('#art_modelo').selectpicker('refresh');
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
		// $("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();

	

		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		detalles=0;
		$("#btnAgregarArt").show();

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
					url: '../ajax/operacion.php?op=listar',
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



var cont=0;


function agregarDetalle()
  {
  	var cantidad=1;
    var descuento=0;



    	var fila='<tr class="filas" id="fila'+cont+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
    	'<td><input type="text" name="CodOperacion[]"  id="CodOperacion[]"  width="900px"></td>'+
    	'<td><input type="text" name="DesOperacion[]"  id="DesOperacion[]"  step="0.01" width="900px" ></td>'+
    	'<td><input type="number" name="PreDocena[]"  id="PreDocena[]"  step="0.01" ></td>'+
    	'<td><input type="number" name="TpoStandar[]"  id="TpoStandar[]"  step="0.01"  ></td>'+
    	'</tr>';
    	cont++;
    	detalles=detalles+1;
    	$('#detalles').append(fila);
    	//Agregado para mostrar el boton de Guardar
    	evaluar();
   
  }




function guardaryeditar(e) 
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/operacion.php?op=guardaryeditar",
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


function mostrar(idoperacion)
{
	$.post("../ajax/operacion.php?op=mostrar",{idoperacion : idoperacion}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#art_modelo").val(data.art_modelo);
		$("#art_modelo" ).selectpicker('refresh');

		//Ocultar y mostrar los botones
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").hide();


 	});

 	$.post("../ajax/operacion.php?op=listarDetalle&id="+idoperacion,function(r){
	        $("#detalles").html(r);
	});
}


//Función para desactivar registros
function desactivar(CodOperacion)
{
	bootbox.confirm("¿Está Seguro de desactivar el artículo?", function(result){
		if(result)
        {
        	$.post("../ajax/articulo.php?op=desactivar", {CodOperacion : idarticulo}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}




//Función para activar registros
function activar(idarticulo)
{
	bootbox.confirm("¿Está Seguro de activar el Artículo?", function(result){
		if(result)
        {
        	$.post("../ajax/articulo.php?op=activar", {idarticulo : idarticulo}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
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





  function eliminarDetalle(indice){
  	$("#fila" + indice).remove();
  	detalles=detalles-1;
  	evaluar()
  }



init();
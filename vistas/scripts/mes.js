var tabla;

//Función que se ejecuta al inicio
function init(){

	listarmes();
}


//Función Listar
function listarmes()
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
					url: '../ajax/proyeccion.php?op=listarmes',
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

//Función para desactivar registros
function desactivar(mes)
{
	bootbox.confirm("¿Está Seguro de desactivar el Mes?", function(result){
		if(result)
        {
        	$.post("../ajax/proyeccion.php?op=desactivar", {mes : mes}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(mes)
{
	bootbox.confirm("¿Está Seguro de activar el Mes?", function(result){
		if(result)
        {
        	$.post("../ajax/proyeccion.php?op=activar", {mes : mes}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}


init();
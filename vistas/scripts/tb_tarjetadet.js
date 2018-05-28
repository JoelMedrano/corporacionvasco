var tabla;

//Función que se ejecuta al inicio
function init() {
	mostrarform(false);
	listar();

	$("#formulario").on("submit", function(e) {
		guardaryeditar(e);
	});

	$.post("../ajax/tb_tarjetadet.php?op=listarART", function(r) {
		$("#idtarjeta").html(r);
		$('#idtarjeta').selectpicker('refresh');
	});


	$.post("../ajax/tb_tarjetadet.php?op=listarMP", function(r) {
		$("#codpro").html(r);
		$('#codpro').selectpicker('refresh');
	});



}

//Función limpiar
function limpiar() {
	$("#idtarjeta").val("");
	$("#iddetalle_tarjeta").val("");
	$("#cantidad").val("");
	$("#codpro").val("");

}

//Función mostrar formulario
function mostrarform(flag) {
	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled", false);
		$("#btnagregar").hide();
	} else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform() {
	limpiar();
	mostrarform(false);
}


//Función Listar
function listar() {
	tabla = $('#tbllistado').dataTable({
		"aProcessing": true, //Activamos el procesamiento del datatables
		"aServerSide": true, //Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip', //Definimos los elementos del control de tabla
		buttons: [
			'copyHtml5',
			'excelHtml5',
			'csvHtml5',
			'pdf'
		],
		"ajax": {
			url: '../ajax/tb_tarjetadet.php?op=listar',
			type: "get",
			dataType: "json",
			error: function(e) {
				console.log(e.responseText);
			}
		},
		"bDestroy": true,
		"iDisplayLength": 20, //Paginación
		"order": [
			[0, "desc"]
		] //Ordenar (columna,orden)
	}).DataTable();
}

//Función para guardar o editar
function guardaryeditar(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/tb_tarjetadet.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function(datos) {
			bootbox.alert(datos);
			mostrarform(false);
			tabla.ajax.reload();
		}

	});
	limpiar();
}


function mostrar(iddetalle_tarjeta) {
	$.post("../ajax/tb_tarjetadet.php?op=mostrar", {
		iddetalle_tarjeta: iddetalle_tarjeta
	}, function(data, status) {
		data = JSON.parse(data);
		mostrarform(true);


		$("#idtarjeta").val(data.idtarjeta);
		$('#idtarjeta').selectpicker('refresh');

		$("#codpro").val(data.codpro);
		$('#codpro').selectpicker('refresh');

		$("#cantidad").val(data.cantidad);


		$("#iddetalle_tarjeta").val(data.iddetalle_tarjeta);


	})
}

//Función para eliminar registros
function eliminar(iddetalle_tarjeta) {
	bootbox.confirm("¿Está Seguro de eliminar el item?", function(result) {
		if (result) {
			$.post("../ajax/tb_tarjetadet.php?op=eliminar", {
				iddetalle_tarjeta: iddetalle_tarjeta
			}, function(e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}


init();
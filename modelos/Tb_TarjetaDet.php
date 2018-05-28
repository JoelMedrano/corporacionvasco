<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Tb_TarjetaDet
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idtarjeta,$codpro,$cantidad)
	{
		$sql="INSERT INTO tb_tarjetadet (idtarjeta,codpro,cantidad)
				VALUES ('$idtarjeta','$codpro','$cantidad')";
		return ejecutarConsulta($sql);

	}

	//Implementamos un método para editar registros
	public function editar($iddetalle_tarjeta,$idtarjeta,$codpro,$cantidad)
	{
		$sql="UPDATE tb_tarjetadet SET idtarjeta='$idtarjeta',codpro='$codpro',cantidad='$cantidad' WHERE iddetalle_tarjeta='$iddetalle_tarjeta'";
		return ejecutarConsulta($sql);
	}


	public function mostrar($iddetalle_tarjeta)
	{
		$sql="SELECT * FROM tb_tarjetadet t WHERE t.iddetalle_tarjeta='$iddetalle_tarjeta'";

		return ejecutarConsultaSimpleFila($sql);
	}

	
	public function listar()
	{
		$sql="SELECT	a.idarticulo,
						a.art_codigo,
						a.art_nombre,
						c.col_nombre,
						a.art_nom_talla,
						tc.idtarjeta,
						td.iddetalle_tarjeta,	
						td.codpro,
						mp.codfab,
						mp.despro,
						mp.des_larga,
						td.cantidad,
						mp.medida,
						mp.prepro,
						a.art_est_tarjeta  
						FROM articulo1 a
						LEFT JOIN color c
						ON a.art_color=c.art_color
						LEFT JOIN tb_tarjetacab tc
						ON a.idarticulo=tc.idarticulo
						LEFT JOIN tb_tarjetadet td
						ON tc.idtarjeta=td.idtarjeta
						LEFT JOIN
							(SELECT 
							mp.codpro,
							mp.codfab,
							mp.despro,
							td.des_larga,
							mp.undpro,
								(SELECT td.des_larga FROM tabla_m_detalle td WHERE td.cod_tabla='TUND' AND mp.undpro=td.cod_argumento) AS medida,
							mp.mo,
							mp.prepro
							FROM materia_prima mp
							LEFT JOIN tabla_m_detalle td
							ON mp.colpro=td.cod_argumento
							WHERE td.cod_tabla='tcol') AS mp
						ON td.codpro=mp.codpro
						WHERE a.art_est_tarjeta='1'
						ORDER BY codpro";

		return ejecutarConsulta($sql);
	}


	public function eliminar($iddetalle_tarjeta)
	{
		$sql="DELETE FROM tb_tarjetadet where iddetalle_tarjeta='$iddetalle_tarjeta'";

		return ejecutarConsulta($sql);

	}



	
}
?>
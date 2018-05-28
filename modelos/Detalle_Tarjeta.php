<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Detalle_Tarjeta
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($art_codigo,$codpro,$cantidad)
	{
		$sql="INSERT INTO tb_tarjeta (art_codigo,codpro,cantidad)
		VALUES ($art_codigo,$codpro,$cantidad)";
		return ejecutarConsulta($sql);

	}

	//Implementamos un método para editar registros
	public function editar($idtarjeta,$art_codigo,$codpro,$cantidad)
	{
		$sql="UPDATE tb_tarjeta SET art_codigo='$art_codigo',codpro='$codpro',cantidad='$cantidad' WHERE idtarjeta='$idtarjeta'";
		return ejecutarConsulta($sql);
	}


	public function mostrar($idtarjeta)
	{
		$sql="SELECT* FROM tb_tarjeta t  WHERE t.idtarjeta='$idtarjeta'";

		return ejecutarConsultaSimpleFila($sql);
	}

	
	public function listar()
	{
		$sql="SELECT	a.idarticulo,
						a.art_codigo,
						a.art_nombre,
						c.col_nombre,
						a.art_nom_talla,
						t.idtarjeta,
						t.codpro,
						mp.codfab,
						mp.despro,
						mp.des_larga,
						t.cantidad,
						mp.medida,
						mp.prepro,
						a.art_est_tarjeta 
						FROM articulo1 a
						LEFT JOIN color c
						ON a.art_color=c.art_color
						LEFT JOIN tb_tarjeta t
						ON a.art_codigo=t.art_codigo
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
						ON t.codpro=mp.codpro
						WHERE a.art_est_tarjeta='1'
						ORDER BY t.idtarjeta";

		return ejecutarConsulta($sql);
	}


	public function eliminar($idtarjeta)
	{
		$sql="DELETE FROM tb_tarjeta where idtarjeta='$idtarjeta'";

		return ejecutarConsulta($sql);

	}

	
}
?>

<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class Consultas
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
    public function comprasfecha($fecha_inicio,$fecha_fin)
    {
        $sql="SELECT DATE(i.fecha_hora) as fecha,u.nombre as usuario, p.nombre as proveedor,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE DATE(i.fecha_hora)>='$fecha_inicio' AND DATE(i.fecha_hora)<='$fecha_fin'";
        return ejecutarConsulta($sql);      
    }
 
    public function ventasfechacliente($fecha_inicio,$fecha_fin,$idcliente)
    {
        $sql="SELECT DATE(v.fecha_hora) as fecha,u.nombre as usuario, p.nombre as cliente,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' AND v.idcliente='$idcliente'";
        return ejecutarConsulta($sql);      
    }


    public function comprasultimos_10dias()
    {
        $sql="SELECT CONCAT(DAY(fecha_hora),'-',MONTH(fecha_hora)) as fecha,SUM(total_compra) as total FROM ingreso GROUP by fecha_hora ORDER BY fecha_hora DESC limit 0,10";

        return ejecutarConsulta($sql);
    }

    public function ventasultimos_12meses()
    {
        $sql="SELECT DATE_FORMAT(fecha_hora,'%M') as fecha,SUM(total_venta) as total FROM venta GROUP by MONTH(fecha_hora) ORDER BY fecha_hora DESC limit 0,10";
        return ejecutarConsulta($sql);
    }



       public function select ()
    {
        $sql="SELECT
                    IFNULL(SUM(total_compra),0) AS total_compra 
                    FROM ingreso
                    WHERE DATE(fecha_hora)=CURDATE()";
        return ejecutarConsulta($sql);
    }


    //Agregado Leydi Godos 06022018
        public function selectColorArticulo ()
    {
        $sql="SELECT art_color, 
                     col_nombre
                    FROM Color";
        return ejecutarConsulta($sql);
    }

       //Agregado Leydi Godos 10022018
        public function selectTallaArticulo ()
    {
        $sql="SELECT idtalla, 
                     art_talla,
                     nombre_talla
                    FROM Talla";
        return ejecutarConsulta($sql);
    }


       //Agregado Leydi Godos 10022018
        public function selectCaracteristicaArticulo ()
    {
        $sql="SELECT idcaracteristica, 
                     art_caracteristica,
                     carac_nombre
                    FROM caracteristica";
        return ejecutarConsulta($sql);
    }





    //Agregado Leydi Godos 07032018
        public function selectModeloOperacion ()
    {
        $sql="SELECT distinct art_modelo, 
                     art_nombre
                    FROM articulo1";
        return ejecutarConsulta($sql);
    }

  

    public function totalprodmes()
    {
        $sql="SELECT    FORMAT(SUM(cantidad),0) AS total
                        FROM movimiento
                        WHERE tipo_mov='E20' AND MONTH(fecha)=MONTH(NOW())
                        GROUP BY MONTH(fecha)";

        return ejecutarConsulta($sql);
    }     


    public function totalvenmes()
    {
        $sql="SELECT    FORMAT(SUM(cantidad),0) AS total
                        FROM movimiento
                        WHERE tipo_mov IN ('S02','S03','S70','E05') AND MONTH(fecha)=MONTH(NOW())
                        GROUP BY MONTH(fecha)";

        return ejecutarConsulta($sql);
    }    
 
    public function modMasVen()
    {
        $sql="SELECT    a.art_modelo,
                        IFNULL(SUM(total),0) AS total
                        FROM articulo1 a
                        LEFT JOIN
                        (SELECT
                        art_codigo,
                        SUM(cantidad) AS total
                        FROM movimiento
                        WHERE tipo_mov IN ('S02','S03','S70','E05') AND MONTH(fecha)=MONTH(NOW())
                        GROUP BY art_codigo) AS t
                        ON a.art_codigo=t.art_codigo
                        GROUP BY art_modelo
                        ORDER BY SUM(total) DESC
                        LIMIT 0,10";

            return ejecutarConsulta($sql);

    }


    public function modMasPro()
    {
        $sql="SELECT    a.art_modelo,
                        IFNULL(SUM(total),0) AS total
                        FROM articulo1 a
                        LEFT JOIN
                        (SELECT
                        art_codigo,
                        SUM(cantidad) AS total
                        FROM movimiento
                        WHERE tipo_mov='E20' AND MONTH(fecha)=MONTH(NOW())
                        GROUP BY art_codigo) AS t
                        ON a.art_codigo=t.art_codigo
                        GROUP BY art_modelo
                        ORDER BY SUM(total) DESC
                        LIMIT 0,10";

            return ejecutarConsulta($sql);

    }    

    //Fin
 
}
 
?>
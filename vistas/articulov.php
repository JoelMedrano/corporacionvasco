<?php

//activamos el almacenamiento en el buffer

ob_start();

session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location:login.html");  
}
else
{
require 'header.php';
if ($_SESSION['almacen']==1)
 {

?>



<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Articulo<button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button> <a target="_blank" href="../reportes/rptarticulos.php"><button class="btn btn-info">Reporte</button></a></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Codigo</th>
                            <th>Marca</th>
                            <th>Nombre</th>
                            <th>Color</th>
                            <th>Talla</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Codigo</th>
                            <th>Marca</th>
                            <th>Nombre</th>
                            <th>Color</th>
                            <th>Talla</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>



                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">

                      

                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <label>Codigo:</label>
                             <input type="hidden" name="idarticulo" id="idarticulo">
                             <input type="text" class="form-control" required readonly name="art_modelo" id="art_modelo" maxlength="256" placeholder="Modelo">
                          </div>

                           <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <label>Color:</label>
                            <select id="art_color" name="art_color" required class="form-control selectpicker" data-live-search="true" required></select>
                          </div>


                           <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <label>Talla:</label>
                            <select id="art_talla" name="art_talla" required class="form-control selectpicker" data-live-search="true" required></select>
                          </div>


                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Codigo:</label>
                            <input type="text" class="form-control" readonly name="art_codigo" id="art_codigo" maxlength="256" placeholder="Codigo">
                          </div>


                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Marca:</label>
                            <input type="text" class="form-control" readonly required name="art_marca" id="art_marca" maxlength="256" placeholder="Marca">
                          </div>

                          

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Caracteristica:</label>
                            <select id="art_caracteristica" name="art_caracteristica" required class="form-control selectpicker" data-live-search="true" required></select>
                          </div>


                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Descripción:</label>
                            <input type="text" class="form-control" required name="art_nombre" id="art_nombre" maxlength="256" placeholder="Descripción">
                          </div>

                         

                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <label>Unidad:</label>
                           
                             <input type="text" class="form-control" readonly name="art_unidad" value="und" id="art_unidad" maxlength="256" >
                          </div>

                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Stock Minimo:</label>
                            <input type="number" class="form-control" required name="art_stock_min" id="art_stock_min" required placeholder="Stock Minimo" >
                          </div>


                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Stock Máximo:</label>
                            <input type="number" class="form-control" required name="art_stock_max" id="art_stock_max" required placeholder="Stock Maximo">
                          </div>


                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->

  



<?php
}
else
{
  require 'noacceso.php';
}
require 'footer.php';
?>
<script type="text/javascript" src="../public/js/JsBarcode.all.min.js"></script>
<script type="text/javascript" src="../public/js/jquery.PrintArea.js"></script>
<script type="text/javascript" src="scripts/articulov.js"></script>
<?php 
}
ob_end_flush();
?>
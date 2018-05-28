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

if ($_SESSION['tarjetas']==1)
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
                          <h1 class="box-title">Detalle de Tarjeta <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>

                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Color</th>
                            <th>Talla</th>
                            <th>CODPRO</th>
                            <th>CODFAB</th>
                            <th>Descripcion</th>
                            <th>Detalle</th>
                            <th>Consumo</th>
                            <th>Und</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Color</th>
                            <th>Talla</th>
                            <th>CODPRO</th>
                            <th>CODFAB</th>
                            <th>Descripcion</th>
                            <th>Detalle</th>
                            <th>Consumo</th>
                            <th>Und</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                          </tfoot>
                        </table>
                    </div>


                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">


                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>ARTICULO(*):</label>
                            <select id="art_codigo" name="art_codigo" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Materia Prima(*):</label>
                            <input type="hidden" name="idtarjeta" id="idtarjeta">
                            <select id="codpro" name="codpro" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Consumo(*):</label>
                            <input type="text" class="form-control" name="cantidad" id="cantidad" placeholder="Cant" required>
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
<script type="text/javascript" src="scripts/detalle_tarjeta.js"></script>
<?php 
}
ob_end_flush();
?>



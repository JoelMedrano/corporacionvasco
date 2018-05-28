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
                          <h1 class="box-title">TARJETAS <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>



                    
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>

                            <th>Codigo</th>
                            <th>Marca</th>
                            <th>Nombre</th>
                            <th>Color</th>
                            <th>Talla</th>
                            <th>Est. Art</th>
                            <th>Tipo</th>
                            <th>Est. Edicion</th>
                            <th>Opciones</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>

                            <th>Codigo</th>
                            <th>Marca</th>
                            <th>Nombre</th>
                            <th>Color</th>
                            <th>Talla</th>
                            <th>Est. Art</th>
                            <th>Tipo</th>
                            <th>Est. Edicion</th>
                            <th>Opciones</th>
                          </tfoot>
                        </table>
                    </div>

                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Articulo:</label>
                            <input type="text" class="form-control" name="art_codigo" id="art_codigo">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombre:</label>
                            <input type="text" class="form-control" name="art_nombre" id="art_nombre">
                          </div>                          

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Marca:</label>
                            <input type="text" class="form-control" name="art_marca" id="art_marca">
                          </div>  

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Color:</label>
                            <input type="text" class="form-control" name="col_nombre" id="col_nombre">
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Talla:</label>
                            <input type="text" class="form-control" name="art_nom_talla" id="art_nom_talla">
                          </div>                                                      

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Precio Materia Prima: S/</label>
                            <input type="text" class="form-control" name="pretot" id="pretot">
                          </div>  


                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Venta</th>
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
                                </thead>
                                <tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">S/. 0.00</h4><input type="hidden" name="total_cotizacion" id="total_cotizacion"></th> 
                                </tfoot>
                                <tbody>
                                  
                                </tbody>
                            </table>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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
<script type="text/javascript" src="scripts/tarjetav.js"></script>
<?php 
}
ob_end_flush();
?>
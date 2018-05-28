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
                          <h1 class="box-title"><b>TARJETAS FALTANTES    </b><button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>



                    
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>

                            <th>CODIGO</th>
                            <th>MODELO</th>                
                            <th>MARCA</th>
                            <th>NOMBRE</th>
                            <th>COLOR</th>
                            <th>TALLA</th>
                            <th>ESTADO</th>
                            <th>Opciones</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>

                            <th>CODIGO</th>
                            <th>MODELO</th>                
                            <th>MARCA</th>
                            <th>NOMBRE</th>
                            <th>COLOR</th>
                            <th>TALLA</th>
                            <th>ESTADO</th>
                            <th>opciones</th>
                          </tfoot>
                        </table>
                    </div>


                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <label>Articulo(*):</label>
                            <input type="hidden" name="idtarjeta" id="idtarjeta">
                            <select id="idarticulo" name="idarticulo" class="form-control selectpicker" data-live-search="true" required>    
                            </select>
                          </div>  

                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Fecha(*):</label>
                            <input type="date" class="form-control" name="fecha_creacion" id="fecha_creacion" required="">
                          </div>                         

                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <a data-toggle="modal" href="#myModal">           
                              <button id="btnAgregarArt" type="button" class="btn btn-primary"> <span class="fa fa-plus"></span> Agregar MATERIA PRIMA</button>
                            </a>
                          </div>                          


                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>MATERIA PRIMA</th>
                                    <th>CANTIDAD</th>
                                    <th>PRECIO ORIGEN</th>
                                    <th>PRECIO S/</th>
                                    <th>SUBTOTAL</th>
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



  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 80% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione Materiaprima</h4>
        </div>
        <div class="modal-body">
          <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <th>Opciones</th>
                <th>CODPRO</th>
                <th>COFAB</th>
                <th>DESPRO</th>
                <th>DES_LARGA</th>
                <th>MEDIDA</th>
                <th>MONEDA</th>
                <th>PRECIO</th>
                <th>PRECIO SOLES</th>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
                <th>Opciones</th>
                <th>CODPRO</th>
                <th>COFAB</th>
                <th>DESPRO</th>
                <th>DES_LARGA</th>
                <th>MEDIDA</th>
                <th>MONEDA</th>
                <th>PRECIO</th>
                <th>PRECIO SOLES</th>
            </tfoot>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div>  
  <!-- Fin modal -->

<?php
}
else
{
  require 'noacceso.php';
}
require 'footer.php';
?>
<script type="text/javascript" src="scripts/tarjetas_faltantes.js"></script>
<?php 
}
ob_end_flush();
?>



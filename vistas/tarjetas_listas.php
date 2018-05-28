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
                          <h1 class="box-title"><b>TARJETAS PARA REVISAR Y APROBADAS </b></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>



                    
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>

                            <th style="width:10px">ARTICULO</th>
                            <th style="width:10px">MARCA</th>
                            <th>NOMBRE</th>
                            <th style="width:10px">COLOR</th>
                            <th style="width:10px">TALLA</th>
							              <th style="width:10px">EST. ART.</th>
                            <th>ESTADO TARJETA</th>
                            <th>OPCIONES</th>                            
                            <th>EDICION</th>
                            <th>Edicion</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>

                            <th style="width:10px">ARTICULO</th>
                            <th style="width:10px">MARCA</th>
                            <th>NOMBRE</th>
                            <th style="width:10px">COLOR</th>
                            <th style="width:10px">TALLA</th>
                            <th style="width:10px">EST. ART.</th>
                            <th>ESTADO TARJETA</th>
                            <th>OPCIONES</th>                            
                            <th>EDICION</th>
                            <th>Edicion</th>
                          </tfoot>
                        </table>
                    </div>


                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Codigo:</label>
                            <input type="hidden" name="idtarjeta" id="idtarjeta">
                            <input type="text" class="form-control" name="art_codigo" id="art_codigo" readonly placeholder="Codigo">
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Modelo:</label>
                            <input type="text" class="form-control" name="art_modelo" id="art_modelo" readonly placeholder="Modelo">
                          </div> 

                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Nombre:</label>
                            <input type="text" class="form-control" name="art_nombre" id="art_nombre" readonly placeholder="Nombre">
                          </div>                           

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Color:</label>
                            <input type="text" class="form-control" name="col_nombre" id="col_nombre" readonly placeholder="Color">
                          </div>     

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Talla:</label>
                            <input type="text" class="form-control" name="art_nom_talla" id="art_nom_talla" readonly placeholder="Talla">
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Marca:</label>
                            <input type="text" class="form-control" name="art_marca" id="art_marca" readonly placeholder="Marca">
                          </div>                            

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Estado Articulo:</label>
                            <input type="text" class="form-control" name="art_estado" id="art_estado" readonly placeholder="Estado">
                          </div>                                                                                                                                                                                      

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Responsable:</label>
                            <input type="text" class="form-control" name="login" id="login" readonly placeholder="Responsable">
                          </div> 

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Estado Tarjeta:</label>
                            <input type="text" class="form-control" name="estado" id="estado" readonly placeholder="Estado">
                          </div>  

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>COSTO MP S/:</label>
                            <input type="text" class="form-control" name="total" id="total" readonly placeholder="COSTO">
                          </div>                                                     

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Fecha:</label>
                            <input type="date" class="form-control" name="fecha_creacion" id="fecha_creacion" readonly required="">
                          </div>                         

                        


                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                              
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
<script type="text/javascript" src="scripts/tarjetas_listas.js"></script>
<?php 
}
ob_end_flush();
?>



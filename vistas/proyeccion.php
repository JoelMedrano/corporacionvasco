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
                          <h1 class="box-title">EXPLOSION DE MATERIALES</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>codpro</th>
                            <th>linea</th>
                            <th>codfab</th>
                            <th>despro</th>
                            <th>des_larga</th>

                            <th>undpro</th>

                            <th>moneda</th>
                            <th>prepro</th>
                            <th>presol</th>
                            <th>proy</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                             <th>codpro</th>
                            <th>linea</th>
                            <th>codfab</th>
                            <th>despro</th>
                            <th>des_larga</th>

                            <th>undpro</th>
        
                            <th>moneda</th>
                            <th>prepro</th>
                            <th>presol</th>
                            <th>proy</th>
                          </tfoot>
                        </table>
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
<script type="text/javascript" src="scripts/proyeccion.js"></script>
<?php 
}
ob_end_flush();
?>
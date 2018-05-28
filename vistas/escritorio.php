<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
 
if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';
 
if ($_SESSION['escritorio']==1)
{
  require_once "../modelos/Consultas.php";
  $consulta = new Consultas();

  $rsptap = $consulta->totalprodmes();
  $regp=$rsptap->fetch_object();
  $tot=$regp->total;
 
  $rsptav = $consulta->totalvenmes();
  $regv=$rsptav->fetch_object();
  $totalv=$regv->total;
 

  $modmasven = $consulta->modMasVen();
  $modv='';
  $totalm='';
  while ($regmod= $modmasven->fetch_object()) {
    $modv=$modv.'"'.$regmod->art_modelo .'",';
    $totalm=$totalm.$regmod->total .',';
  }
  //Quitamos la última coma
  $modv=substr($modv, 0, -1);
  $totalm=substr($totalm, 0, -1);

  
  $modmaspro = $consulta->modMasPro();
  $modp='';
  $totalp='';
  while ($regmod= $modmaspro->fetch_object()) {
    $modp=$modp.'"'.$regmod->art_modelo .'",';
    $totalp=$totalp.$regmod->total .',';
  }
  //Quitamos la última coma
  $modp=substr($modp, 0, -1);
  $totalp=substr($totalp, 0, -1);




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
                          <h1 class="box-title">Escritorio </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                          <div class="small-box bg-aqua">
                              <div class="inner">
                                <h4 style="font-size:17px;">
                                  <strong><?php echo $tot; ?> UNIDADES</strong>
                                </h4>
                                <p>Produccion</p>
                              </div>
                              <div class="icon">
                                <i class="ion ion-bag"></i>
                              </div>
                              <a href="ingreso.php" class="small-box-footer">Compras <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                          <div class="small-box bg-green">
                              <div class="inner">
                                <h4 style="font-size:17px;">
                                  <strong><?php echo $totalv; ?> UNIDADES</strong>
                                </h4>
                                <p>Ventas</p>
                              </div>
                              <div class="icon">
                                <i class="ion ion-bag"></i>
                              </div>
                              <a href="venta.php" class="small-box-footer">Ventas <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                       
                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="box box-primary">
                          <div class="box-header with-border">
                            MODELOS MAS VENDIDOS DEL MES
                          </div>
                          <div class="box-body">
                            <canvas id="modmasven" width="400" height="400"></canvas>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="box box-primary">
                          <div class="box-header with-border">
                            MODELOS MAS PRODUCIDOS DEL MES
                          </div>
                          <div class="box-body">
                            <canvas id="modmaspro" width="400" height="400"></canvas>
                          </div>
                        </div>
                      </div>

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
<script src="../public/js/chart.min.js"></script>
<script src="../public/js/Chart.bundle.min.js"></script>
<script type="text/javascript">

var ctx = document.getElementById("modmasven").getContext('2d');
var modmasven = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $modv; ?>],
        datasets: [{
            label: '# Modelos mas Vendidos del Mes',
            data: [<?php echo $totalm; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});


var ctx = document.getElementById("modmaspro").getContext('2d');
var modmaspro = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $modp; ?>],
        datasets: [{
            label: '# Modelos mas Producidos del Mes',
            data: [<?php echo $totalp; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});


</script>
</script> 
<?php 
}
ob_end_flush();
?>
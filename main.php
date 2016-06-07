<?php
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tax Monitoring System | Dashboard </title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Data Tables -->
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <div id="wrapper">	
<?php
include "navi.php";
?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2>TAX MONITORING SYSTEM</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li class="active">
                            <strong>DASHBOARD</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-sm-8">
                    <div class="title-action">
					<small>Didukung oleh</small>
                        <img alt="image" src="img/Logo-Bank-Riau-Kepri-transparent-bg.png" width='280' height='50' align='center'/>
                    </div>
                </div>
            </div>



            <div class="wrapper wrapper-content">

			<div class="row">
        <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Data Transaksi Masuk - <i>Live Traffic</i></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                           
                            
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                  <table id="example" class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                      <tr>
                       <th>DeviceID</th>
					   <th>WajibPajak</th>
                        <th>NoStruk</th>
						<th>TglTransaksi</th>
                        <th>Jumlah</th>

                      </tr>
                    </thead>
                    
                    <tfoot>
                      <tr>
                       <th>DeviceID</th>
					   <th>WajibPajak</th>
                        <th>NoStruk</th>
						<th>TglTransaksi</th>
                        <th>Jumlah</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            
            </div><!-- /.col -->
          </div><!-- /.row -->


			<div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content">
                                    <div>
                                        <span class="pull-right text-right">
                                        <small>Information: <strong>Info</strong></small>
                                            <br/>
                                            Jumlah Wajib Pajak : 8.800
                                        </span>
                                        <h1 class="m-b-xs">RP 50.992.155.000</h1>
                                        <h3 class="font-bold no-margins">
                                            Data Pendapatan Pajak Semester I 2016
                                        </h3>
<br>
                                    </div>

                                <div>
                                    <canvas id="lineChart" height="70"></canvas>
                                </div>

                                <div class="m-t-md">
                                    <small class="pull-right">
                                        <i class="fa fa-clock-o"> </i>
                                        Update on 20.05.2016
                                    </small>
                                   <small>
                                       <strong>Catatan:</strong>
                                   </small>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                
			<div class="row">
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-success pull-right">Bulan Berjalan</span>
                                <h5>Penerimaan Pajak</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">20.886.200.000</h1>
                                <div class="stat-percent font-bold text-success">65% <i class="fa fa-bolt"></i></div>
                                <small> Total</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-info pull-right">Tahun Berjalan</span>
                                <h5>Penerimaan Pajak</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">80.900.134.000</h1>
                                <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div>
                                <small>Total</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-primary pull-right">ONLINE</span>
                                <h5>Jumlah WP</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">350</h1>
                                <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div>
                                <small>Total</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-danger pull-right">OFFLINE</span>
                                <h5>Jumlah WP</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">80</h1>
                                <div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i></div>
                                <small>Sejak Launching</small>
                            </div>
                        </div>
            </div>


        </div>


 





<!---->
            </div>








            <div class="footer">
               
                <div>
                    <strong>Copyright</strong> LuxTax &copy; 2016
                </div>
            </div>

        </div>
        </div>

     <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/plugins/jeditable/jquery.jeditable.js"></script>

	<!-- Flot -->
    <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="js/plugins/flot/jquery.flot.symbol.js"></script>
    <script src="js/plugins/flot/jquery.flot.time.js"></script>

	 <!-- Peity -->
    <script src="js/plugins/peity/jquery.peity.min.js"></script>
    <script src="js/demo/peity-demo.js"></script>
	    <!-- jQuery UI -->
    <script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- Jvectormap -->
    <script src="js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

    <!-- EayPIE -->
    <script src="js/plugins/easypiechart/jquery.easypiechart.js"></script>

    <!-- Sparkline -->
    <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

   <!-- ChartJS-->
    <script src="js/plugins/chartJs/Chart.min.js"></script>

    <script>
        $(document).ready(function() {

            var lineData = {
                labels: ["January", "February", "March", "April", "May", "June", "July"],
                datasets: [
                    {
                        label: "Target Penerimaan Pajak",
                        fillColor: "rgba(220,220,220,0.5)",
                        strokeColor: "rgba(220,220,220,1)",
                        pointColor: "rgba(220,220,220,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: [65, 59, 80, 81, 56, 55, 40]
                    },
                    {
                        label: "Example dataset",
                        fillColor: "rgba(26,179,148,0.5)",
                        strokeColor: "rgba(26,179,148,0.7)",
                        pointColor: "rgba(26,179,148,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(26,179,148,1)",
                        data: [28, 48, 40, 19, 86, 27, 90]
                    }
                ]
            };

            var lineOptions = {
                scaleShowGridLines: true,
                scaleGridLineColor: "rgba(0,0,0,.05)",
                scaleGridLineWidth: 1,
                bezierCurve: true,
                bezierCurveTension: 0.4,
                pointDot: true,
                pointDotRadius: 4,
                pointDotStrokeWidth: 1,
                pointHitDetectionRadius: 20,
                datasetStroke: true,
                datasetStrokeWidth: 2,
                datasetFill: true,
                responsive: true,
            };


            var ctx = document.getElementById("lineChart").getContext("2d");
            var myNewChart = new Chart(ctx).Line(lineData, lineOptions);

        });
    </script>
  

    <!-- Data Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>



    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

	<script>
      $(document).ready(function() {
        var table = $('#example').DataTable( {
		dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ], 	
        "processing": true,
        "serverSide": true,
        "ajax": "scripts/server_processing.php"
      } );
	  
      

	  $('#example tbody').on('click', 'tr', function () {
        var data = table.row(this).data();
        console.log(data[0]);
      });
     } );
    </script>
	
	



</body>



</html>

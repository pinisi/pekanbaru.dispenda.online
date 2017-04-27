<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tax Monitoring System | Dashboard</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">

    <link href="css/plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">

    <link href="css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">  

    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    <link href="css/plugins/ionRangeSlider/ion.rangeSlider.css" rel="stylesheet">
    <link href="css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css" rel="stylesheet">

    <link href="css/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">
    <link href="css/plugins/jqGrid/ui.jqgrid.css" rel="stylesheet">    

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
                        <a href="main.php">Home</a>
                    </li>
                    <li class="active">
                        <strong>Penghimpunan Data</strong>
                    </li>
                </ol>
            </div>
            <div class="col-sm-8">
                <div class="title-action">
                               <small>Didukung oleh</small>
<!--                    <img alt="image" src="img/Logo-Bank-Riau-Kepri-transparent-bg.png" width='280' height='50' align='center'/>
-->
                </div>
            </div>
        </div>
		<div class="wrapper wrapper-content animated fadeInRight">

		<div class="row">
		<div class="col-lg-12">
          <table align="left" border="0" width="500">
            <tr><td valign="top" width="100"><span style="font-size: 16px;">Periode</span></td>
                  <td valign="top">
                        <?php include "select_bulan.php"; ?>
						<?php include "select_tahun.php"; ?>
                  </td>
              </tr>
            <tr >
            <td colspan="2">
						<?php if ($_SESSION['level'] != '1' ) { $disabled = "disabled"; } else { $disabled=""; }; ?> 
                        <br><br><input type=submit value="Export to Excel >>" id="go" name="go" class="button" <?php echo $disabled; ?>><br>
            </td>
            </tr>

           </table>
	</div>
  </div>
</div>
        <div class="footer">
                <div>
                    <strong>Copyright</strong> Pinisi Elektra &copy; 2016
                </div>
        </div>

        </div>
                    </div>

  <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>

	<script type="text/javascript">
$(document).ready(function(){

  $("#go").click(function(e) {
          window.open("xls_himpun_data.php" + "?bulan=" + bulan.value + "&tahun=" + tahun.value, '_blank');
  });
 

});
</script>

</body>



</html>
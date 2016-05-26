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
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">
    <link href="css/plugins/jqGrid/ui.jqgrid.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>
        /* Additional style to fix warning dialog position */
        #alertmod_table_list_2 {
            top: 900px !important;
        }
    </style>


	<!-- datepicker -->
	<!--<link rel="stylesheet" href="jquery-ui/style.css">-->
	<link rel="stylesheet" href="jquery-ui/jquery-ui.css">
	<script src="jquery-ui/external/jquery/jquery.js"></script>
	
	
<script type="text/javascript">
$(function () {
    $("#list").jqGrid({
        url: "data_device.php",
        editurl: "crud_device.php",
        datatype: "xml",
        mtype: "GET",
	width:700,
	height:300,
        colNames: ["id","Device ID", "Device Alias", "Merchant Name", "Kategori", "Status"],
        colModel: [
            { name: "id", hidden: true, editable: true},
            { name: "deviceid", width: 15 , editable: true, editoptions:{size:30}},
            { name: "wpname", width: 25 , editable: true, editoptions:{size:30}},
            { name: "merchantname", width: 30 ,editable: true,edittype: 'select', editoptions:{dataUrl: "select_merchantname.php"}},
            { name: "kategori_name", width: 15 ,editable: true,edittype: 'select', editoptions:{dataUrl: "select_kategoriname.php"}},
            { name: "status", width: 7, align: "Left", editable: true, editoptions:{size:10} },
        ],
        pager: "#pager",
        rowNum: 20,
        rowList: [20, 40, 60],
        sortname: "deviceid",
        sortorder: "asc",
        viewrecords: true,
        gridview: true,
        autoencode: true,
        caption: 'Data Device'
    }); 
    jQuery("#list").jqGrid('navGrid','#pager',{edit:true,refresh:true,search:false,add:true,del:true},
             {width:600, height: 300, closeAfterEdit: true},
             {width:600, height: 300, closeAfterAdd: true});
});			 
</script>


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
            

<!-- -->

<div class="row">
	<div class="col-lg-12 table-responsive tablediv" style="padding-top: 8px;">
	
          <table align="left" border="0">
            
              
       

           </table>
	</div>
  </div>
  
  <div class="row">
    <div class="col-lg-12 table-responsive tablediv" style="padding-top: 8px;">
	  <!--<div class="table-responsive tablediv">-->
		<table id="list"></table>
		<div id="pager"></div>
	  <!--</div>-->
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

    <!-- Peity -->
    <script src="js/plugins/peity/jquery.peity.min.js"></script>

    <!-- jqGrid -->
    <script src="js/plugins/jqGrid/i18n/grid.locale-en.js"></script>
    <script src="js/plugins/jqGrid/jquery.jqGrid.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>


</body>



</html>

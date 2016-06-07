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
$(document).ready(function () {

var createGrid= function() {
	$("#list").jqGrid({
		url: "data_transaksi.php",
        datatype: "xml",
        mtype: "GET",
	//	width:900,
		autowidth: true,
        shrinkToFit: true,
		height:400,
        postData: {
            'merchant': function() { return getSelectedMerchant();},
            'tanggal1': function() { return datepicker1.value;},
            'tanggal2': function() { return datepicker2.value}
        },
        colNames: ["No Struk", "Wajib Pajak", "Kategori", "Waktu","Harga", "Pajak"],
        colModel: [
            { name: "nostruk", width: 20 },
            { name: "merchantname", width: 80, align: "Left" },
            { name: "kategori_name", width: 30, align: "center" },
            { name: "tgltransaksi", width: 55, sortable: true, sorttype: 'date',formatter:'date', formatoptions: {srcformat: 'Y/m/d H:i:s', newformat:'d-F-Y H:i:s'}},            
            { name: "jumlah", width: 30, align: "right", sortable: true },
            { name: "pajak", width: 30, align: "right", sortable: true}
        ],
        pager: "#pager",
        rowNum: 20,
        rowList: [20, 40, 60],
        sortname: "tgltransaksi",
        sortorder: "desc",
        viewrecords: true,
        gridview: true,
        autoencode: true,
        caption: 'Data Transaksi'
	}); 
	 jQuery("#list").jqGrid('navGrid','#pager',{edit:false,refresh:true,search:false,add:false,del:false})
      .navButtonAdd('#pager',{
                                caption: "Export to Excel",
                                buttonicon: "ui-icon-save",
                                onClickButton: function() {
                                     //alert("here");
                                     window.open("xls_transaksi.php" + "?merchantid=" + getSelectedMerchant() + "&tanggal1=" + datepicker1.value + "&tanggal2=" + datepicker2.value, '_blank');
                                     //$.get("http://192.168.12.41/tms/simplebanget.php",{}, function (){
                                      //    alert("here2");
                                     //});
                                },
                                position:"last"
                            });

    $("#go").click(function(e) {
        //$("#list").jqGrid('GridUnload');
        var user_select = merchantid.value;
      
        if (user_select == "none") {
           alert("Maaf, silahkan pilih salah satu wajib pajak.");
        } else {

        jQuery("#list").jqGrid("clearGridData");
        jQuery("#list").jqGrid("setGridParam", {datatype: "xml"})
               .trigger("reloadGrid",[{page:1}]);
        }
        //createGrid();
        //jsonurl = "./report_chart_wp.php" + "?merchantid=" + jQuery("#merchantid option:selected").val() + "&tanggal1=" + datepicker1.value + "&tanggal2=" + datepicker2.value;
    });			 
}
	
$(function() {
    $( "#datepicker1" ).datepicker({ dateFormat: "dd/mm/yy" });
  });

$(function() {
    $( "#datepicker2" ).datepicker({ dateFormat: "dd/mm/yy" });
  });

var date = new Date();
date.setDate(date.getDate() - 1);

document.getElementById("datepicker1").value = ('0' + date.getDate()).slice(-2) + '/' + ( '0' + (date.getMonth() + 1)).slice(-2) +  '/' +  date.getFullYear();
date = new Date();
document.getElementById("datepicker2").value = ('0' + date.getDate()).slice(-2) + '/' + ( '0' + (date.getMonth() + 1)).slice(-2) +  '/' +  date.getFullYear();
	
createGrid();
	
});			 // document ready close bracket

function getSelectedMerchant() {
         return merchantid.value;
}
var intervalId = setInterval(function() {
      //$("#list").trigger("reloadGrid",[{current:true}]);
      jQuery("#list").jqGrid("setGridParam", {datatype: "xml"}).trigger("reloadGrid",[{page:1}]);
  }, 30000);
  
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
                            <a href="index.php">Home</a>
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
            <tr><td valign="top" width="100">Wajib Pajak</td>
                  <td valign="top">
                      <?php include "select_merchant.php"; ?>
                  </td>
              </tr>
              <tr>
                  <td>Tanggal Awal</td>
                  <td><!--<input type="date" id="date1" name="date1">-->
                  <input type="text" id="datepicker1" name="datepicker1" style="border: 1px solid  #AAAAAA;font-size: 11px;"><span style="font-size: 9px;font-style: italic;">*dd/mm/yyyy</span>
                  </td>
              </tr>
              <tr>
                  <td>Tanggal Akhir</td>
                  <td>
                  <input type="text" id="datepicker2" name="datepicker2" style="border: 1px solid  #AAAAAA;font-size: 11px;"><span style="font-size: 9px;font-style: italic;">*dd/mm/yyyy</span>
                  </td>
              </tr>
            <tr>
            <td colspan="2">
                        <input type=submit value="tampilkan >>" id="go" name="go" class="button"><br>
            </td>
            </tr>

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

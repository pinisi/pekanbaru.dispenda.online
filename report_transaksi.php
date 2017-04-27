<?php  
   require_once "secure.php";
?>  
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8" />
<?php include "title.php";?>
<!-- ================================================== -->
<!-- Stylesheet-->
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/mobile.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/owl.carousel.css">
<link href='http://fonts.googleapis.com/css?family=Roboto:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<!--<script src="js/jquery.min.js"></script>-->
<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- datepicker -->
<!--<link rel="stylesheet" href="jquery-ui/style.css">-->
<link rel="stylesheet" href="jquery-ui/jquery-ui.css">
<script src="jquery-ui/external/jquery/jquery.js"></script>
<script src="jquery-ui/jquery-ui.js"></script>

<!-- jqGrid -->	
<link type="text/css" href="jquery-ui/jquery-ui.theme.min.css" rel="stylesheet" />
<link type="text/css" href="jqGrid/css/ui.jqgrid.css" rel="stylesheet" />
<script type="text/javascript" src="jquery-ui/jquery-ui.js"></script>
<script src="jqGrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="jqGrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function () {

var createGrid= function() {
	$("#list").jqGrid({
		url: "data_transaksi.php",
        datatype: "xml",
        mtype: "GET",
		width:900,
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

<body class="adminpage">
<?php include "adminheader.php";?>
<div class="container">
  <div class="row headerlistmerchant">
    <div class="col-lg-12" style="padding-top: 8px;">
      <h3 class="pagetitle">Rincian Transaksi</h3>
    </div>
    <!--<div class="col-lg-6 searchmerchant">
      <div style="float:right" class="form-inline">
        <input type="text" class="form-control" placeholder="Search Merchant">
        <button class="btn btn-labeled btn-warning" type="button"> <span class="btn-label"><i class="fa fa-warning"></i> </span>Warning</button>
      </div>
    </div>-->
  </div>

  <div class="row">
	<div class="col-lg-12">
          <table align="left" border="0" width="500">
            <tr><td valign="top" width="100"><span style="font-size: 11px;">Wajib Pajak</span></td>
                  <td valign="top">
                      <?php include "select_merchant.php"; ?>
                  </td>
              </tr>
              <tr>
                  <td><span style="font-size: 11px;">Tanggal Awal</span></td>
                  <td><!--<input type="date" id="date1" name="date1">-->
                  <input type="text" id="datepicker1" name="datepicker1" style="border: 1px solid  #AAAAAA;font-size: 11px;"><span style="font-size: 9px;font-style: italic;">*dd/mm/yyyy</span>
                  </td>
              </tr>
              <tr>
                  <td><span style="font-size: 11px;">Tanggal Akhir</span></td>
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
 <?php include "footer_dukung.php";?>
</div>
<div class="footer2">&copy; 2015 Simpoda</div>
</body>
</html>

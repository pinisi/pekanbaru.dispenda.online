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
<!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">-->
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

<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="jqplot/excanvas.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="jqplot/jquery.jqplot.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot/plugins/jqplot.logAxisRenderer.js"></script>
<script language="javascript" type="text/javascript" src="jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot/plugins/jqplot.enhancedLegendRenderer.min.js"</script>
<script type="text/javascript" src="jqplot/plugins/jqplot.categoryAxisRenderer.js"></script>
<script type="text/javascript" src="jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<!--<script type="text/javascript" src="jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>-->
<script type="text/javascript" src="jqplot/plugins/jqplot.pointLabels.min.js"></script>
<script type="text/javascript" src="jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="jqplot/plugins/jqplot.json2.min.js"></script>
<link rel="stylesheet" type="text/css" href="jqplot/jquery.jqplot.css" />

<script type="text/javascript">
$(document).ready(function () {
var myChartTitle = "Laporan Wajib Pajak";
var jsonurl;
var plotData;
var plot1;

var createPlot = function (plotData) {
plot1 = $.jqplot('chart1', plotData.values[0], {
    title: myChartTitle,
    seriesDefaults:{
          renderer:$.jqplot.BarRenderer,
          rendererOptions: {
                varyBarColor: true
          },
          pointLabels: { show: false , location: 'n'}
    },
    axes: {
          xaxis: {
                 //renderer: $.jqplot.DateAxisRenderer
                 renderer: $.jqplot.CategoryAxisRenderer,
                 ticks: plotData.labels,
                 tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
                 tickOptions: {
                           angle: -30,
                           fontSize: '8pt'
                           }
              },
          yaxis: {
               tickOptions: {formatString: "%'d" }
          }

    },
    highlighter: { show: false }
});
return plot1;
}

var ajaxDataRenderer = function(url, plot) {
    var ret = null;
    $.ajax({
        async: false,
        url: url,
        dataType:"json",
        success: function(data) {
         ret = data;
        }
    });
   return ret;
};

$.jqplot.config.enablePlugins = true;
$.jqplot.sprintf.thousandsSeparator = ',';



var createGrid= function() {
	$("#list").jqGrid({
		url: "data_report_wp_d.php",
        datatype: "xml",
        mtype: "GET",
		width:900,
		height:400,
        postData: {
            'merchant': function() { return getSelectedMerchant();},
            'tanggal1': function() { return datepicker1.value;},
            'tanggal2': function() { return datepicker2.value}
        },
        colNames: ["Wajib Pajak", "Tanggal Transaksi", "Pajak"],
        colModel: [
            { name: "wpname", width: 80, align: "Left" },
			{ name: "tgltransaksi", index: "tgltransaksi", width: 60},            
            { name: "pajak", width: 30, align: "right", formatter: 'number', summaryType:'sum'},
        ],
        pager: "#pager",
        rowNum: 300,
        rowList: [20, 40, 60],
        sortname: "tgltransaksi",
        sortorder: "desc",
        viewrecords: true,
        gridview: true,
        autoencode: true,
        caption: 'Laporan per Wajib Pajak',
        grouping: true,
		groupingView : {
			groupField : ['wpname'],
			groupColumnShow : [true],
			groupText : ['<b>{0}</b>'],
			groupCollapse : false,
			groupOrder: ['asc'],
			groupSummary : [true],
			showSummaryOnHide: true,
			groupDataSorted : true
		},
        footerrow : true,
        userDataOnFooter : true,
  		
	}); 
	 jQuery("#list").jqGrid('navGrid','#pager',{edit:false,refresh:true,search:false,add:false,del:false})
      .navButtonAdd('#pager',{
                                caption: "Export to Excel",
                                buttonicon: "ui-icon-save",
                                onClickButton: function() {
                                     //alert("here");
                                     window.open("xls_wp_d.php" + "?merchantid=" + getSelectedMerchant() + "&tanggal1=" + datepicker1.value + "&tanggal2=" + datepicker2.value, '_blank');
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
        
		jsonurl = "./chart_report_wp_d.php" + "?merchantid=" + getSelectedMerchant() +  "&tanggal1=" + datepicker1.value + "&tanggal2=" + datepicker2.value;
		plotData = ajaxDataRenderer(jsonurl);
		if (plot1) {
		   plot1.destroy();
		}
		if (plotData) {
				myChartTitle = "Laporan Wajib Pajak<br>";// + datepicker1.value + " - " + datepicker2.value;
				plot1 = createPlot(plotData);
		}		
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
//document.getElementById("datepicker1").value = (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear();
document.getElementById("datepicker1").value = ('0' + date.getDate()).slice(-2) + '/' + ( '0' + (date.getMonth() + 1)).slice(-2) +  '/' +  date.getFullYear();
//document.getElementById("datepicker2").value = (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear();
date = new Date();
document.getElementById("datepicker2").value = ('0' + date.getDate()).slice(-2) + '/' + ( '0' + (date.getMonth() + 1)).slice(-2) +  '/' +  date.getFullYear();
	
createGrid();


jsonurl = "./chart_report_wp_d.php?merchantid=all" + "&tanggal1=" + datepicker1.value + "&tanggal2=" + datepicker2.value;
plotData = ajaxDataRenderer(jsonurl);
if (plotData) {
    myChartTitle = "Laporan Wajib Pajak<br>" + datepicker1.value + " - " + datepicker2.value;
    plot1 = createPlot(plotData);
}


	
});			 // document ready close bracket

/*function getSelectedMerchant() {
         return merchantid.value;
}*/
var intervalId = setInterval(function() {
      //$("#list").trigger("reloadGrid",[{current:true}]);
      jQuery("#list").jqGrid("setGridParam", {datatype: "xml"}).trigger("reloadGrid",[{page:1}]);
  }, 30000);

function ExposeList() {
  var status = document.getElementById('cbChoices').checked;
  var c = document.getElementById('ScrollCB').getElementsByTagName('input');
  //alert(document.getElementById('ScrollCB').childNodes.length);
  if (status == true) { document.getElementById('ScrollCB').style.display = "none"; }
                 else { document.getElementById('ScrollCB').style.display = 'block'; }

}


function getSelectedMerchant() {
   var status = document.getElementById('cbChoices').checked;
   var c = document.getElementById('ScrollCB').getElementsByTagName('input');
   var checkString=[];
   if (status == true) {
         checkString.push('all');
   }else {
      for (var i = 0; i < c.length; i++) {
                if (c[i].type == 'checkbox') {
                    if (c[i].checked) {
                        checkString.push(c[i].value);
                    }
                }
      }
   }

   return checkString;
}  	
</script>
</head>

<body class="adminpage">

<?php include "adminheader.php";?>
<div class="container">
  <div class="row headerlistmerchant">
    <div class="col-lg-6" style="padding-top: 8px;">
      <h3 class="pagetitle">Laporan Wajib Pajak</h3>
    </div>
    <div class="col-lg-6" style="text-align: right;padding-top: 8px">
      <a href="report_wp.php">monthly</a>&nbsp;&nbsp;&nbsp;<img src="images/checked.jpeg" width="14"><span style="font-weight: bold;font-size: 14px;color: blue">daily</span>
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
				      <input type="checkbox" id="cbChoices" name="cbChoices" onclick="ExposeList()" checked><span style="font-size: 11px;">All</span><br>
					  <?php include "checkbox_merchant.php"; ?>
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
		<br>
		<a id="chart"></a>
		<a href=#top><span style="font-size: 9px;font-style: italic;">back to top</span></a>
		<div id="chart1" style="height:500px;width:800px; "></div>
		
	  <!--</div>-->
	</div>
 </div>
 <?php include "footer_dukung.php";?>
</div>
<!--<div class=" footer2">&copy; 2015 Simpoda</div>-->
<?php include "footer_bottom.php"; ?>
<script language="javascript">

</script>
</body>
</html>

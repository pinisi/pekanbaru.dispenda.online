<?php
//phpinfo();
include "init_dbconnection.php";
error_reporting(E_ALL);
include_once 'Classes/PHPExcel.php';
include 'inc/xls_style.php';

$where = "";

if (isset($_GET['merchantid'])) {
$merchantid = $_GET['merchantid'];
if ($merchantid == 'all') {
    $where = "";
} else {
//    $where .= " AND (merchant.id=$merchantid)";
   $where .= " AND (merchant.id in ($merchantid))";
}
}

$header_tanggal_on = false;
if (isset($_GET["tanggal1"]) && isset($_GET["tanggal2"])) {
   $where .= " AND (tgltransaksi between concat(str_to_date('" . $_GET["tanggal1"] ."','%d/%m/%Y'),' 00:00:00')"
   . " AND concat(str_to_date('" . $_GET['tanggal2'] . "','%d/%m/%Y'),' 23:59:59'))";

   $header_tanggal_on = true;
};

$SQL = "SELECT ucase(device.wpname) as wpname, DATE_FORMAT(tgltransaksi,'%d/%m/%Y') as 'tanggal',"
. " sum(round( (select nilai_pajak from kategori where device.kategoriid = id) * struk.jumlah, 2)) as pajak"
. " FROM struk,device "
. " WHERE struk.deviceid = device.deviceid"
. $where . " GROUP BY DATE_FORMAT(tgltransaksi,'%d/%m/%Y'), wpname"
. " ORDER BY wpname, tgltransaksi";

$result = mysql_query( $SQL ) or die("Couldn?t execute query.".mysql_error());


$objXLS = new PHPExcel();
$objSheet = $objXLS -> setActiveSheetIndex(0);

//        Set the Labels for each data series we want to plot
//                Datatype
//                Cell reference for data
//                Format Code
//                Number of datapoints in series
//                Data values
//                Data Marker

$categoriesRange = "";
$valuesRange = "";

$chartData = array();


if (mysql_num_rows($result) > 0) {

   $header_rownum = 5;
   $i=6; $ctr=0;
   $group1="";
   $subtotal = 0;
   while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
       if ($group1 != "") {
          if ($group1 != $row['wpname']) {
             $ctr++;
             $objSheet->setCellValue('A' . $i, $group1 );  
             $objSheet->setCellValue('C' . $i, $subtotal );
             $objXLS->getActiveSheet()->getStyle('C' . $i)->getNumberFormat()->setFormatCode("#,##0");
             $objXLS->getActiveSheet()->getStyle('A'.$i.':C'. $i)->getFont()->setBold(true);
             $chartData[] = array($group1 , $subtotal);

	     if ($valuesRange == "") {
                 $valuesRange = 'Worksheet!$D'.$i;
                 $categoriesRange = 'Worksheet!$A'.$i;
             } else {
                 $valuesRange .= ',Worksheet!$D'.$i;
                 $categoriesRange .= ',Worksheet!$A'.$i;
             }


             $subtotal = 0;
             $i++;
             
          }
       }
       $objSheet->setCellValue('A' . $i, $row['wpname'] ); 
       $objSheet->setCellValue('C' . $i, $row['tanggal'] );
       $objSheet->setCellValue('D' . $i, $row['pajak'] );
       $objXLS->getActiveSheet()->getStyle('C' . $i)->getNumberFormat()->setFormatCode("#,##0");
       $group1 = $row['wpname'];
       $subtotal += $row['pajak'];
       $i++;
   }

       if ($group1 != "") {
          if ($group1 != $row['wpname']) {  
             $ctr++;
             $objSheet->setCellValue('A' . $i, $group1 );
             $objSheet->setCellValue('D' . $i, $subtotal );
             $objXLS->getActiveSheet()->getStyle('C' . $i)->getNumberFormat()->setFormatCode("#,##0");
             $objXLS->getActiveSheet()->getStyle('A'.$i.':C'. $i)->getFont()->setBold(true);
             $chartData[] = array($group1 , $subtotal);
 
             if ($valuesRange == "") {
                 $valuesRange = 'Worksheet!$C'.$i;
                 $categoriesRange = 'Worksheet!$A'.$i;
             } else {
                 $valuesRange .= ',Worksheet!$C'.$i;
                 $categoriesRange .= ',Worksheet!$A'.$i;
             }


             $subtotal = 0;
             $i++;
          }
       }


   $objSheet->setCellValue('A' . $header_rownum,'Merchant Name');
   $objSheet->setCellValue('C' . $header_rownum,'Tanggal');
   $objSheet->setCellValue('D' . $header_rownum,'Total Pajak');


   $objSheet->setCellValue('A1', 'Laporan Wajib Pajak');
   $objXLS->getActiveSheet()->mergeCells('A1:C1');
   $objXLS->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
   $objXLS->getActiveSheet()->getStyle('A1:C1')->getFont()->setSize(20);
   $objXLS->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);

   if ($header_tanggal_on) {
       $objSheet->setCellValue('A2', $_GET["tanggal1"] . " - " . $_GET["tanggal2"]);
       $objXLS->getActiveSheet()->mergeCells('A2:C2');
       $objXLS->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       $objXLS->getActiveSheet()->getStyle('A2:C2')->getFont()->setSize(16);
       $objXLS->getActiveSheet()->getStyle('A2:C2')->getFont()->setBold(true);
   }

   $chartSheet = $objXLS->createSheet(1);
   $chartSheet->setTitle("chart");

   $chartSheet->fromArray($chartData);


   //Starts Formatting...

   $objXLS->getActiveSheet()->getStyle("A" . $header_rownum . ":D" . $header_rownum)->getFont()->setBold(true);
   $objXLS->getActiveSheet()->getStyle("A" . $header_rownum . ":D" . $header_rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
   $objXLS->getActiveSheet()->getStyle("A" . $header_rownum . ":D" . $header_rownum)->applyFromArray($headerStyle);

   $objXLS->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
   $objXLS->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
   $objXLS->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
   $objXLS->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);

   $objXLS->getActiveSheet()->getStyle('A' . $header_rownum . ':D'.($i-1))->applyFromArray($borderStyle1);
  
   //$objXLS->getActiveSheet()->setTitle('Laporan Harian');
   //$objXLS->setActiveSheetIndex(0);

/*
   $labels = array(
     new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$5', null, 1)
     // new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', null, 1),
   );
*/

 
   $categories = array (
          new PHPExcel_Chart_DataSeriesValues('String', 'chart!$A$1:$A$' . $ctr, null, $ctr)
   );

   $values = array (
          new PHPExcel_Chart_DataSeriesValues('Number', 'chart!$B$1:$B$' . $ctr, null, $ctr)
   );

   $series = new PHPExcel_Chart_DataSeries(
        PHPExcel_Chart_DataSeries::TYPE_BARCHART,       // plotType
        PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping
        array(0),                                       // plotOrder
        array(),                                        // plotLabel
        $categories,                                    // plotCategory
        $values                                         // plotValues
   );


   $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
   $plotarea = new PHPExcel_Chart_PlotArea(null, array($series));
   $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, null, false);
   $chartTitle = new PHPExcel_Chart_Title('Laporan Wajib Pajak');
   $chart = new PHPExcel_Chart(
        'chart1',                                       // name
        $chartTitle,                                    // title
        null,                                           // legend
        $plotarea,                                      // plotArea
        true,                                           // plotVisibleOnly
        0,                                              // displayBlanksAs
        null,                                           // xAxisLabel
        null                                            // yAxisLabel
   );

   $chart->setTopLeftPosition('E5');
   $chart->setBottomRightPosition('N25');

   $objXLS->getActiveSheet()->addChart($chart);

   $objWriter = PHPExcel_IOFactory::createWriter($objXLS,'Excel2007');
   $objWriter->setIncludeCharts(TRUE);

//$objWriter->save(__DIR__ . "/hasil.xls");
// We'll be outputting an excel file
   header('Content-type: application/vnd.ms-excel');

// It will be called file.xls
   header('Content-Disposition: attachment; filename="LaporanWP_Harian.xlsx"');

   $objWriter->save('php://output');

} else {

   $objWriter = PHPExcel_IOFactory::createWriter($objXLS,'Excel5');

   header('Content-type: application/vnd.ms-excel');

// It will be called file.xls
   header('Content-Disposition: attachment; filename="no_record_found.xls"');

   $objWriter->save('php://output');

}

?>

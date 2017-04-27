<?php
//phpinfo();
require "secure.php";
include "init_dbconnection.php";
error_reporting(E_ALL);
include_once 'Classes/PHPExcel.php';
include 'inc/xls_style.php';

$where = "";


$header_tanggal_on = false;
if (isset($_GET["bulan"]) && isset($_GET["tahun"])) {
   $where .= " AND DATE_FORMAT(tgltransaksi,'%Y%m') = '" . $_GET["tahun"].$_GET["bulan"] ."'";
   $header_tanggal_on = true;
};

$num_of_days = cal_days_in_month(CAL_GREGORIAN, $_GET["bulan"], $_GET["tahun"]); 


$SQL = "SELECT wpname"
. ",device.msisdn as TMD"
. ",DATE_FORMAT(tgltransaksi,'%Y-%m-%d') as tanggal,count(struk.jumlah) as jumlah "
. ",device.deviceid as Data"
. " FROM struk,device"
. " WHERE struk.deviceid = device.deviceid"
. $where . " GROUP BY wpname,DATE_FORMAT(tgltransaksi,'%Y-%m-%d')"
. " ORDER BY wpname, tgltransaksi";



$result = mysql_query( $SQL ) or die("Couldn?t execute query.".mysql_error());

$styleArray = array(
        'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => 'FF0000'),
        'size'  => 15,
        'name'  => 'Verdana'
));

$objXLS = new PHPExcel();
$objSheet = $objXLS -> setActiveSheetIndex(0);

if (mysql_num_rows($result) > 0) {

   // A = char(65);

   // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
   $month_string = array ("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

 
   $header_rownum = 4;
   $i=6;
   $start_col = 4;
   $number=0;
   $row=0;
   $subtotal=0;
   $temp_wpname="";
   while($rec = mysql_fetch_array($result,MYSQL_ASSOC)) {
       if ($temp_wpname != $rec['wpname']) {
          $number++;
          $row = $i;
          $objSheet->setCellValue('B' . $i, $number ); 
          $objSheet->setCellValue('C' . $i, $rec['wpname'] );
          $objSheet->setCellValue('D' . $i, $rec['TMD'] );
          $objSheet->setCellValue('E' . $i, $rec['Data'] );
          $temp_wpname = $rec['wpname'];
          $i++;
       } 
       $tgl  = explode("-",$rec['tanggal']);
       $objSheet->setCellValueByColumnAndRow($start_col + $tgl[2],$row,$rec['jumlah']);
   }
   // HEADER
   for ($i = 1; $i <= $num_of_days; $i++) {
       $objSheet->setCellValueByColumnAndRow(4 + $i, 5, $i);    
   }

   $objSheet->setCellValue('F4', 'Jumlah Transaksi Masuk (Per Hari/Tanggal)');

   $mergeRange = PHPExcel_Cell::stringFromColumnIndex($start_col + 1) . '4:' .
                 PHPExcel_Cell::stringFromColumnIndex($start_col + $num_of_days) . '4';
   $objXLS->getActiveSheet()->mergeCells($mergeRange);

   $mergeRange = 'B2:' .
                 PHPExcel_Cell::stringFromColumnIndex($start_col + $num_of_days) . '2';
   $objXLS->getActiveSheet()->mergeCells($mergeRange);

   $mergeRange = 'B3:' .
                 PHPExcel_Cell::stringFromColumnIndex($start_col + $num_of_days) . '3';
   $objXLS->getActiveSheet()->mergeCells($mergeRange);

   $objSheet->setCellValue('B2','LAPORAN HASIL PENGHIMPUNAN DATA');
   $objSheet->setCellValue('B3','PERIODE ' . $month_string[$_GET['bulan']-1] . ' ' . $_GET['tahun']);

   $objXLS->getActiveSheet()->mergeCells('B4:B5'); $objSheet->setCellValue('B4','No.');
   $objXLS->getActiveSheet()->mergeCells('C4:C5'); $objSheet->setCellValue('C4','NOPD');
   $objXLS->getActiveSheet()->mergeCells('D4:D5'); $objSheet->setCellValue('D4','TMD');
   $objXLS->getActiveSheet()->mergeCells('E4:E5'); $objSheet->setCellValue('E4','Data');

  

   $objXLS->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
   $objXLS->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
   $objXLS->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
   $objXLS->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
   $objXLS->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
   $objXLS->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
   $objXLS->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

   //$objXLS->getActiveSheet()->getStyle('F6' . ':' . PHPExcel_Cell::stringFromColumnIndex($start_col + $num_of_days) . $row)->getNumberFormat()->setFormatCode("#,##0");
   //$objXLS->getActiveSheet()->getStyle('B2:' . PHPExcel_Cell::stringFromColumnIndex($start_col + $num_of_days). '3')->getFont()->setBold(true);


   $objXLS->getActiveSheet()->getStyle("B2")->applyFromArray($titleStyle);
   $objXLS->getActiveSheet()->getStyle("B" . $header_rownum . ":" . PHPExcel_Cell::stringFromColumnIndex($start_col + $num_of_days) . "5" )->applyFromArray($headerStyle);


   $objXLS->getActiveSheet()->getStyle('B' . $header_rownum . ':' . PHPExcel_Cell::stringFromColumnIndex($start_col + $num_of_days) . ($row) )->applyFromArray($borderStyle1);
   

   for ($i = 2; $i <= ($start_col + $num_of_days); $i++) {
       $objXLS->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
   }


  

/*
   $objSheet->setCellValue('A' . $i, 'Total');
   $objSheet->setCellValue('B' . $i, $subtotal);

   $objSheet->setCellValue('A' . $header_rownum,'Tanggal');
   $objSheet->setCellValue('B' . $header_rownum,'Total Transaksi');

   $objSheet->setCellValue('A1', 'Laporan Total');
   $objXLS->getActiveSheet()->mergeCells('A1:B1');
   $objXLS->getActiveSheet()->getStyle('A1:B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
   $objXLS->getActiveSheet()->getStyle('A1:B1')->getFont()->setSize(20);
   $objXLS->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);
   $objXLS->getActiveSheet()->getStyle('A' . $i . ':B' . $i)->getFont()->setBold(true);
   $objXLS->getActiveSheet()->getStyle('A' . $i . ':B' . $i)->getNumberFormat()->setFormatCode("#,##0");

   if ($header_tanggal_on) {
       $objSheet->setCellValue('A2', $_GET["tanggal1"] . " - " . $_GET["tanggal2"]);
       $objXLS->getActiveSheet()->mergeCells('A2:B2');
       $objXLS->getActiveSheet()->getStyle('A2:B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       $objXLS->getActiveSheet()->getStyle('A2:B2')->getFont()->setSize(16);
       $objXLS->getActiveSheet()->getStyle('A2:B2')->getFont()->setBold(true);
   }

   //Starts Formatting...

   $objXLS->getActiveSheet()->getStyle("A" . $header_rownum . ":B" . $header_rownum)->getFont()->setBold(true);
   $objXLS->getActiveSheet()->getStyle("A" . $header_rownum . ":B" . $header_rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
   $objXLS->getActiveSheet()->getStyle("A" . $header_rownum . ":B" . $header_rownum)->applyFromArray($headerStyle);

   $objXLS->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
   $objXLS->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);

   $objXLS->getActiveSheet()->getStyle('A' . $header_rownum . ':B'.($i-1))->applyFromArray($borderStyle1);
  
   //$objXLS->getActiveSheet()->setTitle('Laporan Total');
*/
 
   $objWriter = PHPExcel_IOFactory::createWriter($objXLS,'Excel2007');

//$objWriter->save(__DIR__ . "/hasil.xls");
// We'll be outputting an excel file
   header('Content-type: application/vnd.ms-excel');

// It will be called file.xls
   header('Content-Disposition: attachment; filename="BTM_laporan_penghimpunan_data.xlsx"');
   
   $objWriter->save('php://output');

} else {

   $objWriter = PHPExcel_IOFactory::createWriter($objXLS,'Excel5');

   header('Content-type: application/vnd.ms-excel');

// It will be called file.xls
   header('Content-Disposition: attachment; filename="no_record_found.xls"');

   $objWriter->save('php://output');

}

?>

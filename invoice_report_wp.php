<?php
require_once "secure.php";
require "fpdf17/fpdf.php";
include("init_dbconnection.php");
include("simpoda_function.php");

class FPDF_CellFit extends FPDF {

    //Cell with horizontal scaling if text is too wide
    function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)
    {
        //Get string width
        $str_width=$this->GetStringWidth($txt);

        //Calculate ratio to fit cell
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $ratio = ($w-$this->cMargin*2)/$str_width;

        $fit = ($ratio < 1 || ($ratio > 1 && $force));
        if ($fit)
        {
            if ($scale)
            {
                //Calculate horizontal scaling
                $horiz_scale=$ratio*100.0;
                //Set horizontal scaling
                $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
            }
            else
            {
                //Calculate character spacing in points
                $char_space=($w-$this->cMargin*2-$str_width)/max($this->MBGetStringLength($txt)-1,1)*$this->k;
                //Set character spacing
                $this->_out(sprintf('BT %.2F Tc ET',$char_space));
            }
            //Override user alignment (since text will fill up cell)
            $align='';
        }

        //Pass on to Cell method
        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);

        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
    }

    //Cell with horizontal scaling only if necessary
    function CellFitScale($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,false);
    }

    //Cell with horizontal scaling always
    function CellFitScaleForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,true);
    }

    //Cell with character spacing only if necessary
    function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);
    }

    //Cell with character spacing always
    function CellFitSpaceForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        //Same as calling CellFit directly
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,true);
    }

    //Patch to also work with CJK double-byte text
    function MBGetStringLength($s)
    {
        if($this->CurrentFont['type']=='Type0')
        {
            $len = 0;
            $nbbytes = strlen($s);
            for ($i = 0; $i < $nbbytes; $i++)
            {
                if (ord($s[$i])<128)
                    $len++;
                else
                {
                    $len++;
                    $i++;
                }
            }
            return $len;
        }
        else
            return strlen($s);
    }

}

$bulan = array (
	"JANUARY" => "JANUARI",
	"FEBRUARY" => "FEBRUARI",
	"MARCH" => "MARET",
	"APRIL" => "APRIL",
	"MAY" => "MEI",
	"JUNE" => "JUNI",
	"JULY" => "JULI",
	"AUGUST" => "AGUSTUS",
	"SEPTEMBER" => "SEPTEMBER",
	"OCTOBER" => "OKTOBER",
	"NOVEMBER" => "NOPEMBER",
	"DECEMBER" => "DESEMBER",	
);

$where = "";
$merchant = "";
$month = "";
$jumlah = 0;

if (isset($_GET['p'])) {
   $p = explode("|",$_GET['p']);
}

$periode = explode("-",$p[1]);

$m = array_search(strtoupper($periode[0]), array_keys($bulan)) + 1;
$y = $periode[1];
$strdate = "1-" . $m. "-" . $y;
//$arr_tempo = explode("-", date("d-F-Y", strtotime ("+15 days", strtotime($strdate)) ));
$arr_tempo = explode("-", date("d-F-Y",strtotime('+15 days')) );
$tempo = $arr_tempo[0] . " " . $bulan[strtoupper($arr_tempo[1])] . " " . $arr_tempo[2];

/*
$SQL = "SELECT * FROM device, kategori WHERE device.id = " . $id
  ." AND device.kategoriid=kategori.id";

$result = mysql_query( $SQL ) or die("Couldn?t execute query.".mysql_error());

*/



$pdf = new FPDF_CellFit();

$pdf->addPage();

$pdf->Image('img/LogoKabupatenKarawang.png', 8, 10,13); 

////////////////////////HEADER START ////////////////////////////////
//// HEADER 1 ////


$pdf->setFont('Arial','B',10);
$pdf->setXY(15,7); $pdf->Cell(70,10,'PEMERINTAH KABUPATEN KARAWANG',0,0,'C');
$pdf->setXY(15,12); $pdf->Cell(70,10,'BADAN PENDAPATAN DAERAH',0,0,'C');
$pdf->setFont('','',10);
$pdf->setXY(15,17); $pdf->Cell(70,10,'Jl. ',0,0,'C');
$pdf->setXY(15,22); $pdf->Cell(70,10,'Tlp. ',0,0,'C');

$pdf->setFont('','',18);
$pdf->setXY(80,7); $pdf->Cell(75,10,'S K P D',0,0,'C');
$pdf->setFont('','',11);
$pdf->setXY(80,12);$pdf->Cell(75,10,'SURAT KETETAPAN PAJAK DAERAH',0,0,'C');
$pdf->setXY(80,18);$pdf->Cell(75,10,'Masa Pajak:  ' . $bulan[strtoupper($periode[0])],0,0,'C');
$pdf->setXY(80,23);$pdf->Cell(75,10,'Tahun:  '. $periode[1],0,0,'C');

$pdf->setXY(155,7);
$pdf->Cell(50,10,'NOMOR KOHIR',0,0,'C');






$pdf->Ln(15);
$pdf->Cell(1);




//A4 page is 210mm wide,
//$pdf->Line(5, 35, 210-5, 35);
//$pdf->Line(5, 5, 210-5, 5);

$pdf->Rect(5, 5, 75, 30);
$pdf->Rect(80, 5, 75, 30);
$pdf->Rect(155, 5, 50, 30);


//// HEADER 2 ////

$pdf->Ln(15);
$pdf->Cell(70,10,'Nama WP :',0,0,'R');
$pdf->Cell(130,10,$p[3],0,0,'L');

$pdf->Ln(5);
$pdf->Cell(70,10,'Alamat WP :',0,0,'R');
$pdf->Cell(130,10,$p[4],0,0,'L');

$pdf->Ln(5);
$pdf->Cell(70,10,'N P W P D :',0,0,'R');
$pdf->Cell(130,10,'010101010',0,0,'L');

$pdf->Ln(5);
$pdf->Cell(70,10,'Tanggal Jatuh Tempo Pembayaran :',0,0,'R');
//$pdf->Cell(130,10,'01 JUNI 2015',0,0,'L');
$pdf->Cell(130,10,$tempo,0,0,'L');
$pdf->Rect(5, 35, 200, 35);

//// HEADER 3 ///
$pdf->setXY(5,70);
$pdf->Cell(15,10,'No.',1,0,'C');
$pdf->Cell(45,10,'Nomor Rekening',1,0,'C');
$pdf->Cell(90,10,'Jenis Pajak Daerah',1,0,'C');
$pdf->Cell(50,10,'Jumlah',1,0,'C');

////////////////////////HEADER END ////////////////////////////////

//CONTENT
$pdf->setXY(5,80);
$pdf->Cell(15,10,'1.',0,0,'L');
$pdf->Cell(45,10,'411.01',0,0,'C');
$pdf->Cell(90,10,'PAJAK ' . $p[5],0,0,'L');
$pdf->Cell(50,10,'Rp. ' . number_format( $p[2], 0 , '' , ',' ),0,0,'R');


//$pdf->Rect(5, 80, 200, 35);
$pdf->Rect(5, 80, 15, 35);
$pdf->Rect(20, 80, 45, 35);
$pdf->Rect(65, 80, 90, 35);
$pdf->Rect(155, 80, 50, 35);


$pdf->setXY(65,115);
$pdf->Cell(90,10,'JUMLAH KETETAPAN POKOK PAJAK',0,0,'L');
$pdf->Cell(50,10,'Rp. ' . number_format( $p[2], 0 , '' , ',' ),0,0,'R');

$pdf->Rect(5, 115, 60, 30);
$pdf->Rect(65, 115, 90, 30);
$pdf->Rect(155, 115, 50, 30);

$pdf->setXY(5,145);
$pdf->Cell(30,10,'Dengan Huruf:',0,0,'L');
$pdf->setFont('Arial','B',11);
$pdf->SetFillColor(200,200,200);
$pdf->CellFitScale(170,10,strtoupper(terbilang($p[2])),1,1,'C',1);
//$pdf->Cell(170,10,strtoupper(terbilang($p[2])),1,0,'C',true);

$pdf->SetFillColor(0,0,0);
$pdf->setFont('Arial','',11);
$pdf->Rect(5, 145, 200, 20);


//--- 
$pdf->setXY(20,165);
$pdf->Cell(20,10,'PERHATIAN',0,0,'L');
$pdf->setXY(20,170);
$pdf->setFont('Arial','',9);
$pdf->Cell(25,10,'1. HARAP PENYETORAN DILAKUKAN MELALUI BKP ATAU BENDAHARA UMUM DAERAH PADA BANK RIAU ',0,0,'L');
$pdf->setXY(23,174);
$pdf->Cell(25,10,'CABANG BATAM DENGAN MENGGUNAKAN SURAT SETORAN PAJAK DAERAH (SSPD)',0,0,'L');
$pdf->setXY(20,179);
$pdf->Cell(25,10,'2. APABILA SKPD INI TIDAK ATAU KURANG DIBAYAR SETELAH LEWAT WAKTU PALING LAMA 30 HARI SEJAK',0,0,'L');
$pdf->setXY(23,183);
$pdf->Cell(25,10,'SKPD INI DITERIMA DIKENAKAN SANKSI ADMINISTRASI BERUPA BUNGA SEBESAR 2% PER BULAN',0,0,'L');

$pdf->Rect(5, 165, 200, 40);

//---
$pdf->setXY(150,210);
$pdf->Cell(25,10,'BATAM, ' . date('j') . ' ' . $bulan[strtoupper(date('F'))] . ' ' . date('Y'),0,0,'L');

$pdf->setXY(30,215);
$pdf->Cell(25,10,'Yang Menerima,',0,0,'L');

$pdf->setXY(140,215);
$pdf->Cell(25,10,'An. Kepala Dinas Pendapatan Daerah',0,0,'L');
$pdf->setXY(150,219);
$pdf->Cell(25,10,'Kepala Bidang Penetapan',0,0,'L');


$pdf->Rect(5, 205, 200, 70);








$pdf->Output();




$where = "";
/*
if (isset($_GET['merchantid'])) {
if ($_GET['merchantid'] == "all" ) {
   $where = "";
} else {
   $where =  " AND merchant.id in ("  . $_GET['merchantid'] . ")";
} 
}

if (isset($_GET["tanggal1"]) && isset($_GET["tanggal2"])) {
  if ($_GET['tanggal1']!="" && $_GET['tanggal2'] != "") {
   $awal = substr($_GET['tanggal1'],3);
   $akhir = substr($_GET['tanggal2'],3);

   $where .= " AND (tgltransaksi between concat(str_to_date(concat('01/','" . $awal . "'), '%d/%m/%Y'),' 00:00:00')"
   . " AND concat(last_day(str_to_date(concat('01/','" . $akhir . "'),'%d/%m/%Y')),' 23:59:59'))";
  }
}


$SQL = "SELECT ucase(wpname) as wpname, sum(round( (select nilai_pajak from kategori where device.kategoriid = id) * struk.jumlah, 0)) as pajak FROM struk,device"
. " WHERE struk.deviceid = device.deviceid "
. $where .  " GROUP BY wpname";


//$SQL = "SELECT msisdn,status,longitude,lattitude,judul,deskripsi FROM data_gis"
//.$where." ORDER BY $sidx $sord LIMIT $start , $limit";

//echo $SQL;
$result = mysql_query( $SQL ) or die("Couldn?t execute query.".mysql_error());
//$responce->page = $page;
//$responce->total = $total_pages;
//$responce->records = $count;
$i=0;
while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
     //$responce->rows[$i]['id'] = $i;
     //$responce->rows[$i]['cell']=array($row[tanggal],$row[total]);
//     $responce->values[0][$i][0]=$row['total'];
     $responce->values[0][0][$i] = intval($row['pajak']);
     $responce->labels[$i]=$row['wpname'];
//     $responce->values[0][$i][0]= $row['tanggal'] . ',' . intval($row['total']);
     $i++; 
}

if ($i==0) {
    $responce->values=[[[]]];
    $responce->labels=[];
} 
echo json_encode($responce);
*/
?>



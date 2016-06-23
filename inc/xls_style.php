<?php

$titleStyle = array(
    'font' => array (
        'bold'  => true,
        'size'  => 15
    )
);

$styleArray = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => 'FF0000'),
        'size'  => 15,
        'name'  => 'Verdana'
));

$borderStyle1 = array(
       'borders' => array(
             'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => 'B6EAFA'),
             ),
             'inside' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => 'B6EAFA'),
             )
       ),
);

$borderStyle2 = array(
     'borders' => array(
        'left' => array(
             'style' => PHPExcel_Style_Border::BORDER_THIN,
           ),
        'right' => array(
             'style' => PHPExcel_Style_Border::BORDER_THIN,
         ),
        'vertical' => array(
             'style' => PHPExcel_Style_Border::BORDER_THIN,
         ),
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
          'argb' => 'FFFFFFCC',
        ),
      ),
);

$headerStyle = array(
                'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb'=>'EBF6FA'),
                ),
                'font' => array(
                        'bold' => true,
                        'color'=> array('rgb'=>'02A9E0'),
                )
        );
?>

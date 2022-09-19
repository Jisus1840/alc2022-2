<?php

# Importamos librería
include_once ('../lib/PHPExcel/PHPExcel.php');
include_once ('../config/global_includes.php');

class ReporteIngresos {
	# Función para centrar vertical y horizontalmente las celdas
	public function vertical_horizontal_align($objPHPExcel, $celdas) {
		$objPHPExcel->getActiveSheet()->getStyle($celdas)->applyFromArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				)
			)
		);
	}
	
	# Función para pintar borde en la tabla
	public function borde($objPHPExcel, $celdas) {
		$objPHPExcel->getActiveSheet()->getStyle($celdas)->applyFromArray(
			array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			)
		);
	}
}

date_default_timezone_set('America/Mexico_City');
$date = date('Y-m-d', time());

# Traemos los valores enviados de la página anterior
$year = $_POST['year'];
$meses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];

$tramite = new tramite();
$objPHPExcel = new PHPExcel();
$ingresos = new ReporteIngresos();

$cambios_primero = $tramite->get_primer_pago(9, $year);
$cambios_segundo = $tramite->get_segundo_pago(9, $year);

$licencia_primero = $tramite->get_primer_pago(1, $year);
$licencia_segundo = $tramite->get_segundo_pago(1, $year);

$permisos_pagos = $tramite->get_primer_pago(7, $year);

// Set document properties
$objPHPExcel->getProperties()->setCreator("Angelica Rodriguez")
							 ->setLastModifiedBy("Angelica Rodriguez")
							 ->setTitle("Ingresos por mes")
							 ->setSubject("Alcoholes")
							 ->setDescription("Ingresos por mes")
							 ->setKeywords("Ingresos por mes")
							 ->setCategory("Ingresos por mes");
										  
for($col = 'A'; $col !== 'C'; $col++) {
    $objPHPExcel->getActiveSheet()
        ->getColumnDimension($col)
        ->setAutoSize(true);
}

# Encabezados
$objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue('INGRESOS '.$year);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
$ingresos->vertical_horizontal_align($objPHPExcel, 'A1');

$j = 2;
$k = 3;
$grid = $j; 
for($i = 0; $i < count($meses); $i++) {
	$objPHPExcel->getActiveSheet()->mergeCells('A'.($j).':B'.($j));
	$objPHPExcel->getActiveSheet()->getStyle('A'.($j))->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A'.($j))->getFont()->setSize(15);
	$ingresos->vertical_horizontal_align($objPHPExcel, 'A'.($j));
	$objPHPExcel->getActiveSheet()->getCell('A'.($j++))->setValue($meses[$i]);
	$objPHPExcel->getActiveSheet()->getCell('A'.($j++))->setValue('PAGO DE SOLICITUDES CAMBIOS');
	$objPHPExcel->getActiveSheet()->getCell('A'.($j++))->setValue('PAGOS DE AUTORIZACIÓN CAMBIOS');
	$objPHPExcel->getActiveSheet()->getCell('A'.($j++))->setValue('PAGOS DE SOLICITUDES NUEVAS');
	$objPHPExcel->getActiveSheet()->getCell('A'.($j++))->setValue('PAGOS DE AUTORIZACIÓN NUEVAS');
	$objPHPExcel->getActiveSheet()->getCell('A'.($j++))->setValue('PERMISOS');
	$objPHPExcel->getActiveSheet()->getCell('A'.($j++))->setValue('MULTAS');
	$objPHPExcel->getActiveSheet()->getCell('A'.($j++))->setValue('REFRENDOS');
	if($meses[$i] == 'ENERO') {
		$objPHPExcel->getActiveSheet()->getCell('A'.($j++))->setValue('PAGOS DE TRÁMITES DEL AÑO PASADO');
	}
	else {
		$objPHPExcel->getActiveSheet()->getCell('A'.($j++))->setValue('');
	}
	$objPHPExcel->getActiveSheet()->getStyle('A'.($j))->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getCell('A'.($j++))->setValue('TOTAL DE INGRESOS EN '.$meses[$i].' '.$year);
	$ingresos->borde($objPHPExcel, 'A'.$grid.':B'.(--$j));
	
	$objPHPExcel->getActiveSheet()->getCell('B'.($k++))->setValue($cambios_primero[$i]['primer_pago']);
	$objPHPExcel->getActiveSheet()->getCell('B'.($k++))->setValue($cambios_segundo[$i]['segundo_pago']);
	$objPHPExcel->getActiveSheet()->getCell('B'.($k++))->setValue($licencia_primero[$i]['primer_pago']);
	$objPHPExcel->getActiveSheet()->getCell('B'.($k++))->setValue($licencia_segundo[$i]['segundo_pago']);
	$objPHPExcel->getActiveSheet()->getCell('B'.($k++))->setValue($permisos_pagos[$i]['primer_pago']);
	$objPHPExcel->getActiveSheet()->getCell('B'.($k++))->setValue('');
	$objPHPExcel->getActiveSheet()->getCell('B'.($k++))->setValue('');
	$objPHPExcel->getActiveSheet()->getCell('B'.($k++))->setValue('');
	$objPHPExcel->getActiveSheet()->getCell('B'.($k++))->setValue('=SUM(B'.(++$grid).':B'.(--$j).')');
	$k++; $k++;
	$grid = $grid + 10;
	$j++; $j++; $j++;
}

$objPHPExcel->getActiveSheet()->getStyle('B3:B'.($j))->getNumberFormat()->setFormatCode('$ #,##0.00'); 
ob_end_clean(); 

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Ingresos');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

//$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(true);   
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);    
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);  

/*$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
$objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
$objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
$objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
$objPHPExcel->getActiveSheet()->getProtection()->setPassword('aero2020');*/

/*$objPHPExcel->getSecurity()->setLockWindows(true);
$objPHPExcel->getSecurity()->setLockStructure(true);
$objPHPExcel->getSecurity()->setWorkbookPassword("PHPExcel");
*/
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Ingresos.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modifiedinsapp
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;


?>
<?php
# Importamos librería
include_once ('../lib/PHPExcel/PHPExcel.php');
include_once ('../config/global_includes.php');

class ReporteIngresosMensuales {
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
	
	# Función para agregar una celda con contenido
	public function agregar_celda($hoja, $columna, $fila, $texto, $type='s') {
		if($type == 'n') {
			$hoja->setCellValueExplicitByColumnAndRow($columna, $fila, $texto, PHPExcel_Cell_DataType::TYPE_NUMERIC);  
		}
		else {
			$hoja->setCellValueExplicitByColumnAndRow($columna, $fila, $texto, PHPExcel_Cell_DataType::TYPE_STRING);  
		}
	}
}

date_default_timezone_set('America/Mexico_City');
$date = date('Y-m-d', time());
$tramite = new tramite();
$objPHPExcel = new PHPExcel();
$ingresos = new ReporteIngresosMensuales();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Angelica Rodriguez")
							 ->setLastModifiedBy("Angelica Rodriguez")
							 ->setTitle("Ingresos por mes")
							 ->setSubject("Alcoholes")
							 ->setDescription("Ingresos por mes")
							 ->setKeywords("Ingresos por mes")
							 ->setCategory("Ingresos por mes");
										  
for($col = 'A'; $col !== 'E'; $col++) {
    $objPHPExcel->getActiveSheet()
        ->getColumnDimension($col)
        ->setAutoSize(true);
}

$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue('INGRESOS MENSUALES DE ALCOHOLES');
$objPHPExcel->getActiveSheet()->getStyle('A1:H2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:A16')->getFont()->setBold(true);
$year_actual = date('Y');

$years = [];
$a = 0;
for($i = 2020; $i <= $year_actual; $i++) {
	$years[$a] = $i;
	$a++;
}

$objPHPExcel->getActiveSheet()->getCell('A1')->setValue('INGRESOS MENSUALES DE ALCOHOLES');
$ingresos->vertical_horizontal_align($objPHPExcel, 'A1:H2');

$objPHPExcel->getActiveSheet()->getCell('A3')->setValue('ENE');
$objPHPExcel->getActiveSheet()->getCell('A4')->setValue('FEB');
$objPHPExcel->getActiveSheet()->getCell('A5')->setValue('MAR');
$objPHPExcel->getActiveSheet()->getCell('A6')->setValue('ABR');
$objPHPExcel->getActiveSheet()->getCell('A7')->setValue('MAY');
$objPHPExcel->getActiveSheet()->getCell('A8')->setValue('JUN');
$objPHPExcel->getActiveSheet()->getCell('A9')->setValue('JUL');
$objPHPExcel->getActiveSheet()->getCell('A10')->setValue('AGO');
$objPHPExcel->getActiveSheet()->getCell('A11')->setValue('SEP');
$objPHPExcel->getActiveSheet()->getCell('A12')->setValue('OCT');
$objPHPExcel->getActiveSheet()->getCell('A13')->setValue('NOV');
$objPHPExcel->getActiveSheet()->getCell('A14')->setValue('DIC');
$objPHPExcel->getActiveSheet()->getCell('A16')->setValue('TOTALES');

$col = 1;
$letra_anterior = 'A';
$letra_despues = 'B';
$abecedario = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
# Extraemos información por mes por año desde el 2020
for($i = 0; $i < count($years); $i++) {
	$sumatoria_pagos = $tramite->get_sumatoria_total_pagos($years[$i]);
	$ingresos->agregar_celda($objPHPExcel->getActiveSheet(), $col, 2, $years[$i], 'n');
	for($j = 0; $j < 12; $j++) {
		$ingresos->agregar_celda($objPHPExcel->getActiveSheet(), $col, $j+3, $sumatoria_pagos[$j]['total_pagos'], 'n');
	}
	$col++;
}

$ingresos->agregar_celda($objPHPExcel->getActiveSheet(), $col, 2, 'DIFERENCIA', 's');

for($i = 0; $i < 12; $i++) {
	$a = $objPHPExcel->getActiveSheet()->getCell($abecedario[$col-2].($i+3))->getValue(); 
	$b = $objPHPExcel->getActiveSheet()->getCell($abecedario[$col-1].($i+3))->getValue(); 
	$absolute_value = abs($a-$b);
	$ingresos->agregar_celda($objPHPExcel->getActiveSheet(), $col, $i+3, $absolute_value, 'n');
}

$objPHPExcel->getActiveSheet()->getStyle('B3:H16')->getNumberFormat()->setFormatCode('$ #,##0.00'); 
$objPHPExcel->getActiveSheet()->getCell('B16')->setValue('=SUM(B3:B15)'); 
$objPHPExcel->getActiveSheet()->getCell('C16')->setValue('=SUM(C3:C15)'); 
$objPHPExcel->getActiveSheet()->getCell('D16')->setValue('=SUM(D3:D15)'); 

$objPHPExcel->getActiveSheet()->getStyle('B16:D16')->getFont()->setBold(true);

$ingresos->borde($objPHPExcel, 'A1:'.$abecedario[$col].'16');

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
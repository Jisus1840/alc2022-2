<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Clase gdocs, genera pdf con clases tcpdf
*********************************************************************************
*/

class MYPDFCLASS extends TCPDF {

    //Page header
    public function Header() {
		
		if($this->titulo == 1) {
			$this->SetY(10);
			$this->SetX(15);
			$this->SetFont('helvetica', 'B', 12); // Set font
			$this->Cell(0, 10, 'SOLICITUD', 0, false, 'C', 0, '', 0, false, 'T', 'M');
			$this->SetY(15);
			$this->SetX(15);
			$this->SetFont('helvetica', 'B', 11);
			$this->Cell(0, 10, 'PARA OBTENER CAMBIOS EN UNA LICENCIA DE ALCOHOLES YA EXISTENTE', 0, false, 'C', 0, '', 0, false, 'T', 'M');
		}
		else {
			// Logo
			$this->Image($this->image_file, 10, 10,'', 22, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			// Set font
			$this->SetFont('helvetica', 'B', 7);
			//$this->Cell(0, 60, $this->titulo, 0, false, 'R', 0, '', 0, false, 'T', 'M');
			$this->writeHTMLCell($w = 0, $h = 0, $x = '80', $y = '24', $this->titulo, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'right', $autopadding = true);
		}	
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        //$this->Image($this->image_filefooter, 10, 250,190, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->Cell(0, 80, ''.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

class gdocs{

    function generapdf($html, $titulo = '', $guarda='I', $rutanombrearchivo='', $imageheader = '../images/logo2.png',$imagefooter = '../imagenes/global_imagenes_bannerpdf.jpg',$orientacion='L',$pagesize='Letter', $fontsize = '7', $qr='',$cb=''){ 
		// create new PDF document
		$pdf = new MYPDFCLASS(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('MONICA SOFIA RODRIGUEZ GARCIA');
		$pdf->SetTitle('DOCUMENTOSUPLOADS');
		$pdf->SetSubject('TCPDF');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		$pdf->titulo = $titulo;
		$pdf->image_file = $imageheader;
		$pdf->image_filefooter = $imagefooter;
		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		if($pdf->titulo == 1) {
			$pdf->SetMargins(PDF_MARGIN_LEFT, 23, PDF_MARGIN_RIGHT);
		}
		else {
			$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
		}
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('helvetica', '', $fontsize);

		// add a page
		$pdf->AddPage($orientacion,$pagesize);

        //IMPRESION CÓDIGO QR
        $param = $pdf->serializeTCPDFtagParameters(
            array($qr, 'QRCODE,H', '', '', 27, 27, array('border' => 1, 'padding' => 1, 'fgcolor' => array(0, 0, 0), 'fontsize' => 100), 'N')
        );
     
        $funcionqr = '<tcpdf method="write2DBarcode" params="'.$param.'" />';
        
        if ($qr <> ''){
            $htmlnew = str_replace('||QR||',$funcionqr,$html);
        }else{
            $htmlnew = $html;
        }
             
        $params2 = $pdf->serializeTCPDFtagParameters(array($cb, 'C39', '', '', 40, 14, 0.4, array('position'=>'S', 'border'=>false, 'padding'=>1, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>4), 'N'));
        
        $funcioncb = '<tcpdf method="write1DBarcode" params="'.$params2.'" />';
        
        if ($cb <> ''){
            $htmlnew = str_replace('||CB||',$funcioncb,$htmlnew);
        }else{
            $htmlnew = $htmlnew;
        }

		$pdf->writeHTML($htmlnew, true, false, true, false, '');
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		//Close and output PDF document
        
        
        
		$pdf->Output($rutanombrearchivo, $guarda);

		//============================================================+
		// END OF FILE
		//============================================================+
	}
    
}
?>
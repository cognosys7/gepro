<?php
require_once('../Recursos/Classes/fpdf/fpdf.php');

class PDF extends FPDF {

    var $widths;
    var $aligns;

    function SetWidths($w) {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a) {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function Header() {
        //Logo
        $iLogo = HTML_PATH_IMAGES . '/logo.jpg';
        $this->Image($iLogo, 24, 5, 150);
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(80);
        $this->Ln(14);
    }

    function Footer() {
        //Posición: a 1,5 cm del final
        $this->SetY(-10);
        //Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        //Número de página
        $sPagina = mb_convert_encoding('Página ', 'ISO-8859-1', 'UTF-8');
        $sFecha = ' fecha:' . date('d-m-Y');
        $sHora = ' hora: ' . date('H:i:s');
        $this->Cell(0, 10, $sPagina . $this->PageNo() . '/{nb}' . $sFecha . $sHora, 0, 0, 'C');
    }

    function titulo($sTitulo) {
        $w = $this->GetStringWidth($sTitulo) + 6;
        $nAnchoHoja = $this->CurOrientation == 'L' ? 290 : 210;
        $this->SetX(($nAnchoHoja - $w) / 2);
        $this->Write(14, mb_convert_encoding($sTitulo, 'ISO-8859-1', 'UTF-8'));
        //$this->ln();
    }

    function MiTablaResumen1($lstDato, $borde='', $fondo='') {
        $this->SetTextColor(0);
        $this->SetFont('');
        $this->SetFillColor(238, 238, 238);
        foreach ($lstDato as $key => $oDato) {
            $this->Cell(30, 7, mb_convert_encoding($key, 'ISO-8859-1', 'UTF-8'), $borde, 0, 'L', $fondo);
            $this->Cell(140, 7, mb_convert_encoding($oDato, 'ISO-8859-1', 'UTF-8'), $borde, 0, 'L', 0);
            $this->ln();
        }
    }

    function MiTablaResumen($lstDato, $borde='', $fondo='') {
        $this->SetTextColor(0);
        $this->SetFont('');
        $this->SetFillColor(238, 238, 238);

        foreach ($lstDato as $key => $Dato) {
            //Averigua el alto de la fila según datos
            $nb = 0;
            //foreach ($Fila as $Fila)
            $nb = max($nb, $this->NbLines(85, $Dato));
            $nb = max($nb, $this->NbLines(85, $key));

            $nAltura = 5 * $nb; //La altura es en filas

            $x = $this->GetX();
            $y = $this->GetY();

            if($borde)$this->Rect($x, $y, 85, $nAltura, 'DF');
            $this->MultiCell(85, 5, mb_convert_encoding($key, 'ISO-8859-1', 'UTF-8'), 0, 'L', 0);
            $this->SetXY($x + 85, $y);
            if($borde)$this->Rect($x + 85, $y, 85, $nAltura, 'D');
            $this->MultiCell(85, 5, mb_convert_encoding($Dato, 'ISO-8859-1', 'UTF-8'), 0, 'L', 0);
        }
    }

    function MiTabla($w, $header, $data, $caption='', $lAlign='',$lFormato='') 
    {
        //Colores, ancho de línea y fuente en negrita
        $nAltura = 0;
        //$this->SetFillColor(238, 238, 238);

        if ($lFormato == '') {
            $this->SetFillColor(255,255,255);
            $this->SetDrawColor(0,0,0);
            $this->SetLineWidth(.1);
            $this->SetFont('Helvetica', '', 7);
        } else {
            $this->SetTextColor(255,255,255);
            $this->SetFillColor(152, 69, 52);
            //$this->SetFillColor($lFormato['FillColor']['R'], $lFormato['FillColor']['G'], $lFormato['FillColor']['B']);
            $this->SetDrawColor($lFormato['DrawColor']['R'], $lFormato['DrawColor']['G'], $lFormato['DrawColor']['B']);
            $this->SetLineWidth(.1);
            $this->SetFont('Helvetica', '',7);
        }
        //Cabecera

        $nb = 0;
        for ($i = 0; $i < count($caption); $i++)
            $nb = max($nb, $this->NbLines($w[$i], $caption[$i]));
        $nAltura = 5 * $nb;

        for ($i = 0; $i < count($caption); $i++) {
            $x = $this->GetX();
            $y = $this->GetY();
            $this->Rect($x, $y, $w[$i], $nAltura, 'DF');
            $this->MultiCell($w[$i], 5, mb_convert_encoding($caption[$i], 'ISO-8859-1', 'UTF-8'), 0, 'J', 0);
            $this->SetXY($x + $w[$i], $y);
        }
        $this->Ln($nAltura);
        //Restauración de colores y fuentes
        //$this->SetFillColor(224, 235, 255);
        //Color de relleno de la linea zebra
        if (!$lFormato == '')
            $this->SetFillColor($lFormato['FillColor']['R'], $lFormato['FillColor']['G'], $lFormato['FillColor']['B']);
            $this->SetTextColor(0);
            $this->SetFont('');

        //Datos
        $fill = false;
        $nFila = 0;

        //var_dump($nb);exit;
        foreach ($data as $obj) {
            $nb = 0;
            for ($i = 0; $i < count($header); ++$i){
                $nb = max($nb, $this->NbLines($w[$i], $obj->$header[$i]));
            }
            $nAltura = 5 * $nb;

            //agrega un salto de página si excede
            $this->CheckPageBreak($nAltura);
            //if($nb>1)
               //exit;
            $sRelleno = ($fill) ? 'DF' : 'D';
            $nFila++;
//            $x = $this->GetX();
//            $y = $this->GetY();
//            $this->Rect($x,$y,20,$nAltura,$sRelleno);
//            $this->MultiCell(20,$nAltura,$nFila,0,'L',0);
//            $this->SetXY($x+20,$y);
            for ($i = 0; $i < count($header); ++$i) {
                $x = $this->GetX();
                $y = $this->GetY();
                $this->Rect($x, $y, $w[$i], $nAltura, $sRelleno);
                //$this->MultiCell($w[$i],6,utf8_decode($obj->$header[$i]),'LR',0,'L',$fill);

                $this->MultiCell($w[$i], 4, mb_convert_encoding($obj->$header[$i], 'ISO-8859-1', 'UTF-8'), 0, isset($lAlign[$i])?$lAlign[$i]:'', 0);
                $this->SetXY($x + $w[$i], $y);
            }
            $this->Ln($nAltura);
            $fill = !$fill;
        }
        //$this->Cell(array_sum($w),0,'','T');
    }
    
    function MiTabla2($w, $header, $data, $caption='', $lAlign='',$lFormato='',$Indice='')
    {
        //FORMATO PARA EL TEXTO NORMAL
        if ($lFormato == '')
        {
            $this->SetTextColor(0);
            $this->SetFillColor(255,255,255);
            $this->SetFont('Helvetica', '', 7);
            $cdCaption = 1;
        }
        else 
        {
            $this->SetTextColor(255,255,255);
            $this->SetFillColor(152, 69, 52);
            $this->SetDrawColor($lFormato['DrawColor']['R'], $lFormato['DrawColor']['G'], $lFormato['DrawColor']['B']);
            $this->SetLineWidth(.1);
            $this->SetFont('Helvetica', '',7);
            $cdCaption = 0;
        }
	//IMPRIMO LOS CAPTION
        $mb = 0;
        if ($Indice == 1)
        {
            for ($i = 0; $i < count($caption); $i++)
            {
                $mb = max($mb, $this->NbLines($w[$i], $caption[$i]));
                $nAltura = 5 * $mb;
            }
            for ($i = 0; $i < count($caption); $i++) 
            {
                $x = $this->GetX();
                $y = $this->GetY();
                $this->Rect($x, $y, $w[$i], $nAltura, 'DF');
                $this->MultiCell($w[$i], 5, mb_convert_encoding($caption[$i], 'ISO-8859-1', 'UTF-8'), 0, 'J', 0);
                $this->SetXY($x + $w[$i], $y);
            }
            $this->Ln($nAltura);
        }
        //IMPRIMO LAS FILAS
        $nb  = 0;
	for($i=0;$i<count($header);$i++)
	{
		$nb=max($nb,$this->NbLines($w[$i],$data[$i]));
	}
	$h	= 5 * $nb;
	$this->CheckPageBreak($h);
	for ($i = 0; $i < count($header); ++$i)
	{
		$x = $this->GetX();
		$y = $this->GetY();
		$this->Rect($x, $y, $w[$i], $h, 'DF');
		$this->MultiCell($w[$i], 5, mb_convert_encoding($data[$i], 'ISO-8859-1', 'UTF-8'), 0, isset($lAlign[$i])?$lAlign[$i]:'', 0);
		$this->SetXY($x + $w[$i], $y);
	}
	$this->Ln($h);
    }

    function MiFila($w, $caption, $lAlineacion ='', $lBordeRelleno='') {
        //Colores, ancho de línea y fuente en negrita
        $nAltura = 7;
        $this->SetFillColor(238, 238, 238);
        //$this->SetFillColor(238, 0, 0);
        //$this->SetDrawColor(128, 0, 0);
        $this->SetDrawColor(128, 128, 128);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');

        //Cabecera

        $nb = 0;
        for ($i = 0; $i < count($caption); $i++)
            $nb = max($nb, $this->NbLines($this->w[$i], $caption[$i]));
        $nAltura = 5 * $nb;

        for ($i = 0; $i < count($caption); $i++) {
            //Iniciando Variables
            $sAlineacion = $lAlineacion == '' ? 'C' : $lAlineacion[$i];
            $sBordeRelleno = $lBordeRelleno == '' ? 0 : $lBordeRelleno[$i];

            $x = $this->GetX();
            $y = $this->GetY();
            $this->Rect($x, $y, $w[$i], 2 * $nAltura, $sBordeRelleno);
            $this->MultiCell($w[$i], $nAltura, mb_convert_encoding($caption[$i], 'ISO-8859-1', 'UTF-8'), 0, $sAlineacion, 0);
            $this->SetXY($x + $w[$i], $y);
        }

        $this->Ln();
        //Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
    }

    function NbLines($w, $txt) {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l+=$cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                }
                else
                    $i=$sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }
    function CheckPageBreak($h) {
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

}

?>
<?php

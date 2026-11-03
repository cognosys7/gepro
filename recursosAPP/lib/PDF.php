<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/recursosAPP/recursos/Classes/fpdf/fpdf.php');

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
        $iLogo = ROOT_PATH . '/Recursos/images/logo_convenios.jpg';
        $this->Image($iLogo, 24, 5, 150);
        $this->SetFont('Arial', 'B', 13);
        //$this->Cell(80);
        //$this->Ln(14);
    }

//Pie de página
    function Footer() {
        //Posición: a 1,5 cm del final
        $this->SetY(-10);
        //Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        //Número de página
        $sPagina = utf8_decode('Página ');
        $sFecha = ' fecha:' . date('d-m-Y');
        $sHora = ' hora: ' . date('H:i:s');
        $this->Cell(0, 10, $sPagina . $this->PageNo() . '/{nb}' . $sFecha . $sHora, 0, 0, 'C');
    }

    function titulo($sTitulo) {
        $w = $this->GetStringWidth($sTitulo) + 6;
        $nAnchoHoja = $this->CurOrientation == 'L' ? 290 : 210;
        $this->SetX(($nAnchoHoja - $w) / 2);
        $this->Write(14, utf8_decode($sTitulo));
        //$this->ln();
    }

    /**
     * Dibuja una tabla de dos columnas a partir de un array asociativo
     * @param type $oDato
     * @param type $borde
     * @param type $fondo
     */
    function MiCuadro01($oDato, $lParametros) {
        //Parametros Iniciales
        $borde = isset($lParametros['BORDE']) ? $lParametros['BORDE'] : 0;
        $fondo = isset($lParametros['FONDO']) ? $lParametros['FONDO'] : 0;
        $anchoLinea = isset($lParametros['ANCHOLINEA']) ? $lParametros['ANCHOLINEA'] : 0.1;
        $anchoColumna01 = isset($lParametros['ANCHOCOLUMNA01']) ? $lParametros['ANCHOCOLUMNA01'] : 85;
        $anchoColumna02 = isset($lParametros['ANCHOCOLUMNA02']) ? $lParametros['ANCHOCOLUMNA02'] : 85;

        //Configurar Inicial
        $this->SetTextColor(0);
        $this->SetFont('');
        $this->SetFillColor(238, 238, 238);
        $this->SetLineWidth($anchoLinea);
        foreach ($oDato as $key => $Dato) {
            //Averigua el alto de la fila según datos
            $nb = 0;
            //foreach ($Fila as $Fila)
            $nb = max($nb, $this->NbLines(50, $Dato));
            $nb = max($nb, $this->NbLines(120, $key));

            $nAltura = 5 * $nb; //La altura es en filas
            //agrega un salto de página si excede
            $this->CheckPageBreak($nAltura);

            $x = $this->GetX();
            $y = $this->GetY();

            if ($borde)
                $this->Rect($x, $y, $anchoColumna01, $nAltura, 'DF');
            $this->MultiCell($anchoColumna01, 5, utf8_decode($key), 0, 'L', 0);

            $this->SetXY($x + $anchoColumna01, $y);
            if ($borde)
                $this->Rect($x + $anchoColumna01, $y, $anchoColumna02, $nAltura, 'D');
            $this->MultiCell($anchoColumna02, 5, utf8_decode($Dato), 0, 'L', 0);
        }
    }

    function MiTablaResumen1($lstDato, $borde = '', $fondo = '') {
        $this->SetTextColor(0);
        $this->SetFont('');
        $this->SetFillColor(238, 238, 238);
        foreach ($lstDato as $key => $oDato) {
            $this->Cell(30, 7, utf8_decode($key), $borde, 0, 'L', $fondo);
            $this->Cell(140, 7, utf8_decode($oDato), $borde, 0, 'L', 0);
            $this->ln();
        }
    }

    function MiTablaResumen($lstDato, $borde = '', $fondo = '') {
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

            if ($borde)
                $this->Rect($x, $y, 85, $nAltura, 'DF');
            $this->MultiCell(85, 5, utf8_decode($key), 0, 'L', 0);
            $this->SetXY($x + 85, $y);
            if ($borde)
                $this->Rect($x + 85, $y, 85, $nAltura, 'D');
            $this->MultiCell(85, 5, utf8_decode($Dato), 0, 'L', 0);
        }
    }

    function MiTabla($w, $header, $data, $caption = '', $lAlign = '', $lFormato = '') {
        //Colores, ancho de línea y fuente en negrita
        $nAltura = 0;
        $this->SetFillColor(238, 238, 238);

        if ($lFormato == '') {
            $this->SetFillColor(255, 255, 255);
            $this->SetDrawColor(0, 0, 0);
            $this->SetLineWidth(.1);
            $this->SetFont('Helvetica', '', 6);
        } else {
            $this->SetTextColor(255, 255, 255);
            $this->SetFillColor(19, 130, 233);
            $this->SetFillColor($lFormato['FillColor']['R'], $lFormato['FillColor']['G'], $lFormato['FillColor']['B']);
            $this->SetDrawColor($lFormato['DrawColor']['R'], $lFormato['DrawColor']['G'], $lFormato['DrawColor']['B']);
            $this->SetLineWidth(.1);
            $this->SetFont('Helvetica', '', 6);
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
            $this->MultiCell($w[$i], 5, utf8_decode($caption[$i]), 0, 'J', 0);
            $this->SetXY($x + $w[$i], $y);
        }
        $this->Ln($nAltura);
        //Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        //Color de relleno de la linea zebra
        if (!$lFormato == '')
            //$this->SetFillColor($lFormato['FillColor']['R'], $lFormato['FillColor']['G'], $lFormato['FillColor']['B']);
        $this->SetTextColor(0);
        $this->SetFont('');

        //Datos
        $fill = false;
        $nFila = 0;

        //var_dump($nb);exit;
        foreach ($data as $obj) {
            $nb = 0;
            for ($i = 0; $i < count($header); ++$i) {
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

                $this->MultiCell($w[$i], 5, utf8_decode($obj->$header[$i]), 0, isset($lAlign[$i]) ? $lAlign[$i] : '', 0);
                $this->SetXY($x + $w[$i], $y);
            }
            $this->Ln($nAltura);
            $fill = !$fill;
        }
        //$this->Cell(array_sum($w),0,'','T');
    }

    function MiFila($w, $caption, $lAlineacion = '', $lBordeRelleno = '') {
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
            $this->MultiCell($w[$i], $nAltura, utf8_decode($caption[$i]), 0, $sAlineacion, 0);
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
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

    function CheckPageBreak($h) {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

}

?>
<?php

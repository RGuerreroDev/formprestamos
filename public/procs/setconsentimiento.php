<?php

//-----------------------------------------------

require_once("../../libs/fpdf/fpdf.php");

//-----------------------------------------------

// Para poder leer un archivo HTML y usarlo en el contenido del PDF

class PDF extends FPDF
{
    protected $B = 0;
    protected $I = 0;
    protected $U = 0;
    protected $HREF = '';

    function WriteHTML($html)
    {
        // Intérprete de HTML
        $html = str_replace("\n", ' ', $html);
        $a = preg_split('/<(.*)>/U', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
        foreach ($a as $i => $e) {
            if ($i % 2 == 0) {
                // Text
                if ($this->HREF)
                    $this->PutLink($this->HREF, $e);
                else
                    $this->Write(5, $e);
            } else {
                // Etiqueta
                if ($e[0] == '/')
                    $this->CloseTag(strtoupper(substr($e, 1)));
                else {
                    // Extraer atributos
                    $a2 = explode(' ', $e);
                    $tag = strtoupper(array_shift($a2));
                    $attr = array();
                    foreach ($a2 as $v) {
                        if (preg_match('/([^=]*)=["\']?([^"\']*)/', $v, $a3))
                            $attr[strtoupper($a3[1])] = $a3[2];
                    }
                    $this->OpenTag($tag, $attr);
                }
            }
        }
    }

    function OpenTag($tag, $attr)
    {
        // Etiqueta de apertura
        if ($tag == 'B' || $tag == 'I' || $tag == 'U')
            $this->SetStyle($tag, true);
        if ($tag == 'A')
            $this->HREF = $attr['HREF'];
        if ($tag == 'BR')
            $this->Ln(5);
    }

    function CloseTag($tag)
    {
        // Etiqueta de cierre
        if ($tag == 'B' || $tag == 'I' || $tag == 'U')
            $this->SetStyle($tag, false);
        if ($tag == 'A')
            $this->HREF = '';
    }

    function SetStyle($tag, $enable)
    {
        // Modificar estilo y escoger la fuente correspondiente
        $this->$tag += ($enable ? 1 : -1);
        $style = '';
        foreach (array('B', 'I', 'U') as $s) {
            if ($this->$s > 0)
                $style .= $s;
        }
        $this->SetFont('', $style);
    }

    function PutLink($URL, $txt)
    {
        // Escribir un hiper-enlace
        $this->SetTextColor(0, 0, 255);
        $this->SetStyle('U', true);
        $this->Write(5, $txt, $URL);
        $this->SetStyle('U', false);
        $this->SetTextColor(0);
    }
}

//-----------------------------------------------

// create new PDF document
$pdf = new PDF();

// Primera página
$pdf->SetMargins(25, 25, 25);
$pdf->AddPage();
$pdf->SetFont("Arial", "", 8);

//-----------------------------------------------

// Tomar plantilla e insertar datos en ella
$html = file_get_contents('../consentimiento.html');

$html = str_replace("{nombrecompleto}", $nombres . " " . $apellidos, $html);
$html = str_replace("{correoelectronico}", $correoElectronico, $html);
$html = str_replace("{telefono}", $telefono, $html);
$html = str_replace("{dui}", $numeroDocumento, $html);
$html = str_replace("{fecha}", $fechaActual, $html);
$html = str_replace("{si}", $siAutoriza, $html);
$html = str_replace("{no}", $noAutoriza, $html);

$html = iconv('UTF-8', 'windows-1252', $html);

// //-----------------------------------------------

$pdf->WriteHTML($html);
$pdf->Image($imagenFirmaUrl, 40, null, 50, 30);

//-----------------------------------------------

$pdf->Output("F", $pdfConsentimientoUrl, false);

//-----------------------------------------------
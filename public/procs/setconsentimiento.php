<?php

//-----------------------------------------------

require('../../libs/fpdf/WriteTag.php');

//-----------------------------------------------


$pdf = new PDF_WriteTag();
$pdf->SetMargins(25, 25, 25);
$pdf->SetFont("Arial", "", 8);
$pdf->AddPage();

//-----------------------------------------------

// Tomar plantilla (archivo HTML) e insertar datos en ella

$html = file_get_contents('../consentimiento.html');

$html = str_replace("{nombrecompleto}", $nombres . " " . $apellidos, $html);
$html = str_replace("{correoelectronico}", $correoElectronico, $html);
$html = str_replace("{telefono}", $telefono, $html);
$html = str_replace("{dui}", $numeroDocumento, $html);
$html = str_replace("{fecha}", $fechaActual, $html);
$html = str_replace("{si}", $siAutoriza, $html);
$html = str_replace("{no}", $noAutoriza, $html);

//-----------------------------------------------

// Stylesheet
$pdf->SetStyle("p", "Arial", "N", 8, "0, 0, 0", 5);
$pdf->SetStyle("b", "Arial", "B", 0, "0, 0, 0");

$pdf->WriteTag(0, 5, iconv('UTF-8', 'windows-1252', $html), 0, "J", 0, 2);
$pdf->Image($imagenFirmaUrl, 40, null, 50, 30);

//-----------------------------------------------

//$pdf->Output();
$pdf->Output("F", $pdfConsentimientoUrl, false);

//-----------------------------------------------
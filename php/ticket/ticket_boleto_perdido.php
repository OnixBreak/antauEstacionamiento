<?php
    session_start();
    date_default_timezone_set('America/Mexico_City');
    if(!isset($_SESSION['username'])){
        session_destroy();
        die();

    }
	# Incluyendo librerias necesarias #
    require "./code128.php";
    $pdf = new PDF_Code128('P','mm',array(80,258));
    $pdf->SetMargins(4,10,4);
    $pdf->AddPage();
    
    # Encabezado y datos de la empresa #
    $pdf->SetFont('Arial','B',14);
    $pdf->SetTextColor(0,0,0);
    $pdf->MultiCell(0,5,utf8_decode(strtoupper("Antau II\nEstacionamiento")),0,'C',false);
    $pdf->SetFont('Arial','',9);
    //$pdf->MultiCell(0,5,utf8_decode("RUC: 0000000000"),0,'C',false);  Así va todo el contenido
    $pdf->MultiCell(0,5,utf8_decode("Direccion: 12 Oriente #408\nCol. San Francisco Puebla, Pue. CP 72000"),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Teléfono: 222 242 67 54"),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Email:antauestac@hotmail.com"),0,'C',false);

    $pdf->Ln(1);
    $pdf->Cell(0,5,utf8_decode("------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);
    $pdf->MultiCell(0,5,utf8_decode("Puebla, Pue. A ____ de _________ de 20__"),0,'R',false);
    $pdf->Ln(10);
    $pdf->MultiCell(0,5,utf8_decode("A quién corresponda:"),0,"J",false);
    $pdf->Ln(10);
    $pdf->MultiCell(0,5,utf8_decode("Por medio de la presente informo que por la perdida, no presentó el boleto del estacionamiento público Antau / José Ramón Gómez González con No.___ dejando como acreditación del vehículo ____________________________ Modelo _________ No. Motor______________ Serie______________ Placa No. ______________ Copia de la tarjeta de circulación a nombre de _________________ e identificación de ______________ folio ______________."),0,"J",false);
    $pdf->Ln(9);
    $pdf->MultiCell(0,5,utf8_decode("Deslindando de cualquier responsabilidad a la empresa denominada Estacionamiento Antau / José Ramón Gómez González"),0,"J",false);
    $pdf->Ln(10);
    $pdf->Cell(0,5,utf8_decode("Atentamente"),0,"C",false);
    $pdf->Ln(10);
    $pdf->MultiCell(0,5,utf8_decode("___________________________\n(Nombre y firma)"),0,"C",false);
    
    
    # Nombre del archivo PDF #
    $pdf->Output("I","Folio ",true);
    ?>
*/
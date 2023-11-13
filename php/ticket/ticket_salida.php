<?php
    session_start();
    date_default_timezone_set('America/Mexico_City');
    if(!isset($_SESSION['username'])){
        session_destroy();
        die();

    }


    include '../conexion_back.php';
    $query_folio = "SELECT MAX(id_consecutivo) AS folio_salidabd FROM salidas";
    $folio_ticket = mysqli_query($conexion,$query_folio);

    $row_folio = $folio_ticket->fetch_assoc();
    $consecutivo_bd = $row_folio['folio_salidabd'];

    $query_ticket_registrado = "SELECT * FROM salidas WHERE id_consecutivo='$consecutivo_bd'";
    $ticket_registrado_salida = mysqli_query($conexion,$query_ticket_registrado);
    $rows_ticket_salida = $ticket_registrado_salida->fetch_assoc();

    //$folio
    $numeroAleatorio1 = mt_rand(1000, 9999);
    $numeroAleatorio2 = mt_rand(1000, 9999); 
    $folio = $numeroAleatorio1.$rows_ticket_salida['folio_entrada'].$numeroAleatorio2;
    $atendio = $rows_ticket_salida['atendio'];
    $fecha_ticket = $rows_ticket_salida['fecha_entrada'];
    $hora_ticket = $rows_ticket_salida['hora_entrada'];
    $placa_ticket = $rows_ticket_salida['placas'];
    $tipo_vehiculo_salida = $rows_ticket_salida['tipo_vehiculo'];
    $hora_salida =  $rows_ticket_salida['salida'];
    $total_a_pagar = $rows_ticket_salida['total'];


	# Incluyendo librerias necesarias #
    require "./code128.php";
    $pdf = new PDF_Code128('P','mm',array(80,258));
    $pdf->SetMargins(3,2,3);
    $pdf->AddPage();
    
    # Encabezado y datos de la empresa #
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->MultiCell(0,5,utf8_decode(strtoupper("Antau II Estacionamiento")),0,'J',false);
    $pdf->SetFont('Arial','',7);
    //$pdf->MultiCell(0,5,utf8_decode("RUC: 0000000000"),0,'C',false);  Así va todo el contenido
    $pdf->MultiCell(0,3,utf8_decode("Direccion: 12 Oriente #408\nCol. San Francisco Puebla, Pue. CP 72000"),0,'J',false);
    $pdf->MultiCell(0,3,utf8_decode("Teléfono: 222 242 67 54"),0,'J',false);
    $pdf->MultiCell(0,3,utf8_decode("Email:antauestac@hotmail.com"),0,'J',false);

    $pdf->Ln(1);
    $pdf->Cell(0,2,utf8_decode("--------------------------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(2);

    $pdf->SetFont('Arial','',7);
    $pdf->MultiCell(0,3,utf8_decode("Folio: ".$folio),0,'J',false);

    $pdf->MultiCell(0,3,utf8_decode("Fecha: ".$fecha_ticket),0,'J',false);
    $pdf->MultiCell(0,3,utf8_decode("Entrada: ".$hora_ticket),0,'J',false);
    $pdf->MultiCell(0,3,utf8_decode("Salida: ".$hora_salida),0,'J',false);
    $pdf->MultiCell(0,3,utf8_decode("Placas: ".$placa_ticket),0,'J',false);
    $pdf->MultiCell(0,3,utf8_decode("Atiende : ".$atendio),0,'J',false);
    $pdf->SetFont('Arial','B',12);
    $pdf->MultiCell(0,8,utf8_decode("Total $ ".$total_a_pagar.".00"),0,'R',false);

    $pdf->SetFont('Arial','',7);

    $pdf->Ln(1);
    $pdf->Cell(0,2,utf8_decode("--------------------------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(3);

    $pdf->SetFont('Arial','',7);
    $pdf->MultiCell(0,4,utf8_decode("ABRIMOS LOS 365 DIAS DEL AÑO.\nHORARIO\nLUNES A SÁBADO: 8:30 A 21:00 HRS."),0,'C');
    $pdf->SetFont('Arial','B',7);
    $pdf->MultiCell(0,4,utf8_decode("NO TENEMOS TIEMPO DE TOLERANCIA."),0,'C');
    $pdf->MultiCell(0,4,("COSTO POR BOLETO PERDIDO"),0,'C');
    $pdf->SetFont('Arial','B',10);
    $pdf->MultiCell(0,4,utf8_decode("$ 100.00"),0,'C');
    $pdf->SetFont('Arial','B',7);
    $pdf->MultiCell(0,4,utf8_decode("(MÁS TIEMPO TRANSCURRIDO)"),0,'C');

    $pdf->Ln(2);

    
    
    # Nombre del archivo PDF #
    $pdf->Output("I","Folio ".$folio,true);
    ?>
*/
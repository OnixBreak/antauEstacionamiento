<?php
    session_start();
    date_default_timezone_set('America/Mexico_City');
    if(!isset($_SESSION['username'])){
        session_destroy();
        die();
    }
    if(!isset($_SESSION['placAuto'])){
        echo "<script>
        alert('No se encontró el registro!');
        window.location = '.../index.php';
        </script>";
    }
    $placas = $_SESSION['placAuto']; //extrayendo el dato guardado en index

    include '../conexion_back.php';
    $query_placa = "SELECT * FROM entradas WHERE placa='$placas'";
    $placa_ticket = mysqli_query($conexion,$query_placa);
    $row_folio = $placa_ticket->fetch_assoc();
    $folio = $row_folio['folio_entradas'];
    $query_ticket_registrado = "SELECT * FROM entradas WHERE folio_entradas='$folio'";
    $ticket_registrado = mysqli_query($conexion,$query_ticket_registrado);
    $rows_ticket = $ticket_registrado->fetch_assoc();
    
    //$folio 
    $numeroAleatorio1 = mt_rand(1000, 9999);
    $numeroAleatorio2 = mt_rand(1000, 9999);
    $fecha_ticket = $rows_ticket['fecha_entrada'];
    $hora_ticket = $rows_ticket['hora_entrada'];
    $placa_ticket = $rows_ticket['placa'] ;
    $descrip = $rows_ticket['color_marca'];
    $tipo_auto = $rows_ticket['tipo_vehiculo'];

    switch($tipo_auto){
        case "A":
            $tarifa_auto = 16;
            break;
        case "B":
            $tarifa_auto = 20;
            break;
        case "C":
            $tarifa_auto = 30;
            break;
        case "D":
            $tarifa_auto = 53;
            break;
        default:
            $tarifa_auto = 16;
            break;
    }

	# Incluyendo librerias necesarias #
    require "./code128.php";
    $pdf = new PDF_Code128('P','mm',array(80,258));
    $pdf->SetMargins(2,3,2);
    $pdf->AddPage();
    
    # Encabezado y datos de la empresa #
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->MultiCell(0,5,utf8_decode(strtoupper("Antau II Estacionamiento")),0,'C',false);
    $pdf->SetFont('Arial','',8);
    
    $pdf->MultiCell(0,3,utf8_decode("Direccion: 12 Oriente #408\nCol. San Francisco Puebla, Pue. CP 72000"),0,'J',false);
    $pdf->MultiCell(0,3,utf8_decode("Teléfono: 222 242 67 54"),0,'J',false);
    $pdf->MultiCell(0,3,utf8_decode("Email:antauestac@hotmail.com"),0,'J',false);

    $pdf->Ln(1);
    $pdf->Cell(0,5,utf8_decode("------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);

    # Codigo de barras #
    $centerX = $pdf->GetPageWidth() / 2;
    $barcodeWidth = 28;
    $barcodeHeight = 12;
    $barcodeX = $centerX - $barcodeWidth / 2;
    $barcodeY = $pdf->GetY();
    $pdf->Code128($barcodeX, $barcodeY, $folio, $barcodeWidth, $barcodeHeight);

    // Mover a la posición para el siguiente elemento (en este caso, a 15 unidades debajo del código de barras)
    $pdf->SetXY(0, $pdf->GetY() + 12);
    $pdf->SetFont('Arial','',7);
    $pdf->MultiCell(0,3,utf8_decode($numeroAleatorio1.$folio.$numeroAleatorio2),0,'C',false);
    $pdf-> Ln(2);
    $pdf->MultiCell(0,3,utf8_decode("Fecha: ".$fecha_ticket),0,'J',false);
    $pdf->MultiCell(0,3,utf8_decode("Hora: ".$hora_ticket),0,'J',false);
    $pdf ->MultiCell(0,3,utf8_decode("Descripción: ".$descrip),0,'J',false);
    $pdf ->MultiCell(0,3,utf8_decode("Placas: ".$placa_ticket),0,'J',false);
    $pdf ->MultiCell(0,3,utf8_decode("Tipo de Vehículo: ".$tipo_auto."\nTarifa Hora/Fracción: $".$tarifa_auto),0,'J');
    $pdf->MultiCell(0,3,utf8_decode("Atiende : ".$_SESSION['username']),0,'J',false);
    $pdf->SetFont('Arial','',8);

    $pdf->Ln(1);
    $pdf->Cell(0,5,utf8_decode("------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(3);
    $pdf->SetFont('Arial','B',6);
    $pdf->MultiCell(0,3,utf8_decode("UNICAMENTE A QUIEN ENTREGUE ESTE BOLETO O QUIEN ACREDITE LA PROPIEDAD MEDIANTE UN FORMATO REQUISITADO E IDENTIFICACIÓN, SE LE PERMITIRA LA SALIDA CON EL VEHÍCULO"),0,"J");
    /* el primer numero representa el ancho, el segundo el alto(interlineado)*/ 
    $pdf->SetFont('Arial','',6);
    $pdf->MultiCell(0,2,utf8_decode("1.- Debido a que el estacionamiento es de autoservicio la empresa no se responsabiliza por:\nA) Robo de accesorios, objetos documentos y valores aún a consecuencia de robo total o rotura de cristales.\nB) Daños ocasionados por terceros debido a que el vehículo es conducido por el propietario.\nC) Daños ocasionados por temblor o terremoto, incendio, inundaciones, alborotos populares o huelgas.\nD) Daños mecánicos y/o eléctricos de cualquiér índole oncluyendo piezas y/o accesorios mecánicos o eléctricos.\nE) Falta de aviso oportuno por la perdida del presente boleto.\n2.- En caso de robo total, el cliente acepta de antemano por concepto de indemnización la cantidad que la compañia de seguros(Contratada por la empresa) asigne.\n3.- Después del horario de funcionamiento, la empresa cobrará tarifa doble.\n4.- El uso del estacionamiento significa la aceptación de las condiciones descritas.\n5.- No custodiamos ni respondemos por bicicletas, motocicletas, motonetas u otro equivalente.\n\n> Se cobrará únicamente a la salida del vehículo.\n\n> Queda estrictamente prohibido permanecer dentro de los vehículos."),0,'J');/*el primero representa un relleno y el segundo el borde. El tercero es la alineación del texto */
    $pdf->Ln(5);
    $pdf->SetFont('Arial','',7);
    $pdf->MultiCell(0,4,utf8_decode("HORARIO\nLUNES A SÁBADO: 9:00 A 20:00 HRS."),0,'C');
    $pdf->MultiCell(0,3,utf8_decode("NO TENEMOS TIEMPO DE TOLERANCIA."),0,'C');
    $pdf->MultiCell(0,3,("COSTO POR BOLETO PERDIDO"),0,'C');
    $pdf->SetFont('Arial','B',8);
    $pdf->MultiCell(0,3,utf8_decode("$ 100.00"),0,'C');
    $pdf->SetFont('Arial','B',7);
    $pdf->MultiCell(0,3,utf8_decode("(MÁS TIEMPO TRANSCURRIDO)"),0,'C');

    $pdf->Ln(10);

    
    
    # Nombre del archivo PDF #
    $pdf->Output("I", "Folio ".$folio.".pdf");
    ?>
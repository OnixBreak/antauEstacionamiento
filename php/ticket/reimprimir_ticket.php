<?php
    session_start();
    date_default_timezone_set('America/Mexico_City');
    if(!isset($_SESSION['username'])){
        session_destroy();
        die();

    }

    include '../conexion_back.php';
    $folio = $_POST['reimpresion'];
    $opt = $_POST['select_reimpresion'];

    switch ($opt){
        case 'entrada':
            
            $query_ticket_registrado = "SELECT * FROM entradas WHERE folio_entradas='$folio'";
            $ticket_registrado = mysqli_query($conexion, $query_ticket_registrado);
                if (mysqli_num_rows($ticket_registrado) === 0)
                {
                    // El folio no existe en la base de datos, redirige a index.php
                    header("Location: ../../index.php");
                    exit; // Asegura que el script termine después de la redirección
                }

            $rows_ticket = $ticket_registrado->fetch_assoc();
            
            //$folio 
            $numeroAleatorio1 = mt_rand(1000, 9999);
            $numeroAleatorio2 = mt_rand(1000, 9999);
            $fecha_ticket = $rows_ticket['fecha_entrada'];
            $hora_ticket = $rows_ticket['hora_entrada'];
            $placa_ticket = $rows_ticket['placa'] ;
            $tipo_auto = $rows_ticket['tipo_vehiculo'];

            switch($tipo_auto){
                case 'A':
                    $tarifa_auto = 16;
                    break;
                case 'B':
                    $tarifa_auto = 20;
                    break;
                case 'C':
                    $tarifa_auto = 30;
                    break;
                case 'D':
                    $tarifa_auto = 53;
                    break;
                    default:
                    $tarifa_auto = 16;
            }


            # Incluyendo librerias necesarias #
            # Incluyendo librerias necesarias #
    require "./code128.php";
    $pdf = new PDF_Code128('P','mm',array(80,258));
    $pdf->SetMargins(5,3,5);
    $pdf->AddPage();
    
    # Encabezado y datos de la empresa #
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->MultiCell(0,5,utf8_decode(strtoupper("Antau II Estacionamiento")),0,'C',false);
    $pdf->SetFont('Arial','',8);
    /*$pdf->MultiCell(0,5,utf8_decode("RUC: 0000000000"),0,'C',false);  Así va todo el contenido*/ 
    $pdf->MultiCell(0,3,utf8_decode("Direccion: 12 Oriente #408\nCol. San Francisco Puebla, Pue. CP 72000"),0,'J',false);
    $pdf->MultiCell(0,3,utf8_decode("Teléfono: 222 242 67 54"),0,'J',false);
    $pdf->MultiCell(0,3,utf8_decode("Email:antauestac@hotmail.com"),0,'J',false);

    $pdf->Ln(1);
    $pdf->Cell(0,5,utf8_decode("------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);

    # Codigo de barras #
    $centerX = $pdf->GetPageWidth() / 2;
    $barcodeWidth = 25;
    $barcodeHeight = 12;
    $barcodeX = $centerX - $barcodeWidth / 2;
    $barcodeY = $pdf->GetY();
    $pdf->Code128($barcodeX, $barcodeY, $folio, $barcodeWidth, $barcodeHeight);

    // Mover a la posición para el siguiente elemento (en este caso, a 15 unidades debajo del código de barras)
    $pdf->SetXY(0, $pdf->GetY() + 13);
    $pdf->SetFont('Arial','',7);
    $pdf->MultiCell(0,3,utf8_decode($numeroAleatorio1.$folio.$numeroAleatorio2),0,'C',false);
    $pdf-> Ln(2);
    $pdf->MultiCell(0,3,utf8_decode("Fecha: ".$fecha_ticket),0,'J',false);
    $pdf->MultiCell(0,3,utf8_decode("Hora: ".$hora_ticket),0,'J',false);
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
    $pdf->MultiCell(0,4,utf8_decode("HORARIO\nLUNES A SÁBADO: 9:00 A 22:00 HRS."),0,'C');
    $pdf->SetFont('Arial','B',7);
    $pdf->MultiCell(0,3,utf8_decode("NO TENEMOS TIEMPO DE TOLERANCIA."),0,'C');
    $pdf->MultiCell(0,3,("COSTO POR BOLETO PERDIDO"),0,'C');
    $pdf->SetFont('Arial','B',8);
    $pdf->MultiCell(0,3,utf8_decode("$ 100.00"),0,'C');
    $pdf->SetFont('Arial','B',7);
    $pdf->MultiCell(0,3,utf8_decode("(MÁS TIEMPO TRANSCURRIDO)"),0,'C');

            $pdf->Ln(10);

            
            
            # Nombre del archivo PDF #
            $pdf->Output("I","Folio ".$folio,true);
            break;
        case "salida":

            $query_ticket_registrado = "SELECT * FROM salidas WHERE folio_entrada='$folio'";
            $ticket_registrado_salida = mysqli_query($conexion,$query_ticket_registrado);
            if (mysqli_num_rows($ticket_registrado_salida) === 0)
                {
                    // El folio no existe en la base de datos, redirige a index.php
                    header("Location: ../../index.php");
                    exit; // Asegura que el script termine después de la redirección
                }
            $rows_ticket_salida = $ticket_registrado_salida->fetch_assoc();

            //$folio
            $numeroAleatorio1 = mt_rand(1000, 9999);
            $numeroAleatorio2 = mt_rand(1000, 9999); 
            $pfolio = $numeroAleatorio1.$rows_ticket_salida['folio_entrada'].$numeroAleatorio2;
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
    $pdf->MultiCell(0,4,utf8_decode("HORARIO\nLUNES A SÁBADO: 9:00 A 22:00 HRS."),0,'C');
    $pdf->SetFont('Arial','B',7);
    $pdf->MultiCell(0,4,utf8_decode("NO TENEMOS TIEMPO DE TOLERANCIA."),0,'C');
    $pdf->MultiCell(0,4,("COSTO POR BOLETO PERDIDO"),0,'C');
    $pdf->SetFont('Arial','B',10);
    $pdf->MultiCell(0,4,utf8_decode("$ 100.00"),0,'C');
    $pdf->SetFont('Arial','B',7);
    $pdf->MultiCell(0,4,utf8_decode("(MÁS TIEMPO TRANSCURRIDO)"),0,'C');

    $pdf->Ln(10);

            
            
            # Nombre del archivo PDF #
            $pdf->Output("I","Folio ".$folio,true);

    }

    ?>

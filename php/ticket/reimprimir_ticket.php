<?php
    session_start();
    date_default_timezone_set('America/Mexico_City');
    if(!isset($_SESSION['username'])){
        session_destroy();
        die();

    }

    include '../conexion_back.php';
    $folio = $_POST['reimpresion'];
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

    if($tipo_auto=="A"){
        $tarifa_auto = 16;

    }
    else{
        $tarifa_auto = 20;
    }


	# Incluyendo librerias necesarias #
    require "./code128.php";
    $pdf = new PDF_Code128('P','mm',array(80,258));
    $pdf->SetMargins(5,10,5);
    $pdf->AddPage();
    
    # Encabezado y datos de la empresa #
    $pdf->SetFont('Arial','B',14);
    $pdf->SetTextColor(0,0,0);
    $pdf->MultiCell(0,5,utf8_decode(strtoupper("Antau II\nEstacionamiento")),0,'C',false);
    $pdf->SetFont('Arial','',9);
    /*$pdf->MultiCell(0,5,utf8_decode("RUC: 0000000000"),0,'C',false);  Así va todo el contenido*/ 
    $pdf->MultiCell(0,5,utf8_decode("Direccion: 12 Oriente #409 A\nCol. Centro Puebla, Pue. CP 72000"),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Teléfono: 222 242 67 54"),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Email:antauestac@hotmail.com"),0,'C',false);

    $pdf->Ln(1);
    $pdf->Cell(0,5,utf8_decode("------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);

    # Codigo de barras #
    $pdf->Code128(3,$pdf->GetY(),$folio,70,14);
    $pdf->SetXY(0,$pdf->GetY()+15);
    $pdf->SetFont('Arial','',10);
    $pdf->MultiCell(0,3,utf8_decode($numeroAleatorio1.$folio.$numeroAleatorio2),0,'C',false);
    $pdf-> Ln(3);
    $pdf->MultiCell(0,5,utf8_decode("Fecha: ".$fecha_ticket),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Hora: ".$hora_ticket),0,'C',false);
    $pdf ->MultiCell(0,5,utf8_decode("Placas: ".$placa_ticket),0,'C',false);
    $pdf ->MultiCell(0,5,utf8_decode("Tipo de Vehículo: ".$tipo_auto."\nTarifa Hora/Fracción: $".$tarifa_auto),0,'C');
    $pdf->MultiCell(0,5,utf8_decode("Atiende : ".$_SESSION['username']),0,'C',false);
    $pdf->SetFont('Arial','',8);

    $pdf->Ln(1);
    $pdf->Cell(0,5,utf8_decode("------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);
    $pdf->SetFont('Arial','B',8);
    $pdf->MultiCell(0,4,utf8_decode("UNICAMENTE A QUIEN ENTREGUE ESTE BOLETO O QUIEN ACREDITE LA PROPIEDAD MEDIANTE UN FORMATO REQUISITADO E IDENTIFICACIÓN, SE LE PERMITIRA LA SALIDA CON EL VEHÍCULO"),0,"C");
    /* el primer numero representa el ancho, el segundo el alto(interlineado)*/ 
    $pdf->SetFont('Arial','',6);
    $pdf->MultiCell(0,2,utf8_decode("1.- Debido a que el estacionamiento es de autoservicio la empresa no se responsabiliza por:\nA) Robo de accesorios, objetos documentos y valores aún a consecuencia de robo total o rotura de cristales.\nB) Daños ocasionados por terceros debido a que el vehículo es conducido por el propietario.\nC) Daños ocasionados por temblor o terremoto, incendio, inundaciones, alborotos populares o huelgas.\nD) Daños mecánicos y/o eléctricos de cualquiér índole oncluyendo piezas y/o accesorios mecánicos o eléctricos.\nE) Falta de aviso oportuno por la perdida del presente boleto.\n2.- En caso de robo total, el cliente acepta de antemano por concepto de indemnización la cantidad que la compañia de seguros(Contratada por la empresa) asigne.\n3.- Después del horario de funcionamiento, la empresa cobrará tarifa doble.\n4.- El uso del estacionamiento significa la aceptación de las condiciones descritas.\n5.- No custodiamos ni respondemos por bicicletas, motocicletas, motonetas u otro equivalente.\n\n> Se cobrará únicamente a la salida del vehículo.\n\n> Queda estrictamente prohibido permanecer dentro de los vehículos."),0,'J');/*el primero representa un relleno y el segundo el borde. El tercero es la alineación del texto */
    $pdf->Ln(5);

    $pdf->SetFont('Arial','',9);
    $pdf->MultiCell(0,4,utf8_decode("ABRIMOS LOS 365 DIAS DEL AÑO.\nHORARIO\nLUNES A SÁBADO: 8:30 A 21:00 HRS."),0,'C');
    $pdf->SetFont('Arial','B',9);
    $pdf->MultiCell(0,7,utf8_decode("NO TENEMOS TIEMPO DE TOLERANCIA."),0,'C');
    $pdf->MultiCell(0,7,("COSTO POR BOLETO PERDIDO"),0,'C');
    $pdf->SetFont('Arial','B',14);
    $pdf->MultiCell(0,7,utf8_decode("$ 100.00"),0,'C');
    $pdf->SetFont('Arial','B',9);
    $pdf->MultiCell(0,7,utf8_decode("(MÁS TIEMPO TRANSCURRIDO)"),0,'C');

    $pdf->Ln(9);

    
    
    # Nombre del archivo PDF #
    $pdf->Output("I","Folio ".$folio,true);
    ?>

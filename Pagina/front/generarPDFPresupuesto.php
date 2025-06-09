<?php 

    session_start();

    $user = "root";
    $pass = "";
    $host = "localhost";
    $dbname = "turboengine";

    $conexion = mysqli_connect($host, $user, $pass, $dbname);

    // Verificar si la conexión es exitosa antes de cerrarla
    if (!$conexion) {
        mysqli_close($conexion);
    }

    if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 2) {
        header("Location: ../front/login.html?error=No tienes permiso para acceder");
        exit();
    }

    require '../libreriaFPDF/fpdf.php';

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',10);

    if (!isset($_GET['id_presupuesto'])) {
       die("ID de presupuesto no proporcionado.");
    }

    $id_presupuesto = intval($_GET['id_presupuesto']);

    $query = "SELECT p.id_presupuesto, u.dni, p.matricula, p.servicio, p.descripcion, p.respuesta, 
                    p.fecha_solicitud, p.fecha_respuesta, p.estado, p.precio
            FROM presupuestos p
            JOIN usuarios u ON p.id_usuario = u.id_usuario
            WHERE p.id_presupuesto = $id_presupuesto";

    $resultado = mysqli_query($conexion, $query);

    if (!$resultado || mysqli_num_rows($resultado) == 0) {
        die("No se encontró el presupuesto.");
    }

    $datos = mysqli_fetch_assoc($resultado);

    $idPresupuesto = $datos['id_presupuesto'];
    $dni = $datos['dni'];
    $nombre = $_SESSION['nombre'];
    $apellidos = $_SESSION['apellidos'];
    $correo = $_SESSION['correo'];
    $matricula = $datos['matricula'];
    $servicio = $datos['servicio'];
    $descripcion = $datos['descripcion'];
    $descripcion = $datos['descripcion'];
    $respuesta = $datos['respuesta'];
    $fechaSolicitud = $datos['fecha_solicitud'];
    $fechaRespuesta = $datos['fecha_respuesta'];
    $precio = $datos['precio'];
    
    
    // Calcular el IVA (21%) y el total con IVA
    $iva = $precio * 0.21;
    $total_con_iva = $precio + $iva;

    $directorio = '../pdfs/';
    // Si el directorio no existe, lo crea con permisos 0755
    if (!is_dir($directorio)) {
        mkdir($directorio, 0755, true); // true para crear carpetas anidadas si fuera necesario
    }

    // Nombre del archivo
    $nombre_archivo = "id_presupuesto" . $idPresupuesto . ".pdf";

    // Ruta completa
    $ruta_completa = $directorio . $nombre_archivo;

    // Crear una clase personalizada heredando de FPDF
    class PDF extends FPDF {
        function Header() {
            $this->Image('../assets/Logo1.jpeg', 10, 10, 30);
            $this->SetFont('Arial', 'B', 16);
            $this->Cell(190, 10, 'Factura del Presupuesto', 0, 1, 'C');
            $this->Ln(20);
        }

        function Footer() {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 10);
            $this->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', "Página") . $this->PageNo(), 0, 0, 'C');
        }
    }

    // Crear el objeto PDF
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);

    // Información de la factura
    $pdf->Ln(5);
    $pdf->Cell(0, 20, 'Factura N: ' . $idPresupuesto, 0, 1);
    $pdf->Ln(5);

    $pdf->SetX(25);
    $pdf->Cell(40, 10, 'Nombre', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Apellidos', 1, 0, 'C');
    $pdf->Cell(40, 10, 'DNI', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Fecha', 1, 0, 'C');
    $pdf->Ln(10);

    $pdf->SetX(25);
    $pdf->Cell(40, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $nombre), 1, 0, 'C');
    $pdf->Cell(40, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $apellidos), 1, 0, 'C');
    $pdf->Cell(40, 10, $dni, 1, 0, 'C');
    $pdf->Cell(40, 10, $fechaRespuesta, 1, 0, 'C');
    $pdf->Ln(30);



    // Detalle del trabajo
    $pdf->SetX(25);
    $pdf->Cell(80, 10, 'Servicio', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Precio sin iva', 1, 1, 'C');

    $pdf->SetX(25);
    
    $pdf->Cell(80, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $servicio), 1, 0, 'C');
    $pdf->Cell(50, 10, number_format($precio, 2) . ' EUR', 1, 1, 'C');

    
    $pdf->Ln(15);
    $pdf->Cell(90, 10, 'SubTotal:', 0, 0);
    $pdf->Cell(50, 10, number_format($precio, 2) . ' EUR', 0, 1);

    $pdf->Cell(90, 10, 'IVA (21%):', 0, 0);
    $pdf->Cell(50, 10, number_format($iva, 2) . ' EUR', 0, 1);

    $pdf->Cell(90, 10, 'Total:', 0, 0);
    $pdf->Cell(50, 10, number_format($total_con_iva, 2) . ' EUR', 0, 1);

    $pdf->Ln(20);
    $pdf->Cell(90, 10, 'Firma Taller:', 0, 0);
    $pdf->Cell(50, 10, 'Firma Cliente:', 0, 1);



    // Salida del PDF
    // $pdf->Output('I', 'factura_trabajo.pdf'); // 'I' para mostrar en navegador    
    // Guardar el PDF 
    $pdf->Output('F', $ruta_completa, true);

    // Enviar correo a usuario
    $sqlCorreo = "SELECT correo FROM usuarios WHERE id_usuario = ?";
    $stmt = mysqli_prepare($conexion, $sqlCorreo);
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['id_usuario']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $correo);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

     // Enviar el correo si el email es válido
    if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $asunto = "Factura disponible - TurboEngine";
        $mensaje = "Hola " . $nombre . ",\n\nTu factura ya está disponible en tu cuenta de TurboEngine.\nPuedes acceder a ella iniciando sesión en la web.\n\nSaludos,\nEquipo TurboEngine";
        $cabeceras = "From: no-reply@turboengine.com";

        mail($correo, $asunto, $mensaje, $cabeceras);
    }

    // Redirigir al PDF
    header("Location: ../pdfs/$nombre_archivo");

    session_abort();
?>
<?php
// Incluir la librería TCPDF
require_once('TCPDF-main/tcpdf.php');
include 'conexion.php'; // Incluir la conexión a la base de datos

class MYPDF extends TCPDF {
    // Header
    public function Header() {
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 10, 'Registros de la Escuela de Natacion', 0, 1, 'C');
    }

    // Footer
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Crear una instancia del PDF
$pdf = new MYPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Mostrar los registros de "Horarios"
$pdf->Cell(0, 10, 'Horarios Confirmados', 0, 1, 'L');
$query = "SELECT * FROM horarios";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(50, 10, 'Día: ' . $row['dia'], 0, 0);
    $pdf->Cell(50, 10, 'Hora: ' . $row['hora'], 0, 1);
}

// Agregar una línea de separación
$pdf->Ln(5);

// Mostrar los registros de "Instalaciones"
$pdf->Cell(0, 10, 'Instalaciones Confirmadas', 0, 1, 'L');
$query_instalaciones = "SELECT * FROM instalaciones";
$result_instalaciones = mysqli_query($conn, $query_instalaciones);

while ($row_instalaciones = mysqli_fetch_assoc($result_instalaciones)) {
    $pdf->Cell(50, 10, 'Ubicación: ' . $row_instalaciones['ubicacion'], 0, 0);
    $pdf->Cell(50, 10, 'Descripción: ' . $row_instalaciones['descripcion'], 0, 1);
}

// Agregar una línea de separación
$pdf->Ln(5);

// Mostrar los registros de "Promociones"
$pdf->Cell(0, 10, 'Promociones Aplicadas', 0, 1, 'L');
$query_promociones = "SELECT * FROM promociones";
$result_promociones = mysqli_query($conn, $query_promociones);

while ($row_promociones = mysqli_fetch_assoc($result_promociones)) {
    $pdf->Cell(50, 10, 'Promoción: ' . $row_promociones['titulo'], 0, 0);
    $pdf->Cell(50, 10, 'Usuario ID: ' . $row_promociones['usuario_id'], 0, 1);
}

// Agregar una línea de separación
$pdf->Ln(5);

// Mostrar los registros de "Rehabilitación"
$pdf->Cell(0, 10, 'Terapias de Rehabilitación', 0, 1, 'L');
$query_rehabilitacion = "SELECT * FROM rehabilitacion";
$result_rehabilitacion = mysqli_query($conn, $query_rehabilitacion);

while ($row_rehabilitacion = mysqli_fetch_assoc($result_rehabilitacion)) {
    $pdf->Cell(50, 10, 'Terapia: ' . $row_rehabilitacion['tipo'], 0, 0);
    $pdf->Cell(50, 10, 'Usuario ID: ' . $row_rehabilitacion['usuario_id'], 0, 1);
}

// Salida del PDF
$pdf->Output('registros.pdf', 'I');
?>

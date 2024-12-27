<?php
include "connection.php";
require('fpdf/fpdf.php');

$id = $_GET['id'];

$result = mysqli_query($con, "SELECT * FROM anime WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "Data anime tidak ditemukan.";
    exit;
}

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

$pdf->Cell(190, 10, 'Detail Anime', 0, 1, 'C');

$poster_path = 'poster/' . $row['poster'];
if (file_exists($poster_path)) {
    list($width, $height) = getimagesize($poster_path);
    $aspect_ratio = $width / $height;
    $max_width = 190;
    $max_height = 100;

    if ($aspect_ratio > 1) {
        $new_width = $max_width;
        $new_height = $max_width / $aspect_ratio;
    } else {
        $new_height = $max_height;
        $new_width = $max_height * $aspect_ratio;
    }

    $x = (210 - $new_width) / 2;
    $pdf->Image($poster_path, $x, 30, $new_width, $new_height);
    $pdf->Cell(190, $new_height + 20, '', 0, 1);
} else {
    $pdf->Cell(190, 10, 'Poster tidak ditemukan', 1, 1, 'C');
}

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, 'ID', 0);
$pdf->Cell(140, 10, ':' . $row['id'], 0, 1);
$pdf->Cell(50, 10, 'Judul:', 0);
$pdf->Cell(140, 10, ':' . $row['title'], 0, 1);
$pdf->Cell(50, 10, 'Genre:', 0);
$pdf->Cell(140, 10, ':' . $row['genre'], 0, 1);
$pdf->Cell(50, 10, 'Tahun Rilis:', 0);
$pdf->Cell(140, 10, ':' . $row['release_date'], 0, 1);
$pdf->Cell(50, 10, 'Deskripsi:', 0);
$pdf->MultiCell(140, 10, ':' . $row['description'], 0);

$pdf->Output();
?>
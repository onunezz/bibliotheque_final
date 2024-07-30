<?php
class PdfModel
{
    static public function generateLoanPdf($loan)
    {
        define('FPDF_FONTPATH', 'vendor/fpdf/font');
        require_once 'vendor/fpdf/fpdf.php';

        $loanDateObj = new DateTime($loan['loan_date']);
        $formattedLoanDate = $loanDateObj->format('d-m-Y');

        $returnDateObj = new DateTime($loan['return_date']);
        $formattedReturnDate = $returnDateObj->format('d-m-Y');

        $pdf = new FPDF('P', 'mm', array(80, 150));
        $pdf->AddPage();
        $pdf->SetMargins(5, 5, 5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, utf8_decode('bibliotheque'), 0, 1, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(72, 5, utf8_decode("Detalle de préstamo"), 1, 1, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(60, 5, 'Libros', 1, 0, 'L');
        $pdf->Cell(12, 5, 'Cant.', 1, 1, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(60, 5, utf8_decode($loan['title']), 1, 0, 'L');
        $pdf->Cell(12, 5, $loan['amount'], 1, 1, 'L');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(72, 5, utf8_decode("Cliente"), 1, 1, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(72, 5, 'Nombre', 1, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Ln();
        $pdf->Cell(72, 5, utf8_decode($loan['last_name_client'] . ' ' . $loan['name_client']), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(0, 10, utf8_decode('Fecha de préstamo: ' . $formattedLoanDate), 0, 1);
        $pdf->Cell(0, 10, utf8_decode('Fecha de devolucion: ' . $formattedReturnDate), 0, 1);

        ob_end_clean();

        $route = 'bibliotheque - Prestamo-' . $loan['id'] . '-' . $loan['last_name_client'] . '.pdf';
        $pdf->Output('I', $route);

        return $route;
    }
}

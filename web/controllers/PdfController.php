<?php
class PdfController
{
    static public function loanPdf($id_loan, $last_name_client)
    {
        $loan = LoanController::getLoanDetails($id_loan);
        if (!$loan) {
            die('Detalles del préstamo no encontrados.');
        }

        $route = PdfModel::generateLoanPdf($loan);

        if (file_exists($route)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="Prestamo-' . $id_loan . "-" . $last_name_client . '.pdf"');
            header('Content-Length: ' . filesize($route));
            ob_clean();
            flush();
            readfile($route);
            unlink($route);
            exit;
        } else {
            die('El archivo PDF no existe.');
        }
    }
}

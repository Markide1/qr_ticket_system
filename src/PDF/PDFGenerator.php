<?php
namespace App\PDF;

use TCPDF;

class PDFGenerator {
    private $pdf;

    public function __construct() {
        $this->pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    }

    public function generateTicket($ticketData, $qrImage) {
        // Basic PDF setup
        $this->pdf->SetCreator('QR Ticket System');
        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);
        $this->pdf->AddPage();

        // Center the QR code on the page
        $pageWidth = $this->pdf->getPageWidth();
        $pageHeight = $this->pdf->getPageHeight();
        
        // Make QR code larger
        $qrSize = 100; // Increased size
        $x = ($pageWidth - $qrSize) / 2;
        $y = ($pageHeight - $qrSize) / 2;

        // Convert QR image to base64 and save temporarily
        $tempFile = tempnam(sys_get_temp_dir(), 'qr_');
        file_put_contents($tempFile, $qrImage->getString());
        
        // Add QR Code to PDF
        $this->pdf->Image($tempFile, $x, $y, $qrSize, $qrSize, 'PNG');
        
        // Clean up temp file
        unlink($tempFile);

        return $this->pdf->Output('ticket.pdf', 'S');
    }
}
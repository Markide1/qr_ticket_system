<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Config\Database;
use App\Ticket\TicketGenerator;
use App\QR\QRGenerator;
use App\PDF\PDFGenerator;

// Initialize classes
$database = new Database();
$db = $database->getConnection();

// Check if database connection is successful
if (!$db) {
    die("Database connection failed");
}

$qrGenerator = new QRGenerator();
$pdfGenerator = new PDFGenerator();
$ticketGenerator = new TicketGenerator($db, $qrGenerator, $pdfGenerator);

// Test ticket generation
try {
    $ticketId = 1;
    $pdfContent = $ticketGenerator->generateTicket($ticketId);
    
    // Output PDF
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="ticket.pdf"');
    echo $pdfContent;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
<?php
namespace App\Ticket;

class TicketGenerator {
    // Declare properties properly
    private $db;
    private $qrGenerator;
    private $pdfGenerator;

    public function __construct($db, $qrGenerator, $pdfGenerator) {
        // Initialize with proper property assignments
        $this->db = $db;
        $this->qrGenerator = $qrGenerator;
        $this->pdfGenerator = $pdfGenerator;
    }

    public function generateTicket($ticketId) {
        // Get ticket data
        $query = "SELECT t.*, e.event_name, e.event_date, e.venue, u.name, u.email 
                 FROM tickets t 
                 JOIN events e ON t.event_id = e.event_id 
                 JOIN users u ON t.user_id = u.user_id 
                 WHERE t.ticket_id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$ticketId]);
        $ticketData = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$ticketData) {
            throw new \Exception("Ticket not found");
        }

        // Format the date nicely
        $formattedDate = date('Y-m-d', strtotime($ticketData['event_date']));
        
        // Format QR data with clean layout
        $qrData = sprintf(
            "Event: %s | " .
            "Date: %s | " .
            "User: %s | " .
            "Amount: $%.2f",
            $ticketData['event_name'],
            $formattedDate,
            $ticketData['name'],
            $ticketData['payment_amount']
        );

        $qrImage = $this->qrGenerator->generate($qrData);
        return $this->pdfGenerator->generateTicket($ticketData, $qrImage);
    }
}
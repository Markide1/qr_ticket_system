<?php
namespace App\QR;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class QRGenerator {
    public function generate($data) {
        $qr = QrCode::create($data)
            ->setSize(400)       
            ->setMargin(5)      
            ->setErrorCorrectionLevel(new \Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh()); 
        
        $writer = new PngWriter();
        return $writer->write($qr);
    }
}
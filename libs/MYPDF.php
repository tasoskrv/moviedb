<?php

class MYPDF extends TCPDF {
    // Page footer
    public function Footer() {
        define("FTITLE", "footer" . " ");
        define("PATH", "libs/pdf/images/GRC12121712");
        define("PAGE", "Σελιδα");
        // Set font
        $this->SetFont('arial', 'I', 8);
        // Logo
        if (COPYRIGHT == true) {
            // Position at 15 mm from bottom
            //$this->SetY(10);
            $image_file = PATH . "/bcloud.png";
            $this->Image($image_file, 10, 285, 30, "", "png", "", "T", false, 300, "", false, false, 0, false, false, false);
            // Page number
            $this->Cell(0, 0, FTITLE . PAGE . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        } else {
            $this->SetY(-15);
            $this->Cell(0, 10, FTITLE . PAGE. $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        }
    }

}
?>

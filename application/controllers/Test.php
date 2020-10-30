<?php
use Libraries\Email;
use Libraries\REST_Controller;
use Libraries\SmartResponse;
use Libraries\LetterFPDF;

defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends REST_Controller{

    public function pdf_get(){
        $title = $this->get("title");
        $description = $this->get("description"); 
        $repeat = $this->get("repeat");

        $pdf = new LetterFPDF();       
        $pdf->AddPage();
        $pdf->SetFont('Arial','',10);

        $pdf->Cell(40,10,'Parametro recibido: '.$title);
        $pdf->LN();
        $pdf->Cell(40,10,'Parametro recibido: '.$description);
        $pdf->LN();
        $pdf->LN();

        $pdf->Cell(40,10,'Repeat = '.$repeat);
        $pdf->LN();
        for ($i=0; $i < $repeat; $i++) { 
            $pdf->Cell(40,10, '['.$i.'] Hola, Mundo ');
            $pdf->LN();
           
        }
        $pdf->Output();
    }

    public function time_get(){
        $fromTimestamp = $this->get("fromTimestamp");
        $toTimestamp = $this->get("toTimestamp");
        
        $fromDate = new \DateTime();
        $fromDate->setTimezone(new \DateTimeZone("America/Mexico_City"));
        $fromDate->setTimestamp($fromTimestamp);

        $toDate = new \DateTime();
        $toDate->setTimezone(new \DateTimeZone("America/Mexico_City"));
        $toDate->setTimestamp($toTimestamp);

       


        $response = new SmartResponse();

    }

    public function uploadFile_post(){
        $response = new SmartResponse();

        $directory = './uploads/test/';
        $filename = "logo.png";

        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $files = $_FILES['files']['tmp_name'];

        foreach($files as $file){
            move_uploaded_file($file, $directory.$filename);
        }
  
      
        $response->onSuccess();
        $this->response($response->toJson(), $response->statusCode);
    }

}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
// use Pdf;
use Barryvdh\DomPDF\Facade\Pdf;
class PdfController extends Controller
{
    

    public function index(){

    // $pdf = Pdf::loadView('pdf.template', $data);
    $pdf = Pdf::loadHTML(' i am pdf from Controler  file');

    // 1st way for browser output
    // return $pdf->stream('sample.pdf');

     // 2nd way for dwonload 
    // return $pdf->download('sample.pdf');

    // 3rd way for save in project  
    // $filePath = public_path('pdfs/sample.pdf');  
    // $pdf->save($filePath);
    // return "PDF has been saved to: " . $filePath;

    }


    public function addTextToPDF()
    {
        // Path to the original PDF
        $originalPDF = public_path('sample.pdf');
        $outputPDF = public_path('updated.pdf');

        // Create a new instance of FPDI
        $pdf = new Fpdi();

        // Load the existing PDF
        $pageCount = $pdf->setSourceFile($originalPDF);

        // Loop through all pages of the PDF
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);

            // Add a new page with the same dimensions
            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);

            // Add your text at a specific position
            if ($pageNo == 1) { // Add text only on the first page
                $pdf->SetFont('Helvetica', '', 12); // Set font and size
                $pdf->SetTextColor(0, 0, 0); // Set text color (black)
                $pdf->SetXY(50, 100); // Set position (X = 50, Y = 100)
                $pdf->Write(10, "This is the added text at (50, 100).");
            }
        }

        // Save the updated PDF
        $pdf->Output($outputPDF, 'F');

        return response()->download($outputPDF); // Return the modified PDF to the user
    }



}

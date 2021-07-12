<?php

namespace App\Http\Helpers;

use Dompdf\Dompdf;
use Exception;
use Illuminate\Support\Facades\App;
use mikehaertl\wkhtmlto\Pdf;

class PdfHelper
{
    public static function create_pdf_report($html, $report_name, $orientation = 'landscape') {
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
//        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->setPaper('A4', $orientation);
        $dompdf->render();
//        $dompdf->stream($report_name . '.pdf');
        return $dompdf->output();
    }

    public static function wkhtmltopdf($paper_size = "A4", $report_name = '', $html, $orientation = 'landscape', $toString = TRUE) {
        $pdf = new Pdf(array(
            'commandOptions' => array(
                'useExec' => true,
                'escapeArgs' => false,
                'procOptions' => array(
                    // This will bypass the cmd.exe which seems to be recommended on Windows
                    'bypass_shell' => true,
                    // Also worth a try if you get unexplainable errors
                    'suppress_errors' => true,
                ),
            )));
        $globalOptions = array(
            // 'no-outline',
            'page-size' => $paper_size,
            'orientation' => $orientation
        );

        $pdf->setOptions($globalOptions);
        $pdf->addPage($html);
        if (App::environment('local')) {
            $pdf->binary = 'C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf';
        } else {
            $pdf->binary = 'xvfb-run /usr/local/bin/wkhtmltopdf';
        }
        if ($toString) {
            $content = $pdf->toString();
            if ($content === false) {
                throw new Exception('Could not create PDF: '.$pdf->getError());
            } else {
                return $content;
            }
        } else {
            if (!$pdf->send()) {
                throw new Exception('Could not create PDF: '.$pdf->getError());
            }
        }
//        var_dump($pdf->getError());exit;
    }

    public static function create_pdf($report_name, $paper_size = 'A4') {
        set_time_limit(0);
        ini_set("memory_limit", "864M");
        $pdf = new Pdf(array(
            'commandOptions' => array(
                'useExec' => true,
                'escapeArgs' => false,
                'procOptions' => array(
                    // This will bypass the cmd.exe which seems to be recommended on Windows
                    'bypass_shell' => true,
                    // Also worth a try if you get unexplainable errors
                    'suppress_errors' => true,
                ),
            )));
        $globalOptions = array(
            // 'no-outline',
            'page-size' => $paper_size,
            'orientation' => 'landscape'
        );

        $pdf->setOptions($globalOptions);
        return $pdf;
    }

    public static function add_page($pdf, $html) {
        $pdf->addPage($html);
    }

    public static function send_pdf($pdf) {
        if (App::environment('local')) {
            $pdf->binary = 'C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf';
        } else {
            $pdf->binary = 'xvfb-run /usr/local/bin/wkhtmltopdf';
        }
        if (!$pdf->send()) {
            throw new Exception('Could not create PDF: '.$pdf->getError());
        }
    }
}
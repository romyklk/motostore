<?php

namespace App\Service;

use Dompdf\Dompdf;
use Twig\Environment;

class PdfGenerator
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function generatePdfFromTemplate(string $template, array $parameters): string
    {
        $html = $this->twig->render($template, $parameters);
        return $this->generatePdf($html);
    }

    public function generatePdf(string $html): string
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        return $dompdf->output();
    }
}

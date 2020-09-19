<?php
/**
 * test 03 - using twig and css file
 *
 * 09/2020
 */

require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use WhyooOs\Util\UtilFilesystem;
use WhyooOs\Util\UtilTwigV2;

$options = new Options();
$options->set('defaultFont', 'Courier');

$dompdf = new Dompdf($options);
$dompdf->setPaper('A4', 'portrait');

$html = UtilTwigV2::renderTemplate(__DIR__ . '/templates/test_03.html.twig', [
    'css' => file_get_contents(__DIR__ . '/assets/styles/test_03.css'),
]);

$dompdf->loadHtml($html);
$dompdf->render();

file_put_contents(UtilFilesystem::replaceExtension(__FILE__, 'pdf'), $dompdf->output());



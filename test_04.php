<?php
/**
 * test 04 - using twig and css file and absolute positioning of divs
 *
 * 09/2020
 */

require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use WhyooOs\Util\UtilDebug;
use WhyooOs\Util\UtilFilesystem;
use WhyooOs\Util\UtilImage;
use WhyooOs\Util\UtilTwigV2;

$options = new Options();
$options->setDpi(96); // relevant when using px .. and for images
$options->set('isRemoteEnabled', true);
$options->setIsRemoteEnabled(true);

$dompdf = new Dompdf($options);
$dompdf->setPaper('A4', 'portrait');
list($paperWidthPt, $paperHeightPt) = array_slice($dompdf->getPaperSize(), 2); // Dimensions of paper in points
// UtilDebug::d($paperWidthPt, $paperHeightPt); // 595.28 x 841.89


$html = UtilTwigV2::renderTemplate(__DIR__ . '/templates/test_04.html.twig', [
    'css'     => file_get_contents(__DIR__ . '/assets/styles/test_04.css'),
    'image'   => UtilImage::base64EncodePhysicalImage(__DIR__.'/assets/images/drawing.svg'),
    'options' => $options,
]);


//$svg = file_get_contents('/home/marc/devel/erfolgsjournal.docker/dompdf_tests/drawing.svg');
//$html = '<img src="data:image/svg+xml;base64,'.base64_encode($svg).'"  width="100" height="100" />';




$dompdf->loadHtml($html);
$dompdf->render();

file_put_contents(UtilFilesystem::replaceExtension(__FILE__, 'pdf'), $dompdf->output());



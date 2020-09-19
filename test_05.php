<?php
/**
 * test 05 - using GridLayoutRenderer and scss
 *
 * 09/2020
 */

require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use Mcx\GridLayoutRenderer;
use WhyooOs\Util\UtilFilesystem;
use WhyooOs\Util\UtilJson;
use WhyooOs\Util\UtilTwigV2;

$options = new Options();
$options->setDpi(96); // relevant when using px .. and for images
$options->set('isRemoteEnabled', true);
$options->setIsRemoteEnabled(true);

$dompdf = new Dompdf($options);
$dompdf->setPaper('A4', 'portrait');
[$paperWidthPt, $paperHeightPt] = array_slice($dompdf->getPaperSize(), 2); // Dimensions of paper in points
// UtilDebug::d($paperWidthPt, $paperHeightPt); // ==> 595.28 x 841.89



$scssCompiler = new ScssPhp\ScssPhp\Compiler();

// ---- grid layout
$gridLayout = UtilJson::loadJsonFile(__DIR__ . '/grid_layouts/grid_layout_02.json', true);
$gridLayoutRenderer = new GridLayoutRenderer();
$gridLayoutRenderer->setUnit('pt');
$gridLayoutRenderer->setPaperSize($paperWidthPt, $paperHeightPt);
$gridLayoutRenderer->setGridGap(4, 4);
$gridLayoutRenderer->setMargin(4, 4, 4, 4);

$gridAreaDivs = $gridLayoutRenderer->renderGridLayout($gridLayout, 'grid-area', 'grid-area-');

$html = UtilTwigV2::renderTemplate(__DIR__ . '/templates/test_05.html.twig', [
    'css'          => $scssCompiler->compile(file_get_contents(__DIR__ . '/assets/styles/test_05.scss')),
    'gridAreaDivs' => $gridAreaDivs,
]);

$dompdf->loadHtml($html);
$dompdf->render();

file_put_contents(UtilFilesystem::replaceExtension(__FILE__, 'pdf'), $dompdf->output());



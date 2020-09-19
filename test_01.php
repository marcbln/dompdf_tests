<?php
/**
 * test 01 domdpf with options
 *
 * 09/2020
 */


require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use WhyooOs\Util\UtilFilesystem;

$options = new Options();
$options->set('defaultFont', 'Courier');

$dompdf = new Dompdf($options);
$dompdf->setPaper('A4', 'portrait');

$dompdf->loadHtml('hello from dompdf');
$dompdf->render();

file_put_contents(UtilFilesystem::replaceExtension(__FILE__, 'pdf'), $dompdf->output());



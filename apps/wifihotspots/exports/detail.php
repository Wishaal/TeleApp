<?php
/**
 * Created by PhpStorm.
 * User: Wishaal
 * Date: 10/19/2016
 * Time: 8:35 PM
 */
include('../php/database.php');
require_once('../../../php/conf/config.php');
require_once('../../../php/classes/PHPExcel.php');    //php excel lib

include('../../../domain/wifihotspots/Sessions.php');
use Illuminate\Database\Query\Expression as raw;



$datum1 =  $_SESSION['wifi']['datum1'];
$datum2 =  $_SESSION['wifi']['datum2'];
$locatie =  $_SESSION['wifi']['locatie'];


$detail = Sessions::select('client_mac','client_ip','location','mobile','created_at')
    ->whereBetween('created_at', array($datum1.' 00:00:00', $datum2.' 23:59:59'))
    ->where('location','=',$locatie)
    ->get();

/* Set locale to Dutch */
setlocale(LC_ALL, 'nld_nld');

/* Output: vrijdag 22 december 1978 */
$date = date('d F Y');



$html .= '<table width="100%" border="1" style="font-family: Arial; border-collapse: collapse">
         
          <thead>
          <tr>
            <th>#</th>
                                            <th>Mobielnummer</th>
                                            <th>Lokatie</th>
                                            <th>MAC</th>
                                            <th>IP</th>
                                            <th>Datum</th>
          </tr>
          </thead>
          <tbody>';

$count = 0;
$sum = 0;
foreach ($detail as $r) {

    $count++;
    $html .= '<tr>
                                          	<td>' . $count . '</td> 
												<td>' . $r['mobile'] . '</td> 
												<td>' . $r['location'] . '</td> 
												<td>' . $r['client_mac'] . '</td> 
												<td>' . $r['client_ip'] . '</td> 
												<td>' . $r['created_at'] . '</td> 
                                              </tr>';

}
$html .= '<tr></tr>';
$html .= '</tbody></table><p></p>';



// Put tde html into a temporary file
$tmpfile = 'report.html';
file_put_contents($tmpfile, $html);

$file = "report.xlsx";
$objReader = PHPExcel_IOFactory::createReader('HTML');
$objPHPExcel = $objReader->load($tmpfile);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($file);

header('Content-disposition: attachment; filename=' . $file);
header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Length: ' . filesize('report.xlsx'));
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');
ob_clean();
flush();
readfile($file);
unlink($file);
unlink($tmpfile);
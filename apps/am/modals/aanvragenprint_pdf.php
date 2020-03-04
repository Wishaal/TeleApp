<?php
require_once('../../../php/conf/config.php');
require_once('../php/config.php');

include "../domain/Aanvragen.php";
include "../domain/Aanvragenparts.php";
include "../domain/Werkorder.php";
include "../domain/Afdeling.php";
include "../domain/Personeel.php";
include "../domain/Artikel.php";

$aanvragen = Aanvragen::find($_GET['id']);
$aanvragenparts = Aanvragenparts::where("aanvraagnr", "=", $_GET['id'])->get();
$werkorder = Werkorder::where("aanvraagnr", "=", $_GET['id'])->orderBy('volgnr', 'desc')->get();

$afdeling = Afdeling::find($aanvragen->afdelingcode);
$personeel = Personeel::find($aanvragen->badgenr);
$artikel = Artikel::find($aanvragen->artikelcode);

require_once("../../../php/classes/MPDF57/mpdf.php");

$mpdf = new mPDF('utf-8', 'A4', '', '', 20, 20, 40, 15, 10, 10);


$mpdf->mirrorMargins = 0;    // Use different Odd/Even headers and footers and mirror margins


$html .= ' 
<html>
	<head>
		<link href="assets/_layout/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<style>
		table, td, th {
			border: 0px solid black;
			text-align: left;
			font-size: 14px;
		}
		</style>		
	</head>
	<body>
		<table>
            <tr>
                <th colspan="5"><img src="telesur_logo.png"><br>Telecommunicatiebedrijf Suriname<br>Afdeling Voorraadbeheer<br>Tweede Rijweg 34 - Paramaribo - Suriname<br><br><br></th>
            </tr>
            <tr>
				<td><br>Requestnr<br>Requestdate<br>Requested by<br>Department<br>Article<br>Quantity<br><br></td>
				<td align="right" width="10%"><br>
						' . $aanvragen->aanvraagnr . '<br>
						' . $aanvragen->aanvraagdatum . '<br>
						' . $aanvragen->badgenr . '<br>
						' . $aanvragen->afdelingcode . '<br>
						' . $aanvragen->artikelcode . '<br>
						' . $aanvragen->aantal . '<br></td>
				<td colspan="3"><br>
						<br>
						<br>
						' . " - " . $personeel->naam . " " . $personeel->voornaam . '<br>
						' . " - " . $afdeling->afdelingnaam . '<br>
						' . " - " . $artikel->artikelnaam . '<br>
						<br><br><br><br><br></td>
			</tr>
			<tr>
				<th>Serienr</th>
				<th colspan="4">&nbsp;</th>
			</tr>
            <tbody>
			<tr>
				<td>';
foreach ($aanvragenparts as $r) {
    $html .= $r->serienr . '<br>';
}
$rpersoneel = Personeel::find($r->rbadgenr);
$dpersoneel = Personeel::find($r->dbadgenr);
$html .= '<br><br><br><br></td>
				<td colspan="4">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="3">Naam Ontvanger<br><br><br><br><br><br><br><br><b><nobr>' . $r->rbadgenr . " - " . $rpersoneel->naam . " " . $rpersoneel->voornaam . '</nobr></b><br>' . $werkorder[0]->aanvraagafgemeld . '</td>
				<td colspan="2">Naam Verstrekker<br><br><br><br><br><br><br><br><b><nobr>' . $r->dbadgenr . " - " . $dpersoneel->naam . " " . $dpersoneel->voornaam . '</nobr></b><br>' . $werkorder[0]->aanvraagafgemeld . '</td>
			</tr>
            </tbody>
        </table>
	</body>
</html>
';
$mpdf->WriteHTML($html);

$mpdf->Output();
exit;

?>
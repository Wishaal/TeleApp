<?php

include("Classes/MPDF54/mpdf.php");

$mpdf = new mPDF('en-x', 'A4', '', '', 20, 20, 47, 47, 10, 10);

$mpdf->mirrorMargins = 0;    // Use different Odd/Even headers and footers and mirror margins

$header = '
<table width="100%" style="vertical-align: bottom; font-family: Arial; font-size: 9pt; color: #000088;">
	<tr>
		<td width="100%"><img src="logo.png" width="200px" /></td>
	</tr>
</table>';

$footer = '<div align="center" style="font-family: Arial">{PAGENO}</div>';
$mpdf->SetHTMLHeader($header);
$mpdf->SetHTMLFooter($footer);

$pagetitle = 'Prepaid Nationaal - A-nr als criteria';


$html = '
<style>
	td {
		padding: 3px 5px;	
		font-size: 12px;
	}
	
	thead td {
		background: #66bbff;	
	}
</style>
';

$html .= '<h2 style="font-family: Arial">' . $pagetitle . '</h2>';

$html .= '<table border="0" style="font-family: Arial">
	<tr>
		<td>Aansluitnummer</td>
		<td>8664894</td>
	</tr>
	<tr>
		<td>Begindatum</td>
		<td>2012-11-25</td>
	</tr>
	<tr>
		<td>Einddatum</td>
		<td>2012-11-26</td>
	</tr>
	<tr>
		<td>Naam</td>
		<td>Simon Noerdjan</td>
	</tr>
	<tr>
		<td>Debiteurnummer</td>
		<td>-</td>
	</tr>
	<tr>
		<td>Aantal records</td>
		<td>5</td>
	</tr>
</table>';

$html .= '<br />';


$html .= '<table border="1" style="font-family: Arial; border-collapse: collapse">
<thead>
<tr>
	<td><strong>#</strong></td>
	<td><strong>B-nr</strong></td>
	<td><strong>Naam</strong></td>
	<td><strong>Type</strong></td>
	<td><strong>Datum/tijd</strong></td>
	<td><strong>Verbr(sec)</strong></td>
	<td><strong>Valuta</strong></td>
	<td><strong>Saldo</strong></td>
	<td><strong>SMS Saldo</strong></td>
	<td><strong>Bonus Saldo</strong></td>
</tr>
</thead>';

//data
$count = 0;
for ($i = 0; $i < 10; $i++) {
    $count++;
    $html .= '
		<tr>
			<td>' . $count . '</td>
			<td>8664894</td>
			<td>Simon Noerdjan</td>
			<td>call</td>
			<td>2012-11-25 00:00:01</td>
			<td align="right">2</td>
			<td>US</td>
			<td align="right">0.20</td>
			<td align="right">34</td>
			<td align="right">20</td>
		</tr>
	';
}

//totalen
$html .= '
	<tr>
		<td>Tot.</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td align="right">22</td>
		<td>US</td>
		<td align="right">200</td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td align="right">00:00:22</td>
		<td>SR$</td>
		<td align="right">600</td>
		<td></td>
		<td></td>
	</tr>
';

$html .= '</table>';

$mpdf->WriteHTML($html);

$mpdf->Output('export.pdf', 'D');
exit;

?>
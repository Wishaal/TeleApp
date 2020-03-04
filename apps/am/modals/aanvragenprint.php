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
?>
<form name="inputform" id="inputform" enctype="multipart/form-data" xmlns="http://www.w3.org/1999/html"
      xmlns="http://www.w3.org/1999/html">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Leveringsbon</h4>
    </div>
    <div class="modal-body">
        <table class="table">
            <tr>
                <th colspan="4"><br><br><img src="../../../telesur_mis/media/images/telesur_logo.png"><br>Telecommunicatiebedrijf
                    Suriname<br>Afdeling Voorraadbeheer<br>Tweede Rijweg 34 - Paramaribo - Suriname<br><br></th>
            </tr>
            <tr>
                <td><br>Requestnr<br>Requestdate<br>Requested by<br>Department<br>Article<br>Quantity<br><br></td>
                <td colspan="3"><br>
                    <?php echo $aanvragen->aanvraagnr; ?><br>
                    <?php echo $aanvragen->aanvraagdatum; ?><br>
                    <?php echo $aanvragen->badgenr . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - " . $personeel->naam . " " . $personeel->voornaam; ?>
                    <br>
                    <?php echo $aanvragen->afdelingcode . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - " . $afdeling->afdelingnaam; ?>
                    <br>
                    <?php echo $aanvragen->artikelcode . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - " . $artikel->artikelnaam; ?>
                    <br>
                    <?php echo $aanvragen->aantal; ?><br></td>
            </tr>
            <tr>
                <th>Serienr</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <tbody>
            <tr>
                <td>
                    <?php
                    foreach ($aanvragenparts as $r) {
                        echo $r->serienr . '<br>';
                    }
                    ?><br><br></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">Naam Ontvanger<br><br><br><br><b><?php $personeel = Personeel::find($r->rbadgenr);
                        echo $r->rbadgenr . " - " . $personeel->naam . " " . $personeel->voornaam; ?></b><br><?php echo $werkorder[0]->aanvraagafgemeld; ?>
                </td>
                <td colspan="2">Naam Verstrekker<br><br><br><br><b><?php $personeel = Personeel::find($r->dbadgenr);
                        echo $r->dbadgenr . " - " . $personeel->naam . " " . $personeel->voornaam; ?></b><br><?php echo $werkorder[0]->aanvraagafgemeld; ?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="modal-footer"></div>
</form>

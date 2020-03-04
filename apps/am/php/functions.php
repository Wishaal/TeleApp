<?php
require_once('config.php');

function generateAanvraagNr()
{
    require_once("domain/Aanvragennr.php");
    $aanvragennr = Aanvragennr::all('aanvraagnr');

    $waardejaar = date('Y');
    $waardemaand = date('m');
    $waardevolgnr = '0';

    if (count($aanvragennr) > 0) {
        $aanvraagnr_array = array();
        foreach ($aanvragennr as $r) {
            $aanvraagnr_array[] = $r->aanvraagnr;
        }
        $maxwaarde = max($aanvraagnr_array);
        $maxwaardejaar = substr($maxwaarde, 0, 4);
        $maxwaardemaand = substr($maxwaarde, 4, 2);
        $maxwaardevolgnr = substr($maxwaarde, 6);
    } else {
        $maxwaardejaar = $waardejaar;
        $maxwaardemaand = $waardemaand;
        $maxwaardevolgnr = $waardevolgnr;
    }

    if ($maxwaardejaar <> $waardejaar || $maxwaardemaand <> $waardemaand) {
        $nieuwewaarde = ($waardejaar * 1000000) + ($waardemaand * 10000) + $waardevolgnr;
    } else {
        $nieuwewaardenr = $maxwaardevolgnr + 1;
        $nieuwewaarde = ($waardejaar * 1000000) + ($waardemaand * 10000) + $nieuwewaardenr;
    }

    $newaanvnr = new Aanvragennr;
    $newaanvnr->aanvraagnr = $nieuwewaarde;
    $newaanvnr->save();

    return $nieuwewaarde;
}

function getLastWorkorder($specifieknr)
{
    require_once("domain/Werkorder.php");
    $specifiekwerkorder = Werkorder::find($specifieknr);

    $maxwaarde = 0;
    if (count($specifiekwerkorder) > 0) {
        $werkorder_array = array();
        foreach ($specifiekwerkorder as $r) {
            $werkorder_array[] = $r->volgnr;
        }
        $maxwaarde = max($werkorder_array);
    }
    $maxwaarde = $maxwaarde + 1;

    return $maxwaarde;
}

function getStatusType($soort, $statustypenr)
{
    require_once("domain/Statustype.php");
    if ($soort == "id") {
        $statustype = Statustype::find($statustypenr);
        return $statustype;
    } else {
        $statustype = Statustype::where($soort, '=', $statustypenr)->first();
        return $statustype->statusnaam;
    }
}

function getFabrikant($soort, $fabrikantnr)
{
    require_once("domain/Fabrikant.php");
    if ($soort == "id") {
        $fabrikant = Fabrikant::find($fabrikantnr);
        return $fabrikant;
    } else {
        $fabrikant = Fabrikant::where($soort, '=', $fabrikantnr)->first();
        return $fabrikant->name;
    }
}

function getArtikel($soort, $fabrikantnr)
{
    require_once("domain/Artikel.php");
    if ($soort == "id") {
        $artikel = Artikel::find($fabrikantnr);
        return $artikel;
    } else {
        $artikel = Artikel::where($soort, '=', $fabrikantnr)->first();
        return $artikel->artikelnaam . " (" . $artikel->artikelcode . ")";
    }
}

function getPersoneel($soort, $personeelnr)
{
    require_once("domain/Personeel.php");
    if ($soort == "id") {
        $personeel = Personeel::find($personeelnr);
        return $personeel;
    } else {
        $personeel = Personeel::where($soort, '=', $personeelnr)->first();
        return $personeel->naam . " " . $personeel->voornaam;
    }
}

function getAfdeling($soort, $afdelingnr)
{
    require_once("domain/Afdeling.php");
    if ($soort == "id") {
        $afdeling = Afdeling::find($afdelingnr);
        return $afdeling;
    } else {
        $afdeling = Afdeling::where($soort, '=', $afdelingnr)->first();
        //return $afdeling->afdelingcode. " - ". $afdeling->afdelingnaam. " (". $afdeling->kostenplaatscode. ")";
        return $afdeling->afdelingcode . " (" . $afdeling->kostenplaatscode . ")";
    }
}

function getCategorie($soort, $categorienr)
{
    require_once("domain/Categorie.php");
    if ($soort == "id") {
        $categorie = Categorie::find($categorienr);
        return $categorie;
    } else {
        $categorie = Categorie::where($soort, '=', $categorienr)->first();
        return $categorie->categorienaam;
    }
}

?>
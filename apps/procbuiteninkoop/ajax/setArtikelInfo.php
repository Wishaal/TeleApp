<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 5/18/2016
 * Time: 9:35 AM
 */

include('../php/database.php');
include('../php/functions.php');
include('../../../domain/procurementBuitenInkoop/Artikel.php');

$artikel = Artikel::whereId($input->get('artikelcode'))->first();
echo $artikel->toJson();
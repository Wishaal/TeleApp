<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
require '/../../../php/conf/config.php';
include('../php/database.php');
include('../php/functions.php');
include('../../../domain/procurementBuitenInkoop/AanvraagStatus.php');
include('../../../domain/procurementBuitenInkoop/Bestelling.php');
include('../../../domain/procurementBuitenInkoop/BinnenlandseInkoop.php');
include('../../../domain/procurementBuitenInkoop/BuitenlandseInkoop.php');
include('../../../domain/procurementBuitenInkoop/Artikel.php');
include('../../../domain/procurementBuitenInkoop/Leverancier.php');
include('../../../domain/procurementBuitenInkoop/Status.php');
include('../../../domain/procurementBuitenInkoop/User.php');

$OK = true; // We use this to verify the status of the update.

$data = $_GET['name'];
$keywords = preg_split('/[\s,]+/', $_GET['name']);

$search = $keywords;
$query = AanvraagStatus::query();
$fields = array(
    'getAanvraag' => ['aanvraag_nr', 'bstl_aanvraag_datum', 'bstl_afdeling', 'bstl_contactpersoon', 'bstl_ingevoerd_door', 'bstl_omschrijving'],
    'getBuitenlandseInkoop' => ['po_nr'],
    'getAanvraag.artikelInfo' => ['artikel'],
);

// orWhereHas will use joins, so we'll start with fields foreach
foreach ($fields as $relation => $field) {
    if (is_array($field)) {
        // here we join table for each relation
        $query->orWhereHas($relation, function ($q) use ($field, $search) {

            // here we need to use nested where like: ... WHERE key = fk AND (x LIKE y OR z LIKE y)
            $q->where(function ($q) use ($field, $search) {
                foreach ($field as $relatedField) {
                    foreach ($search as $term) {
                        $q->orWhere($relatedField, 'like', "%{$term}%");
                    }
                }
            });
        });
    } else {
        foreach ($search as $term) {
            $query->orWhere($field, 'like', "%{$term}%");
        }
    }
}
$results = $query->get();

if (empty($results)) {
    ?>

    <hgroup class="mb20">
        <h1>Geen resultaten gevonden</h1>
        <h2 class="lead"><strong class="text-danger">0</strong> Er zijn geen resultaten gevonden die overeenkomen met uw
            zoekopdracht.</h2>
    </hgroup>

<?php } else {
    if ($_GET['type'] == 'aanvraag') { ?>
        <hgroup class="mb20">
            <h1>Zoek Resultaten</h1>
            <h2 class="lead"><strong class="text-danger"><?php echo count($results); ?> </strong> results were found for
                the search for <strong class="text-danger"><?php echo $_GET['name']; ?></strong></h2>
        </hgroup>
        <section class="col-xs-12 col-sm-6 col-md-12">
        <?php foreach ($results as $row) {

            ?>
            <article class="search-result row">
                <div class="col-xs-12 col-sm-12 col-md-2">
                    <ul class="meta-search">
                        <li><i class="glyphicon glyphicon-calendar"></i>
                            <span>Aanvraagdatum: <?php echo $row->getAanvraag->bstl_aanvraag_datum; ?></span></li>
                        <li><i class="glyphicon glyphicon-pushpin"></i>
                            <span>Afdeling: <?php echo $row->getAanvraag->bstl_afdeling; ?></span></li>
                        <li><i class="glyphicon glyphicon-send"></i>
                            <span>TBV: <?php echo $row->getAanvraag->bstl_tbv; ?></span></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7">
                    <h3><a href="" data-target="#remoteModal"
                           title=""><?php echo getArtikelCode($row->getAanvraag->bstl_artikelcode); ?>
                            (<?php echo $row->getAanvraag->bstl_omschrijving ?>) </a></h3>
                    <p>Opmerkingen: <?php echo $row->getAanvraag->bstl_opmerkingen ?></p>
                    <i class="glyphicon glyphicon-hand-right"></i>
                    <span>Aanvraag ligt nu bij: <?php echo $row->getUser->username; ?></span>
                    <i class="glyphicon glyphicon-transfer"></i>
                    <span>Huidige status: <?php echo $row->getStatus->kenmerk; ?></span>
                    <p></p>
                    <i class="glyphicon glyphicon-user"></i>
                    <span>Gestart Door: <?php echo strtok(getProfileInfo($mis_connPDO, 'FirstName', $row->getAanvraag->bstl_ingevoerd_door), " ").' '.getProfileInfo($mis_connPDO, 'Name', $row->getAanvraag->bstl_ingevoerd_door); ?></span>
                    <i class="glyphicon glyphicon-globe"></i>
                    <span>Type: <?php echo $row->type == 0 ? "<span class=\"label label-success\"> Binnenland</span>" : "<span class=\"label label-danger\"> Buitenland</span>" ?></span>
                    <i class="glyphicon glyphicon-user"></i>
                    <span>Contactpersoon: <?php echo $row->getAanvraag->bstl_contactpersoon ?></span>
                </div>
                <span class="clearfix border"></span>
            </article>

        <?php }
    } elseif ($_GET['type'] == 'leverancier') {
	?>
	<hgroup class="mb20">
			<h1>Zoek Resultaten</h1>
			<h2 class="lead"><strong class="text-danger"><?php echo count($results); ?> </strong> results were found for the search for <strong class="text-danger"><?php echo $_GET['name'];?></strong></h2>
		</hgroup>
	    <section class="col-xs-12 col-sm-6 col-md-12">
<?php
			foreach ($results as $row) {
				$validatie = $row->type == 0 ? $row->getBinnenlandseInkoop->getLeverancier->name : $row->getBuitenlandseInkoop->getLeverancier->name;
				if (!empty($validatie)){
			?>
	<article class="search-result row">
		<div class="col-xs-12 col-sm-12 col-md-6">
			<ul class="meta-search">
				<li><i class="glyphicon glyphicon-calendar"></i> <span>Naam: <?php echo $row->type == 0 ? $row->getBinnenlandseInkoop->getLeverancier->name : $row->getBuitenlandseInkoop->getLeverancier->name;?></span></li>
				<li><i class="glyphicon glyphicon-pushpin"></i> <span>Contact: <?php echo $row->type == 0 ? $row->getBinnenlandseInkoop->getLeverancier->contact : $row->getBuitenlandseInkoop->getLeverancier->contact;?></span></li>
				<li><i class="glyphicon glyphicon-send"></i> <span>Telefoon: <?php echo $row->type == 0 ? $row->getBinnenlandseInkoop->getLeverancier->phone : $row->getBuitenlandseInkoop->getLeverancier->phone;?></span></li>
			</ul>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6">
			<ul class="meta-search">
				<li><i class="glyphicon glyphicon-calendar"></i> <span>Fax: <?php echo $row->type == 0 ? $row->getBinnenlandseInkoop->getLeverancier->fax : $row->getBuitenlandseInkoop->getLeverancier->fax;?></span></li>
				<li><i class="glyphicon glyphicon-pushpin"></i> <span>Email: <?php echo $row->type == 0 ? $row->getBinnenlandseInkoop->getLeverancier->email : $row->getBuitenlandseInkoop->getLeverancier->email;?></span></li>
			</ul>
		</div>
		<span class="clearfix border"></span>
	</article>

	<?php } }

	}

    echo "</section>";

}
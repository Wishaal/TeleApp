<ol class="breadcrumb">
    <?php
    foreach ($breadcrumbArray as $item) {

        if (!empty($item['title'])) {

            if (!empty($item['url'])) {
                echo '<li><a href="' . $item['url'] . '">' . $item['title'] . '</a></li>';
            } else {
                echo '<li class="active"><strong>' . $item['title'] . '</strong></li>';
            }
        }
    }
    ?>
</ol>
<?php if (($_GET['profileUpdate']) == 'true') {
    echo '<br><div class="alert alert-danger alert-dismissable">
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
             <b>Alert!</b>  Uw profiel is succesvol bijgewerkt. </div>';
} ?>

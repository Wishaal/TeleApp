<?php require_once(TEMPLATE_PATH . 'head.php'); ?>
<?php require_once(TEMPLATE_PATH . 'header_wrapper.php'); ?>
<?php require_once(TEMPLATE_PATH . 'sidebar.php'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <aside class="right-side">
        <!-- Main content -->
        <section class="content-header">
            <h1>
                <?php echo $breadcrumbArray[2]['title'];?>
                <small><?php echo $breadcrumbArray[3]['title'];?></small>
            </h1>
            <?php require_once(TEMPLATE_PATH . 'breadcrumb.tpl.php'); ?>
        </section>
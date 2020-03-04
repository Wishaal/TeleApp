<?php require_once(TEMPLATE_PATH . 'head.php'); ?>

<?php require_once(TEMPLATE_PATH . 'header_wrapper.php'); ?>
    <div class="wrapper row-offcanvas row-offcanvas-left">

        <?php require_once(TEMPLATE_PATH . 'sidebar.php'); ?>
        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side">
            <!-- Main content -->
            <section class="content-header">
                <h1>Woningen verhuur</h1>
                <?php require_once(TEMPLATE_PATH . 'breadcrumb.tpl.php'); ?>
            </section>
            <section class="content"></section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div>
    <!-- ./wrapper -->
<?php require_once(TEMPLATE_PATH . 'footer.php'); ?>
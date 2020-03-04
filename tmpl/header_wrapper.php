<?php
//set online users
require_once('online_users.php');
?>
<body class="skin-blue">
<div class="loader"></div>
<!-- header logo: style can be found in header.less -->
<?php require_once(TEMPLATE_PATH . 'modals/profile.modal.php'); ?>
<header class="header">
    <a href="http://192.168.132.236/telesur_mis"><img src="assets/_layout/img/logo.png" class="logo"/></a>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i>
                    <span class="hidden-xs"><?php echo $_SESSION['mis']['user']['username']; ?> <i
                                class="caret"></i></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header bg-light-blue">
                        <img src="assets/_layout/img/100-128.png" class="img-circle" alt="User Image"/>
                        <p><?php if (!empty($_SESSION['mis']['user']['badgenr'])) {
                                echo getProfileInfo($mis_connPDO, 'werkvoorn', $_SESSION['mis']['user']['badgenr']); ?>, <?php echo getProfileInfo($mis_connPDO, 'werknaam', $_SESSION['mis']['user']['badgenr']);
                                echo '<small>';
                                echo $_SESSION['mis']['user']['badgenr'] . ' | ' . getProfileInfo($mis_connPDO, 'Arbeidsovereenkomst', $_SESSION['mis']['user']['badgenr']);
                                echo '</small>';
                            } ?>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <button data-toggle="modal" data-target=".profile-modal" class="btn btn-warning btn-flat">
                                Profile
                            </button>
                        </div>
                        <div class="pull-right">
                            <a href="logout.php" class="btn btn-danger btn-flat">Sign out</a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-left">
            <?php
            $count = 0;
            foreach ($topnav_items as $item) {
                if ($count < 8) {
                    echo '<li><a href="' . $item['link'] . '">' . $item['title'] . '</a></li>';
                }
                $count++;
            }
            if (count($topnav_items) > 8) {
                echo '<li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Meer Apps... <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">';
                $count = 0;
                foreach ($topnav_items as $item) {
                    if ($count > 7) {
                        echo '<li><a href="' . $item['link'] . '">' . $item['title'] . '</a></li>';
                    }
                    $count++;
                }
                echo '</ul>
                        </li>';
            }
            ?>
        </ul>

    </nav>
</header>

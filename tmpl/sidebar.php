<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="assets/_layout/img/100-128.png" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Welkom, <?php echo $_SESSION['mis']['user']['username']; ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <ul class="sidebar-menu">
            <?php
            if (!empty($sidebar_items)) {
                $count = 0;
                foreach ($sidebar_items as $i) {
                    $count++;

                    $link = '#';
                    if (!empty($i['link'])) $link = $i['link'];

                    $class = '';
                    $parentactive = '';

                    if (isset($_GET['app_section']) && strtolower($i['title']) == $_GET['app_section']) {
                        $class .= 'active ';
                    }

                    if (!empty($i['sub'])) {
                        $class .= 'treeview ';
                    }

                    if ($i['id'] == $activemenuitem['id']) {
                        $class .= 'active ';
                    }

                    if ($parentItem['id'] == $i['id']) {
                        $parentactive .= 'active ';
                    }
                    echo '<li class="' . $class . ' ' . $parentactive . '">
					<a href="' . $link . '"><i class="fa fa-laptop"></i><span>' . $i['title'];
                    echo '</span>';
                    if (!empty($i['sub'])) echo '<i class="fa fa-angle-left pull-right"></i>';
                    echo '</a>';

                    if (!empty($i['sub'])) {
                        echo '<ul class="treeview-menu">';

                        $subcount = 0;

                        foreach ($i['sub'] as $j) {

                            if ($activemenuitem['id'] == $j['id']) {
                                $appactive .= 'class="active"';
                            } else {
                                $appactive = '';
                            }
                            if ($j['selectpermissie'] == 1) { //check for native permissions
                                echo '<li ' . $appactive . '><a href="' . $j['link'] . '"><i class="fa fa-angle-double-right"></i>  ' . $j['title'] . '</a></li>';
                            }
                        }

                        echo '</ul>';
                    }

                    echo '</li>';
                }
            }
            ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
        
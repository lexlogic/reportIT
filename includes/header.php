    <!-- Fixed navbar -->
    <div id="head-nav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="fa fa-gear"></span>
                </button>
                <div>
                    <div class="logo"></div>
                <a href="#" class="navbar-brand"><span>reportIT</span></a>
                </div>
            </div>

            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right user-nav">
                    <li class="dropdown profile_menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo escape($user->data()->username); ?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="../user/?id=<?php echo escape($user->data()->id); ?>">Edit Account</a></li>
                            <li><a href="../login/logout.php">Sign Out</a></li>
                        </ul>
                    </li>
                </ul>


            </div><!--/.nav-collapse -->
        </div>
    </div>

    <div id="cl-wrapper" class="fixed-menu sb-collapsed">
        <div class="cl-sidebar">
            <div class="cl-toggle"><i class="fa fa-bars"></i></div>
            <div class="cl-navblock">
                <div class="menu-space">
                    <div class="content">
                        <ul class="cl-vnavigation">
                            <?php
                            $pages = array(
                                '../dashboard/' => array('Pentester Console' => 'fa-home'),
                                '../schedule/' => array('Engagement Schedule' => 'fa-calendar'),
                                '../reports/' => array('Generate Reports' => 'fa-bar-chart-o'),
                                '../manage/' => array('Manager Console' => 'fa-desktop')
                            ) ;
                            $cur_dir = explode('\\', getcwd());

                            $i = '../'.$cur_dir[count($cur_dir)-1].'/';


                            foreach ($pages as $filename => $pageTitle) {
                                foreach ($pageTitle as $pages => $images) {
                                    if ($i == $filename) {
                                        if($pages == "Manager Console" && $user->hasPermission('peer')) {
                                            $active = '';
                                            echo $active;
                                        }
                                        else if($pages == "Engagement Schedule" && $user->hasPermission('peer')) {
                                            $active = '';
                                            echo $active;
                                        }
                                        else if($pages == "Generate Reports" && $user->hasPermission('peer')) {
                                            $active = '';
                                            echo $active;
                                        }
                                        else {
                                            $active = '<li class="active">';
                                            $active .= '<a href="'.$filename.'">';
                                            $active .= '<i class="fa '.$images.'"></i><span>'.$pages.'</span>';
                                            $active .= '</a></li>';
                                            echo $active;
                                        }
                                    }
                                    else {
                                        if($pages == "Manager Console" && $user->hasPermission('peer')) {
                                            $active = '';
                                            echo $active;
                                        }
                                        else if($pages == "Engagement Schedule" && $user->hasPermission('peer')) {
                                            $active = '';
                                            echo $active;
                                        }
                                        else if($pages == "Generate Reports" && $user->hasPermission('peer')) {
                                            $active = '';
                                            echo $active;
                                        }
                                        else {
                                            $active = '<li>';
                                            $active .= '<a href="'.$filename.'">';
                                            $active .= '<i class="fa '.$images.'"></i><span>'.$pages.'</span>';
                                            $active .= '</a></li>';
                                            echo $active;
                                        }
                                    }
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="text-right collapse-button" style="padding:7px 9px;">
                    <button id="sidebar-collapse" class="btn btn-default" style=""><i style="color:#fff;" class="fa fa-angle-right"></i></button>
                </div>
            </div>
        </div>
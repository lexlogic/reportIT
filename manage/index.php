<?php
require_once '../Init.php';

$user = new User();
if($user->isLoggedIn() && $user->hasPermission('manager')) {
    $totalEngagements = DB::getInstance()->getAssoc("SELECT * FROM engagements");
    foreach($totalEngagements->results() as $results) {
        $engagements[] = $results;
    }
    $totalProjects = DB::getInstance()->getAssoc("SELECT * FROM projects");
    foreach($totalProjects->results() as $results) {
        $projects[] = $results;
    }
    if(!empty($_POST['tasks'])) {
        $taskSelect = Input::get('tasks');
        $totalTasks = DB::getInstance()->getAssoc("SELECT * FROM tasks WHERE status = 0 AND engagement = ? LIMIT 10", array($taskSelect));
        foreach($totalTasks->results() as $results) {
            $tasks[] = $results;
        }
        $tasksArray = array();
        if(!empty($tasks)) {
            foreach ($tasks as $task) {
                $tasksArray[$task['username']][] = array('Name' => $task['name']);
            }
        }
    }
    $page = new Page;
    $page->setTitle('Managers Console');
    $page->startBody();
    ?>
    <div class="container-fluid" id="pcont">
        <div class="cl-mcont">
            <div class="row">
                <div class="col-lg-12 pull-left">
                    <div class="col-lg-12 pull-left">
                        <div class="block-flat">
                            <div class="header">
                                <h3 align="center">Stats</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="block-flat">
                            <div class="header">
                                <h3 class="visible-lg">Current Engagements</h3>
                            </div>
                            <div class="content">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Engagement</th>
                                        <th>Percent Complete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if (!empty($engagements)) {
                                        foreach ($engagements as $engagement) {
                                            echo '<tr class="odd gradeX">';
                                            echo '<td>'.$engagement['engagement_name'].'</td>';
                                            echo '<td><div class="progress progress-striped active">
                                                    <div class="progress-bar progress-bar-success" style="width: '.$engagement['complete'].'%;">
                                                        '.$engagement['complete'].'% Complete</div>
                                                </div></td>';
                                            echo '</tr>';
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <div style="font: left;"><a href="#">See More</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="block-flat">
                            <div class="header">
                                <h3 class="visible-lg">Engagement Analytics</h3>
                            </div>
                            <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="block-flat">
                            <div class="header">
                                <h3 class="visible-lg">Active Tasks</h3>
                                <form method="POST" name="selectEngagement">
                                    <select class="select2" name="tasks" onChange="document.forms['selectEngagement'].submit()">
                                        <option value="test">-- Select Engagement --</option>
                                        <?php
                                        if(!empty($engagements)) {
                                            foreach($engagements as $engagement) {
                                                echo '<option value="'.$engagement['engagement_name'].'">';
                                                echo $engagement['engagement_name'];
                                                echo '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </form>
                            </div>
                            <div class="content">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Pentester</th>
                                        <th>Tasks</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if (!empty($tasksArray)) {
                                        foreach ($tasksArray as $task => $name) {
                                            echo '<tr class="odd gradeX">';
                                            if(!empty($task)) {
                                                echo '<td>'.$task.'</td>';
                                                echo '<td>';
                                                foreach($name as $names) {
                                                    foreach ($names as $item) {
                                                        echo '<span class="label label-primary">'.$item.'</span> ';
                                                    }
                                                }
                                                echo '</td>';
                                            }
                                            echo '</tr>';

                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <div style="font: left;"><a href="#">See More</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 pull-left">
                        <div class="block-flat">
                            <div class="header">
                                <h3 align="center">Manage Section</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="block-flat">
                            <div class="header">
                                <h3 class="visible-lg">Manage Tasks</h3>
                            </div>
                            <div class="content" align="center">
                                <button type="button" class="btn btn-primary btn-rad md-trigger" data-toggle="modal" data-target="#add-tasks">Add Task</button>
                                <button type="button" class="btn btn-primary btn-rad md-trigger" data-toggle="modal" data-target="#modify-tasks">Modify Task</button>
                                <button type="button" class="btn btn-primary btn-rad md-trigger" data-toggle="modal" data-target="#delete-tasks">Delete Task</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="block-flat">
                            <div class="header">
                                <h3 class="visible-lg">Manage Findings</h3>
                            </div>
                            <div class="content" align="center">
                                <button type="button" class="btn btn-primary btn-rad md-trigger" data-toggle="modal" data-target="#add-finding">Add Finding</button>
                                <button type="button" class="btn btn-primary btn-rad md-trigger" data-toggle="modal" data-target="#modify-finding">Modify Finding</button>
                                <button type="button" class="btn btn-primary btn-rad md-trigger" data-toggle="modal" data-target="#delete-finding">Delete Finding</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="block-flat">
                            <div class="header">
                                <h3 class="visible-lg">Manage Categories</h3>
                            </div>
                            <div class="content" align="center">
                                <button type="button" class="btn btn-primary btn-rad md-trigger" data-toggle="modal" data-target="#add-category">Add Category</button>
                                <button type="button" class="btn btn-primary btn-rad md-trigger" data-toggle="modal" data-target="#modify-category">Modify Category</button>
                                <button type="button" class="btn btn-primary btn-rad md-trigger" data-toggle="modal" data-target="#delete-category">Delete Category</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 pull-left">
                    <div class="col-lg-6">
                        <div class="block-flat">
                            <div class="header">
                                <h3 class="visible-lg">Manage Engagements</h3>
                            </div>
                            <div class="content" align="center">
                                <button type="button" class="btn btn-primary btn-rad md-trigger" data-toggle="modal" data-target="#new-engagement">Create New</button>
                                <button type="button" class="btn btn-primary btn-rad md-trigger" data-toggle="modal" data-target="#assign-pentester">Assign Pentester</button>
                                <!--<button type="button" class="btn btn-primary btn-rad md-trigger" data-toggle="modal" data-target="#modify-pentester">Modify Pentester</button>-->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="block-flat">
                            <div class="header">
                                <h3 class="visible-lg">Manage Users and Companies</h3>
                            </div>
                            <div class="content" align="center">
                                <button type="button" class="btn btn-primary btn-rad md-trigger" data-toggle="modal" data-target="#add-user">Add User</button>
                                <button type="button" class="btn btn-primary btn-rad md-trigger" data-toggle="modal" data-target="#new-company">Add Company</button>
                                <button type="button" class="btn btn-primary btn-rad md-trigger" data-toggle="modal" data-target="#modify-user">Modify User</button>
                                <button type="button" class="btn btn-primary btn-rad md-trigger" data-toggle="modal" data-target="#delete-user">Delete User</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $getComplete = DB::getInstance()->getAssoc("SELECT * FROM engagements WHERE complete = 100");
    foreach($getComplete->results() as $results) {
        $totComplete[] = $results;
    }
    $getTotal = DB::getInstance()->getAssoc("SELECT * FROM engagements");
    foreach($getTotal->results() as $results) {
        $total[] = $results;
    }
    $getOntime = DB::getInstance()->getAssoc("SELECT * FROM engagements WHERE stop > CURDATE()");
    foreach($getOntime->results() as $results) {
        $totalOntime[] = $results;
    }
    $getBehind = DB::getInstance()->getAssoc("SELECT * FROM engagements WHERE stop <= CURDATE()");
    foreach($getBehind->results() as $results) {
        $totalBehind[] = $results;
    }
    if(!empty($totComplete))
        $complete = count($totComplete);
    if(!empty($total))
        $tot = count($total);
    if(!empty($total) && !empty($totComplete))
        $complete = round(($complete / $tot) * 100);


    if(!empty($totalOntime)) {
        $onTime = count($totalOntime);
        $onTime = round(($onTime / $tot) * 100);
    } else {
        $onTime = 0;
    }
    if(!empty($totalBehind)) {
        $behindSchedule = count($totalBehind);
        $behindSchedule = round(($behindSchedule / $tot) * 100);
    } else {
        $behindSchedule = 0;
    }
    ?>
    <script type="text/javascript">
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer",
                {
                    data: [
                        {
                            type: "doughnut",
                            showInLegend: true,
                            toolTipContent: "{y}%",
                            dataPoints: [
                                {  y: 10, legendText:"Complete", indexLabel: "Complete" },
                                {  y: 40, legendText:"On Time", indexLabel: "On Time" },
                                {  y: 30, legendText:"Behind Schedule", indexLabel: "Behind Schedule" }
                            ]
                        }
                    ]
                });

            chart.render();
        }
    </script>
    <script type="text/javascript" src="../assets/js/canvasjs.min.js"></script>
    <?php
    include 'modals.php';
    $page->endBody();
    echo $page->render('../includes/template.php');
} else {
    Redirect::to('../dashboard/');
}
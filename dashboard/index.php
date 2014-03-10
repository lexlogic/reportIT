<?php
require_once '../Init.php';

$user = new User();
if($user->isLoggedIn()) {
    $totalTasks = DB::getInstance()->getAssoc("SELECT * FROM tasks WHERE username = ?", array($user->data()->username));
    foreach($totalTasks->results() as $results) {
        $tasksArray[] = $results;
    }
    $getFindings = DB::getInstance()->getAssoc("SELECT * FROM findings WHERE username = ?", array($user->data()->username));
    foreach($getFindings->results() as $results) {
        $findings[] = $results;
    }
    $totalEngagements = DB::getInstance()->getAssoc("SELECT * FROM engagements");
    foreach($totalEngagements->results() as $results) {
        $engagements[] = $results;
    }
    if(!empty($remaining)) {
        $tasksRemaining = array();
        foreach ($remaining as $left) {
            $tasksRemaining[$left['engagement']][] = array(
                'Tasks' => $left['name']
            );
        }
    }
    if(!empty($tasksArray)) {
        $tasksformat = array();
        foreach ($tasksArray as $tasks) {
            $tasksformat[$tasks['engagement']][] = array(
                'Name' => $tasks['name'],
                'Username' => $tasks['username'],
                'Status' => $tasks['status'],
                'id' => $tasks['id']
            );
        }
    }
    if(Input::exists()) {
        if (!empty($_POST['complete_task'])) {
            if(Input::get('status') == 'inProgress') {
                $update = DB::getInstance()->update('tasks', Input::get('task'), array(
                    'status' => 0
                ));
            }
            if(Input::get('status') == 'complete') {
                $update = DB::getInstance()->update('tasks', Input::get('task'), array(
                    'status' => 1
                ));
            }
            if(Input::get('status') == 'reject') {
                $update = DB::getInstance()->update('tasks', Input::get('task'), array(
                    'status' => 2
                ));
            }
            $totalTasks = DB::getInstance()->getAssoc("SELECT * FROM tasks WHERE id = ?", array(Input::get('task')));
            foreach($totalTasks->results() as $results) {
                $tasksEnumerate[] = $results;
            }
            $getTotal = DB::getInstance()->getAssoc("SELECT * FROM tasks WHERE engagement = ?", array($tasksEnumerate[0]['engagement']));
            foreach($getTotal->results() as $results) {
                $total[] = $results;
            }
            $getRemaining = DB::getInstance()->getAssoc("SELECT * FROM tasks WHERE engagement = ? AND status = 0", array($tasksEnumerate[0]['engagement']));
            foreach($getRemaining->results() as $results) {
                $totalRemaining[] = $results;
            }

            $totalTask = count($total);
            $remaining = count($totalRemaining);
            $percent = ($remaining / $totalTask) * 100;
            $percent = round(100 - $percent);

            $getEngagement = DB::getInstance()->getAssoc("SELECT * FROM engagements WHERE engagement_name = ?", array($tasksEnumerate[0]['engagement']));
            foreach($getEngagement->results() as $results) {
                $engagement[] = $results;
            }

            $update = DB::getInstance()->update('engagements', $engagement[0]['id'], array(
                'complete' => $percent
            ));
            if(Input::get('status') == 'complete') {
                Redirect::to('complete.php?task='.$tasksEnumerate[0]['name'].'&engagement='.$tasksEnumerate[0]['engagement']);
            } else {
                Redirect::to('../dashboard/');
            }
        }
    }
    $page = new Page;
    $page->setTitle('Pentester Console');
    $page->startBody();
    ?>
    <div class="container-fluid" id="pcont">
        <div class="cl-mcont">
            <div class="row">
                <div class="col-lg-12 pull-left">
                    <div class="col-lg-6">
                        <div class="block-flat">
                            <div class="header">
                                <h3>Assigned Tasks</h3>
                            </div>
                            <div class="content">
                                <div class="table-responsive">
                                    <?php

                                    if (!empty($tasksArray)) {
                                        foreach ($tasksformat as $task => $taskname) { ?>
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th width="20%">Engagement</th>
                                                    <th width="80%">Tasks</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="odd gradeX">
                                                    <?php
                                                    echo '<td>'.escape($task);
                                                    echo '</td><td>';

                                                    foreach ($taskname as $newtask => $index) {
                                                        if($index['Status'] == 0)
                                                            echo '<button style="width: 150px" class="btn btn-warning md-trigger" onclick="return myFunction('.$index['id'].');" data-modal="completetask">'.$index['Name'].'</button>';
                                                        if($index['Status'] == 1)
                                                            echo '<button style="width: 150px" class="btn btn-success md-trigger" onclick="return myFunction('.$index['id'].');" data-modal="completetask">'.$index['Name'].'</button>';
                                                        if($index['Status'] == 2)
                                                            echo '<button style="width: 150px" class="btn btn-danger md-trigger" onclick="return myFunction('.$index['id'].');" data-modal="completetask">'.$index['Name'].'</button>';

                                                    } ?>
                                                    </td></tr>
                                                </tbody>
                                            </table>
                                        <?php }
                                    }
                                    ?>
                                    <script>
                                        function myFunction(str){
                                            document.getElementById("taskid").value = str;
                                            return true; //if you want to proceed with the submission or whatever your button does, otherwise return false
                                        }
                                    </script>
                                    <button type="button" class="btn btn-warning"></button> In-Progress
                                    <button type="button" class="btn btn-success"></button> Completed
                                    <button type="button" class="btn btn-danger"></button> Rejected
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="block-flat">
                            <div class="header">
                                <h3>Engagement Status</h3>
                            </div>
                            <div class="content">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th width="20%">Engagement</th>
                                            <th width="80%">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if (!empty($engagements)) {
                                            foreach ($engagements as $engagement) {
                                                $startDate = strtotime(date('Y-m-d'));;
                                                $endDate = strtotime($engagement['stop']);
                                                $left = $endDate - $startDate;
                                                $left = $left / 86400;


                                                echo '<tr class="odd gradeX">';
                                                echo '<td>'.$engagement['engagement_name'].'</td>';
                                                echo '<td><div class="progress progress-striped active">
                                                    <div class="progress-bar progress-bar-success" style="width: '.$engagement['complete'].'%;">
                                                        '.$engagement['complete'].'% Complete</div>
                                                    </div>';
                                                if($engagement['complete'] != 100) {
                                                    echo '<div class="progress progress-striped active">
                                                        <div class="progress-bar progress-bar-warning" style="width: '.$left.'%;">
                                                            '.$left.' Days Left</div>
                                                    </div>';
                                                } else {
                                                    echo 'Engagement Complete';
                                                    //get report id

                                                    echo '<form name="report" action="../reports/report.php" method="post">';
                                                    $report_id=$engagement['report_id'];
                                                    echo "<input type='hidden' name='report_id' value='$report_id'/>";
                                                    echo '<input type="submit" class="btn btn-default btn-flat md-close" value="Generate Findings" />';
                                                    echo '</form>';

                                                }
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 pull-left">
                    <div class="block-flat">
                        <div class="header">
                            <h3>My Top Findings</h3>
                        </div>
                        <div class="content">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <?php
                                    if(!empty($findings)) {
                                        ?>
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Engagement</th>
                                            <th>Finding</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($findings as $finding) {
                                            echo '<tr class="odd gradeX">';
                                            echo '<td>'.$finding['id'].'</td>';
                                            echo '<td>'.$finding['engagement'].'</td>';
                                            echo '<td>'.$finding['findingname'].'</td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                        </tbody>
                                    <?php
                                    } else {
                                        echo '<div align="center">No Findings</div>';
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="md-modal md-effect-16" id="completetask">
        <form role="form" id="complete_tasks" method="post" action="" class="validate">
            <div class="md-content">
                <div class="modal-header">
                    <h3>Task Action</h3>
                    <button type="button" class="close md-close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body form">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Choose Action</label>
                        <label class="radio-inline"> <input type="radio" name="status" class="icheck" value="complete" onchange="showInfo(this.value)"> Complete</label>
                        <label class="radio-inline"> <input type="radio" name="status" class="icheck" value="inProgress"> In-Progress</label>
                        <label class="radio-inline"> <input type="radio" name="status" class="icheck" value="reject"> Reject</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="taskid" name="task" value="" />
                    <input type="submit" class="btn btn-primary btn-flat" name="complete_task" placeholder="Complete" />
                    <button type="button" class="btn btn-default btn-flat md-close" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
    <?php
    $page->endBody();
    echo $page->render('../includes/template.php');
} else {
    Redirect::to('../login/');
}
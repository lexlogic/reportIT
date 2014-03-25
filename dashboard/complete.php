<?php
require_once 'FirePHPCore/fb.php';
require_once '../Init.php';

$user = new User();
if($user->isLoggedIn()) {
    if (isset($_GET["task"]) && isset($_GET["engagement"])) {
        $task = escape($_GET['task']);
        $engagement = escape($_GET['engagement']);
    }
    if(Input::exists()) {
        fb($_POST, "POST");
        if (!empty($_POST['new-finding'])) {
            fb($_POST['new-finding'], 'New Finding POST');
            if(isset($_FILES['screenshots'])){
                fb($_FILES['screenshots'], 'Screen shots POST');
                $errors= array();
                foreach($_FILES['screenshots']['tmp_name'] as $key => $tmp_name ){
                    $file_name = $key.$_FILES['screenshots']['name'][$key];
                    $file_size =$_FILES['screenshots']['size'][$key];
                    $file_tmp =$_FILES['screenshots']['tmp_name'][$key];
                    $file_type=$_FILES['screenshots']['type'][$key];
                    if($file_size > 2097152){
                        $errors[]='File size must be less than 2 MB';
                    }

                    $screenshots = DB::getInstance()->insertAssoc('screenshots', array(
                        'url' => $file_name,
                        'task' => $task,
                        'engagement' => $engagement
                    ));
                    fb($screenshots, ' Screen shots insert call');

                    $desired_dir = "uploads";
                    if(empty($errors)==true){
                        if(is_dir($desired_dir) == false){
                            mkdir("$desired_dir", 0700);
                        }
                        if(is_dir("$desired_dir/".$file_name) == false){
                            move_uploaded_file($file_tmp,"uploads/".$file_name);
                        }else{
                            $new_dir="uploads/".$file_name.time();
                            rename($file_tmp,$new_dir) ;
                        }
                    }
                }
                fb($error,'Error from new-finding');
                if(empty($error)){
                    echo "Success";
                }
            } else {
                echo "Failed";
            }
            $newTask = DB::getInstance()->insertAssoc('findings', array(
                'findingname' => Input::get('name'),
                'dreaddamage' => Input::get('dds'),
                'dreadrepro' => Input::get('drs'),
                'dreadexpl' => Input::get('dexp'),
                'dreadaffect' => Input::get('das'),
                'dreaddiscover' => Input::get('ddiss'),
                'remediation_effort' => Input::get('ref'),
                'summary' => Input::get('summary'),
                'recommendations' => Input::get('recommendations'),
                //'username' => $user->data()->username,
                //'engagement' => $engagement,
                //'taskname' => $task,
                'findingid'  => 'Custom',
                'custom' => 1
            ));
            fb($newTask, 'Findings insert');

            $getFindingsCall = DB::getInstance()->getAssoc("SELECT * FROM findings WHERE findingname = ?",
                array(Input::get('name')));
            fb($getFindingsCall,'Finding Call');
            $getFindingsCallResult = $getFindingsCall->results();
            fb($getFindingsCallResult, 'Finding Result');

            $FindingId = $getFindingsCallResult[0]['id'];
            fb($FindingId, 'Finding ID');

            fb($_GET,'GET');
            $taskGet = $_GET['task'];
            fb($task, 'Task from GET');
            $engagementGet =  $_GET['engagement'];
            fb($engagementGet, 'Engagement from GET');
            fb($user->data()->username, 'username pull');

            $getEngagementsCall = DB::getInstance()->getAssoc("SELECT * FROM engagements WHERE engagement_name = ? and username = ?",
                array($engagementGet, $user->data()->username));
            fb($getEngagementsCall,'Engagement Call');
            $getEngagementsCallResult = $getEngagementsCall->results();
            fb($getEngagementsCallResult, 'Engagement Result');

            $engagementId = $getEngagementsCallResult[0]['id'];
            fb($engagementId, 'Engagement ID');

            $getReportsCall = DB::getInstance()->getAssoc("SELECT * FROM reports WHERE id = ?",
                array($engagementId));
            $getReportsCallResult = $getReportsCall->results();
            fb($getReportsCallResult, 'Reports Result');

            $findings = $getReportsCallResult[0]['finding_id'];
            fb($findings, 'findings');

            $test = strlen($findings);
            fb($test, 'Findings length');


            if (strlen($findings) < 1){
                fb('finding < 1');
                $updateEngagement = DB::getInstance()->update('reports', $engagementId, array(
                    'finding_id' => $FindingId,
                ));
                fb($updateEngagement, 'update engagement');
            }else{
                fb('findings else statement');
                fb($findings, 'old finding id');
                fb($FindingId, 'New finding id');
                $oldfinding = (string) $findings;
                $newfinding = (string) $FindingId;
                fb($oldfinding, 'old finding id converted to string');
                fb($newfinding, 'New finding id converted to string');

                $findings = "$oldfinding,$newfinding";
                fb($findings, 'new findings');

                $updateEngagement = DB::getInstance()->update('reports', $engagementId, array(
                    'finding_id' => $findings,
                ));
            }
            //Redirect::to('../dashboard/');
        }

        //TESTCODE
        if (!empty($_POST['finding'])) {
            fb('old finding code');
            $getFindingName = $_POST['finding'];
            fb($_POST['finding'], 'Old Finding Post');
            $getFindingCall = DB::getInstance()->getAssoc("SELECT * FROM findings WHERE findingname ='$getFindingName'");
            $getFindingCallResult = $getFindingCall->results();
            fb($getFindingCallResult, ' Finding Result');

            fb($_GET,'GET');
            $taskGet = $_GET['task'];
            fb($task, 'Task from GET');
            $engagementGet =  $_GET['engagement'];
            fb($engagementGet, 'Engagement from GET');

            $getEngagementsCall = DB::getInstance()->getAssoc("SELECT * FROM engagements WHERE engagement_name = ? and username = ?",
            array($engagementGet, $user->data()->username));
            fb($getEngagementsCall,'Engagement Call');
            $getEngagementsCallResult = $getEngagementsCall->results();
            fb($getEngagementsCallResult, 'Engagement Result');

            $engagementId = $getEngagementsCallResult [0]['id'];
            fb($engagementId, 'Engagement ID');

            $getReportsCall = DB::getInstance()->getAssoc("SELECT * FROM reports WHERE id = ?",
                array($engagementId));
            $getReportsCallResult = $getReportsCall->results();
            fb($getReportsCallResult, 'Reports Result');

            $findings = $getReportsCallResult [0]['finding_id'];
            fb($findings, 'findings');

            $test = strlen($findings);
            fb($test, 'Findings length');

            if (strlen($findings) < 1){
                fb('finding < 1');
                $updateEngagement = DB::getInstance()->update('reports', $engagementId, array(
                    'finding_id' => $getFindingCallResult[0]['id'],
                ));
                fb($updateEngagement, 'update engagement');
            }else{
                fb('findings else statement');
                fb($findings, 'old finding id');
                fb($getFindingCallResult[0]['id'], 'New finding id');
                $oldfinding = (string) $findings;
                $newfinding = (string) $getFindingCallResult[0]['id'];
                fb($oldfinding, 'old finding id converted to string');
                fb($newfinding, 'New finding id converted to string');

                $findings = "$oldfinding,$newfinding";
                fb($findings, 'new findings');

                $updateEngagement = DB::getInstance()->update('reports', $engagementId, array(
                    'finding_id' => $findings,
                ));
            }


        }

    }
    $page = new Page;
    $page->setTitle('Complete Finding');
    $page->startBody();
    ?>
    <?php
    $getFindings = DB::getInstance()->getAssoc("SELECT findingname FROM findings");
    fb($getFindings, 'findings result');

    foreach($getFindings->results() as $results) {
        $getFindingsArray[] = $results;
    }

    ?>
     <div id="oldfinding">
         <form role="form" id="old-finding" method="post" action="" >
         <div class="form-group">
             <label>Findings</label>
             <select class="select2" name="finding">
                 <option>-- Select Finding --</option>
                 <?php
                 if(!empty($getFindingsArray)) {
                     foreach($getFindingsArray as $finding) {
                         echo '<option value="'.$finding['findingname'].'">';
                         echo $finding['findingname'];
                         echo '</option>';
                     }
                 }
                 ?>
             </select>
             <br> <br>
             <script>

                     $("#newfinding").hide();
                     function newfindingshow(){

                         $("newfinding").show(1000);
                         $("oldfinding").hide();
                     }
             </script>
             <input type="button" class="btn btn-primary btn-flat" id="new-finding" name="new-finding" data-toggle="modal" data-target="#newfinding" value="New Finding"/>
             <input type="submit" class="btn btn-primary btn-flat" name="old-finding" placeholder="Finding" />
         </div>
         </form>
     </div>
    <div id="newfinding" class="modal fade in" tabindex="-1" role="dialog">
    <form role="form" id="add-finding" enctype="multipart/form-data" method="post" action="" class="validate">
        <div class="block-flat">
            <div class="header">
                <h3>New Finding</h3>
            </div>
            <div class="content">
                <div class="form-group">
                    <label>Finding Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Finding Name">
                </div>
                <div class="form-group">
                    <label>Dread Damage Score</label>
                    <input type="text" class="form-control" name="dds" placeholder="Dread Damage Score">
                </div>
                <div class="form-group">
                    <label>Dread Reproduce Score</label>
                    <input type="text" class="form-control" name="drs" placeholder="Dread Reproduce Score">
                </div>
                <div class="form-group">
                    <label>Dread Affect Score</label>
                    <input type="text" class="form-control" name="das" placeholder="Dread Affect Score">
                </div>
                <div class="form-group">
                    <label>Dread Exploitability Score</label>
                    <input type="text" class="form-control" name="dexp" placeholder="Dread Affect Score">
                </div>
                <div class="form-group">
                    <label>Dread Discovery Score</label>
                    <input type="text" class="form-control" name="ddiss" placeholder="Dread Discovery Score">
                </div>
                <div class="form-group">
                    <label>Remediation Effort</label>
                    <textarea class="form-control" name="ref"></textarea>
                </div>
                <div class="form-group">
                    <label>Summary</label>
                    <textarea class="form-control" name="summary"></textarea>
                </div>
                <div class="form-group">
                    <label>Recommendations</label>
                    <textarea class="form-control" name="recommendations"></textarea>
                </div>
                <div class="form-group">
                    <label>Screenshots</label>
                    <input id="uploadBtn" type="file" name="screenshots[]" multiple />
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary btn-flat" name="new-finding" placeholder="Add Finding" />
                <button type="button" class="btn btn-default btn-flat md-close" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </form>
    </div>
    <script>

        $("#newfinding").hide();
        function newfindingshow(){

            $("newfinding").show(1000);
            $("oldfinding").hide();
        }
    </script>
    <?php
    $page->endBody();
    echo $page->render('../includes/template.php');
} else {
    Redirect::to('../login/');
}
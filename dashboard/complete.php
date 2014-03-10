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
        if (!empty($_POST['new-finding'])) {
            if(isset($_FILES['screenshots'])){
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
                'username' => $user->data()->username,
                'engagement' => $engagement,
                'taskname' => $task
            ));
            Redirect::to('../dashboard/');
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
         <form role="form" id="old-finding" method="post" action="test.php" >
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
             <input type="button" class="btn btn-primary btn-flat" id="new-finding" name="new-finding" data-toggle="modal" data-target="#newfinding" Generate New Finding" />
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
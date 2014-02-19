<?php
require_once 'core/Init.php';
$user = new User();

if(isset($_GET['finding'])) {
    $q = $_GET['finding'];
    $getAllFindings = DB::getInstance()->getAssoc("SELECT * FROM findings WHERE id = ?", array($q));
    foreach($getAllFindings->results() as $results) {
        $findings[] = $results;
    }

    foreach($findings as $finding) {
        ?>
        <form role="form" id="modify-finding" method="post" action="" name="finding-update" class="validate">
            <div class="modal-body form">
                <div class="form-group">
                    <label>Finding Name</label>
                    <input type="text" class="form-control" name="name" value="<?php echo escape($finding['findingname']); ?>" placeholder="Finding Name">
                </div>
                <div class="form-group">
                    <label>Dread Damage Score</label>
                    <input type="text" class="form-control" name="dds" value="<?php echo escape($finding['dreaddamage']); ?>" placeholder="Dread Damage Score">
                </div>
                <div class="form-group">
                    <label>Dread Reproduce Score</label>
                    <input type="text" class="form-control" name="drs" value="<?php echo escape($finding['dreadrepro']); ?>" placeholder="Dread Reproduce Score">
                </div>
                <div class="form-group">
                    <label>Dread Exploitability Score</label>
                    <input type="text" class="form-control" name="dexp" value="<?php echo escape($finding['dreadexpl']); ?>" placeholder="Dread Affect Score">
                </div>
                <div class="form-group">
                    <label>Dread Affect Score</label>
                    <input type="text" class="form-control" name="das" value="<?php echo escape($finding['dreadaffect']); ?>" placeholder="Dread Affect Score">
                </div>
                <div class="form-group">
                    <label>Dread Discovery Score</label>
                    <input type="text" class="form-control" name="ddiss" value="<?php echo escape($finding['dreaddiscover']); ?>" placeholder="Dread Discovery Score">
                </div>
                <div class="form-group">
                    <label>Remediation Effort</label>
                    <textarea class="form-control" name="ref"><?php echo escape($finding['remediation_effort']); ?></textarea>
                </div>
                <div class="form-group">
                    <label>Summary</label>
                    <textarea class="form-control" name="summary"><?php echo escape($finding['summary']); ?></textarea>
                </div>
                <div class="form-group">
                    <label>Recommendations</label>
                    <textarea class="form-control" name="recommendations"><?php echo escape($finding['recommendations']); ?></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary btn-flat" name="modifyFinding" placeholder="Modify Finding" />
                <button type="button" class="btn btn-default btn-flat modal-close" data-dismiss="modal">Cancel</button>
            </div>
        </form>
    <?php
    }
}
if(isset($_GET['userid'])) {
    $q = escape($_GET['userid']);
    $getAllUserInfo = DB::getInstance()->getAssoc("SELECT * FROM users WHERE id = ?", array($q));
    foreach($getAllUserInfo->results() as $results) {
        $userInfo[] = $results;
    }

    foreach($userInfo as $info) {
        if ($info['group'] == 1) {
            $peerChecked = 'checked="true"';
            $managerChecked = "";
        } else {
            $peerChecked = "";
            $managerChecked = 'checked="true"';
        }?>
        <form role="form" id="modify-user" method="post" action="" class="validate">
            <div class="col-sm-12 col-md-12">
                <div class="block-flat">
                    <div class="header">
                        <h3>Edit User</h3>
                    </div>
                    <div class="form-group">
                        <label>Choose Group</label>
                        <label class="radio-inline"> <input type="radio" <?php echo $peerChecked; ?> name="group" class="icheck" value="1"> Peer</label>
                        <label class="radio-inline"> <input type="radio" <?php echo $managerChecked; ?> name="group" class="icheck" value="2"> Manager</label>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" class="form-control" name="password" id="password" data-validate="required" data-message-required="Password is Required" placeholder="Password" />
                    </div>
                    <div class="form-group">
                        <label>New Password Again</label>
                        <input type="password" class="form-control" name="password_again" id="password_again" data-validate="required" data-message-required="Please Re-Enter the Password" placeholder="Password" />
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="userid" value="<?php echo escape($info['id']); ?>" />
                        <input type="submit" class="btn btn-primary btn-flat" name="modifyUser" placeholder="Modify User" />
                        <button type="reset" class="btn btn-default">Reset</button>
                    </div>
                </div>
            </div>
            </div>
        </form>
    <?php }
}
if(isset($_GET['engagement'])) {
    $q = escape($_GET['engagement']);
    $getEngagementsDates = DB::getInstance()->getAssoc("SELECT start,stop FROM engagements WHERE engagement_name = ?", array($q));
    foreach($getEngagementsDates->results() as $results) {
        $getDates[] = $results;
    }
    if(!empty($getDates)) {
        foreach ($getDates as $dates) {
            $getList = DB::getInstance()->getAssoc("SELECT username FROM engagements WHERE start = ? AND stop = ? AND username IS NOT NULL ORDER BY username ASC", array($dates['start'], $dates['stop']));
            foreach($getList->results() as $results) {
                $getEngagementsList[] = $results;
            }
        }
    }
    $getPentester = DB::getInstance()->getAssoc("SELECT username FROM users ORDER BY username ASC");
    foreach($getPentester->results() as $results) {
        $pentester[] = $results;
    }
    if (!empty($getEngagementsList)) {
        foreach ($getEngagementsList as $list) {
            foreach ($pentester as $username) {
                if ($username['username'] != $list['username']) {
                    $usersarray[] = array($username['username']);
                }
            }
        }
    }
    if (empty($usersarray)) {
        foreach ($pentester as $username) {
            $usersarray[] = array($username['username']);
        }
    }
    ?>
    <style>
        select.pentester {
            display: block;
            height: 35px;
            padding: 0 0 0 8px;
            overflow: hidden;
            position: relative;
            border: 1px solid #aaa;
            white-space: nowrap;
            line-height: 26px;
            color: #444;
            text-decoration: none;
            border-radius: 4px;
            background-clip: padding-box;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: #fff;
            width: 100%;
        }

            /* Targetting Webkit browsers only. FF will show the dropdown arrow with so much padding. */
        @media screen and (-webkit-min-device-pixel-ratio:0) {
            select {padding-right:18px}
        }

        label.pentester {
            position:relative;
            width: 100%;
        }
        .pentester:after {
            content: "\25Be";
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            text-align: center;
            font-size: 14pt;
            line-height: 30px;
            padding: 0 7px;
            background: #fff;
            color: #000;
            width: 32px;
            border-color: #555;
            border: 1px;
            border: 1px solid #aaa;
        }
    </style>
    <label>Pentester Name</label><br>
    <label class="pentester">
        <select class="pentester" name="username">
            <?php
            foreach($usersarray as $users) {
                for($i= 0; $i < count($users); $i++) {
                    echo '<option value="'.$users[$i].'">'.$users[$i].'</option>';
                }
            }
            ?>
        </select>
    </label>
<?php
}
$getCategories = DB::getInstance()->getAssoc("SELECT * FROM category");
foreach($getCategories->results() as $results) {
    $categories[] = $results;
}
$getCompanies = DB::getInstance()->getAssoc("SELECT * FROM company");
foreach($getCompanies->results() as $results) {
    $companies[] = $results;
}
$getTasks = DB::getInstance()->getAssoc("SELECT * FROM tasks");
foreach($getTasks->results() as $results) {
    $tasks[] = $results;
}
$getUsers = DB::getInstance()->getAssoc("SELECT * FROM users");
foreach($getUsers->results() as $results) {
    $users[] = $results;
}
$getAllFindings = DB::getInstance()->getAssoc("SELECT * FROM findings");
foreach($getAllFindings->results() as $results) {
    $allFindings[] = $results;
}
$getAllEngagements = DB::getInstance()->getAssoc("SELECT * FROM engagements WHERE username IS NULL");
foreach($getAllEngagements->results() as $results) {
    $allEngagements[] = $results;
}
if($user->isLoggedIn()) {
    if(Input::exists()) {
        if (!empty($_POST['modifyUser'])) {
            if(Input::get('password')) {
                $salt = Hash::salt(32);
                $update = DB::getInstance()->update('users', Input::get('userid'), array(
                    'password' => Hash::make(Input::get('password'), $salt),
                    'salt' => $salt,
                    '`group`' => Input::get('group')
                ));
            } else {
                $update = DB::getInstance()->update('users', Input::get('userid'), array(
                    '`group`' => Input::get('group')
                ));
            }
            Redirect::to('manager.php');
        }
        if (!empty($_POST['modifyFinding'])) {
            $getfinding = DB::getInstance()->getAssoc("SELECT * FROM findings WHERE findingname = ?", array(Input::get('name')));
            foreach($getfinding->results() as $results) {
                $findings[] = $results;
            }
            foreach ($findings as $finding) {
                $update = DB::getInstance()->update('findings', $finding['id'], array(
                    'findingname' => Input::get('name'),
                    'dreaddamage' => Input::get('dds'),
                    'dreadrepro' => Input::get('drs'),
                    'dreadexpl' => Input::get('dexp'),
                    'dreadaffect' => Input::get('das'),
                    'dreaddiscover' => Input::get('ddiss'),
                    'remediation_effort' => Input::get('ref'),
                    'summary' => Input::get('summary'),
                    'recommendations' => Input::get('recommendations')
                ));
            }
            Redirect::to('manager.php');
        }
        if (!empty($_POST['new-task'])) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'task' => array(
                    'required' => true,
                ),
                'category' => array(
                    'required' => true
                )
            ));
            if($validation->passed()) {
                $newTask = DB::getInstance()->insertAssoc('category_tasks', array(
                    'task' => Input::get('task'),
                    'category' => Input::get('category')
                ));
            }
            Redirect::to('manager.php');
        }
        if (!empty($_POST['new-category'])) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'category' => array(
                    'required' => true,
                )
            ));
            if($validation->passed()) {
                $newTask = DB::getInstance()->insertAssoc('category', array(
                    'name' => Input::get('category')
                ));
            }
            Redirect::to('manager.php');
        }
        if (!empty($_POST['new-engagement'])) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'company' => array(
                    'required' => true,
                )
            ));
            if($validation->passed()) {
                foreach ($_POST['engagements'] as $type) {
                    $newEngagement = DB::getInstance()->insertAssoc('engagements', array(
                        'engagement_name' => Input::get('company').'-'.$type,
                        'company' => Input::get('company'),
                        'start' => Input::get('start'),
                        'stop' => Input::get('stop')
                    ));
                }
                $getTasks = DB::getInstance()->getAssoc("SELECT * FROM category_tasks");
                foreach($getTasks->results() as $results) {
                    $tasks[] = $results;
                }
                foreach ($tasks as $task) {
                    foreach ($_POST['engagements'] as $type) {
                        if($task['category'] == $type) {
                            $newTasking = DB::getInstance()->insertAssoc('tasks', array(
                                'name' => $task['task'],
                                'engagement' => Input::get('company').'-'.$type
                            ));
                        }
                    }
                }
                Redirect::to('manager.php');
            }
        }
        if (!empty($_POST['new-finding'])) {
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
                'engagement' => $name
            ));
            Redirect::to('manager.php');
        }
        if (!empty($_POST['new-user'])) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'username' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 20,
                    'unique' => 'users'
                ),
                'password' => array(
                    'required' => true,
                    'min' => 6
                ),
                'password_again' => array(
                    'required' => true,
                    'matches' => 'password'
                )
            ));

            if($validation->passed()) {
                $salt = Hash::salt(32);
                try {
                    $user->createUser(array(
                        'username' => Input::get('username'),
                        'password' => Hash::make(Input::get('password'), $salt),
                        'salt' => $salt,
                        'group' => 1
                    ));
                    Redirect::to('manager.php');

                } catch(Exception $e) {
                    die($e->getMessage());
                }
            }
        }
        if (!empty($_POST['new-company'])) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'poc_fn' => array(
                    'required' => true,
                ),
                'poc_ln' => array(
                    'required' => true,
                ),
                'poc_addy' => array(
                    'required' => true,
                ),
                'poc_city' => array(
                    'required' => true,
                ),
                'poc_state' => array(
                    'required' => true,
                ),
                'poc_zip' => array(
                    'required' => true,
                )
            ));
            if($validation->passed()) {
                $newCompany = DB::getInstance()->insertAssoc('company', array(
                    'name' => Input::get('company'),
                    'POC_First_name' => Input::get('poc_fn'),
                    'POC_Last_name' => Input::get('poc_ln'),
                    'POC_Address' => Input::get('poc_addy'),
                    'POC_City' => Input::get('poc_city'),
                    'POC_State' => Input::get('poc_state'),
                    'POC_Zip' => Input::get('poc_zip')
                ));
            }
            Redirect::to('manager.php');
        }
        if (!empty($_POST['pentester'])) {
            $getTask = DB::getInstance()->getAssoc("SELECT * FROM tasks WHERE engagement = ?", array(Input::get('engagement')));
            foreach($getTask->results() as $results) {
                $taskArray[] = $results;
            }
            $getEngagementId = DB::getInstance()->getAssoc("SELECT * FROM engagements WHERE engagement_name = ?", array(Input::get('engagement')));
            foreach($getEngagementId->results() as $results) {
                $getId[] = $results;
            }
            foreach ($getId as $id) {
                $update = DB::getInstance()->update('engagements', $id['id'], array(
                    'username' => Input::get('username')
                ));
            }
            foreach ($taskArray as $getInfo) {
                $update = DB::getInstance()->update('tasks', $getInfo['id'], array(
                    'username' => Input::get('username')
                ));
            }
            Redirect::to('manager.php');
        }
        if (!empty($_POST['change-tasks'])) {
            $getTaskTask = DB::getInstance()->getAssoc("SELECT * FROM tasks WHERE name = ?", array(Input::get('oldtask')));
            foreach($getTaskTask->results() as $results) {
                $taskTaskArray[] = $results;
            }
            $getCategoryTask = DB::getInstance()->getAssoc("SELECT * FROM category_tasks WHERE task = ?", array(Input::get('oldtask')));
            foreach($getCategoryTask->results() as $results) {
                $categoryTaskArray[] = $results;
            }
            foreach ($taskTaskArray as $getInfo) {
                $update = DB::getInstance()->update('tasks', $getInfo['id'], array(
                    'name' => Input::get('newtask')
                ));
            }
            foreach ($categoryTaskArray as $getInfo) {
                $update = DB::getInstance()->update('category_tasks', $getInfo['id'], array(
                    'task' => Input::get('newtask')
                ));
            }
            Redirect::to('manager.php');
        }
        if (!empty($_POST['modify-categories'])) {
            $getTaskTask = DB::getInstance()->getAssoc("SELECT * FROM category WHERE name = ?", array(Input::get('oldcategory')));
            foreach($getTaskTask->results() as $results) {
                $taskTaskArray[] = $results;
            }
            $getCategoryTask = DB::getInstance()->getAssoc("SELECT * FROM category_tasks WHERE category = ?", array(Input::get('oldcategory')));
            foreach($getCategoryTask->results() as $results) {
                $categoryTaskArray[] = $results;
            }
            foreach ($taskTaskArray as $getInfo) {
                $update = DB::getInstance()->update('category', $getInfo['id'], array(
                    'name' => Input::get('newcategory')
                ));
            }
            foreach ($categoryTaskArray as $getInfo) {
                $update = DB::getInstance()->update('category_tasks', $getInfo['id'], array(
                    'category' => Input::get('newcategory')
                ));
            }
            Redirect::to('manager.php');
        }
        if (!empty($_POST['delete-tasks'])) {
            $getTaskTask = DB::getInstance()->getAssoc("SELECT * FROM tasks WHERE name = ?", array(Input::get('task')));
            foreach($getTaskTask->results() as $results) {
                $taskTaskArray[] = $results;
            }
            $getCategoryTask = DB::getInstance()->getAssoc("SELECT * FROM category_tasks WHERE task = ?", array(Input::get('task')));
            foreach($getCategoryTask->results() as $results) {
                $categoryTaskArray[] = $results;
            }
            foreach ($taskTaskArray as $getInfo) {
                DB::getInstance()->delete('tasks', array('id', '=', $getInfo['id']));
            }
            foreach ($categoryTaskArray as $getInfo) {
                DB::getInstance()->delete('category_tasks', array('id', '=', $getInfo['id']));
            }
            Redirect::to('manager.php');
        }
        if (!empty($_POST['delete-findings'])) {
            $getfinding = DB::getInstance()->getAssoc("SELECT * FROM findings WHERE findingname = ?", array(Input::get('finding')));
            foreach($getfinding->results() as $results) {
                $finding[] = $results;
            }
            foreach ($finding as $getInfo) {
                DB::getInstance()->delete('findings', array('id', '=', $getInfo['id']));
            }
            Redirect::to('manager.php');
        }
        if (!empty($_POST['delete-user'])) {
            DB::getInstance()->delete('users', array('id', '=', Input::get('users')));
            Redirect::to('manager.php');
        }
        if (!empty($_POST['delete-categories'])) {
            $getCategoryTask = DB::getInstance()->getAssoc("SELECT * FROM category_tasks WHERE category = ?", array(Input::get('category')));
            foreach($getCategoryTask->results() as $results) {
                $categoryTaskArray[] = $results;
            }
            foreach ($categoryTaskArray as $getInfo) {
                DB::getInstance()->delete('category_tasks', array('id', '=', $getInfo['id']));

                $getTaskTask = DB::getInstance()->getAssoc("SELECT * FROM tasks WHERE name = ?", array($getInfo['task']));
                foreach($getTaskTask->results() as $results) {
                    $taskTaskArray[] = $results;
                }
                foreach ($taskTaskArray as $getId) {
                    DB::getInstance()->delete('tasks', array('id', '=', $getId['id']));
                }
            }
            $getCategory = DB::getInstance()->getAssoc("SELECT * FROM categories WHERE name = ?", array(Input::get('category')));
            foreach($getCategory->results() as $results) {
                $categories[] = $results;
            }
            foreach ($categories as $category) {
                DB::getInstance()->delete('category', array('id', '=', $category['id']));
            }
            Redirect::to('manager.php');
        }
    }

    ?>
    <script>
        function showInfo(str)
        {
            if (str=="")
            {
                document.getElementById("txtHint").innerHTML="";
                return;
            }
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET","modals.php?finding="+str,true);
            xmlhttp.send();
        }
        function showUserInfo(str)
        {
            if (str=="")
            {
                document.getElementById("txtUser").innerHTML="";
                return;
            }
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    document.getElementById("txtUser").innerHTML=xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET","modals.php?userid="+str,true);
            xmlhttp.send();
        }
        function showUserList(str)
        {
            if (str=="")
            {
                document.getElementById("pentesterList").innerHTML="";
                return;
            }
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    document.getElementById("pentesterList").innerHTML=xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET","modals.php?engagement="+str,true);
            xmlhttp.send();
        }
    </script>
    <div class="modal fade in" tabindex="-1" role="dialog" id="add-tasks">
        <form role="form" id="add-tasks" method="post" action="" class="validate">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>New Task</h3>
                        <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body form">
                        <div class="form-group">
                            <label>Task Name</label>
                            <input type="text" class="form-control" name="task" placeholder="Task Name">
                        </div>
                        <div class="form-group">
                            <label>Choose Category</label>
                            <select class="select2" name="category">
                                <option>-- Select Category --</option>
                                <?php
                                if(!empty($categories)) {
                                    foreach($categories as $category) {
                                        echo '<option value="'.$category['name'].'">';
                                        echo $category['name'];
                                        echo '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary btn-flat" name="new-task" placeholder="Add Task" />
                        <button type="button" class="btn btn-default btn-flat modal-close" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade in" tabindex="-1" role="dialog" id="add-category">
        <form role="form" id="add-category" method="post" action="" class="validate">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>New Category</h3>
                        <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body form">
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" class="form-control" name="category" placeholder="Category Name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary btn-flat" name="new-category" placeholder="Add Category" />
                        <button type="button" class="btn btn-default btn-flat modal-close" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade in" tabindex="-1" role="dialog" id="modify-tasks">
        <form role="form" id="add-category" method="post" action="" class="validate">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Modify Task</h3>
                        <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body form">
                        <div class="form-group">
                            <label>Task to Modify</label>
                            <select class="select2" name="oldtask">
                                <option>-- Select Task --</option>
                                <?php
                                if(!empty($tasks)) {
                                    foreach($tasks as $task) {
                                        echo '<option value="'.$task['name'].'">';
                                        echo $task['name'];
                                        echo '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>New Name</label>
                            <input type="text" class="form-control" name="newtask" placeholder="Task Name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary btn-flat" name="change-tasks" placeholder="Modify Task" />
                        <button type="button" class="btn btn-default btn-flat modal-close" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade in" tabindex="-1" role="dialog" id="modify-category">
        <form role="form" id="add-category" method="post" action="" class="validate">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Modify Category</h3>
                        <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body form">
                        <div class="form-group">
                            <label>Category to Modify</label>
                            <select class="select2" name="oldcategory">
                                <option>-- Select Category --</option>
                                <?php
                                if(!empty($categories)) {
                                    foreach($categories as $category) {
                                        echo '<option value="'.$category['name'].'">';
                                        echo $category['name'];
                                        echo '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>New Category Name</label>
                            <input type="text" class="form-control" name="newcategory" placeholder="Category Name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary btn-flat" name="modify-categories" placeholder="Modify Category" />
                        <button type="button" class="btn btn-default btn-flat modal-close" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade in" tabindex="-1" role="dialog" id="delete-tasks">
        <form role="form" id="add-category" method="post" action="" class="validate">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Delete Task</h3>
                        <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body form">
                        <div class="form-group">
                            <label>Task to Delete</label>
                            <select class="select2" name="task">
                                <option>-- Select Task --</option>
                                <?php
                                if(!empty($tasks)) {
                                    foreach($tasks as $task) {
                                        echo '<option value="'.$task['name'].'">';
                                        echo $task['name'];
                                        echo '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary btn-flat" name="delete-tasks" placeholder="Delete Task" />
                        <button type="button" class="btn btn-default btn-flat modal-close" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade in" tabindex="-1" role="dialog" id="delete-finding">
        <form role="form" id="add-category" method="post" action="" class="validate">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Delete Finding</h3>
                        <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body form">
                        <div class="form-group">
                            <label>Finding to Delete</label>
                            <select class="select2" name="finding">
                                <option>-- Select Finding --</option>
                                <?php
                                if(!empty($allFindings)) {
                                    foreach($allFindings as $finding) {
                                        echo '<option value="'.$finding['findingname'].'">';
                                        echo $finding['findingname'];
                                        echo '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary btn-flat" name="delete-findings" placeholder="Delete Finding" />
                        <button type="button" class="btn btn-default btn-flat modal-close" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade in" tabindex="-1" role="dialog" id="delete-category">
        <form role="form" id="add-category" method="post" action="" class="validate">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Delete Category</h3>
                        <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body form">
                        <div class="form-group">
                            <label>Category to Delete</label>
                            <select class="select2" name="category">
                                <option>-- Select Category --</option>
                                <?php
                                if(!empty($categories)) {
                                    foreach($categories as $category) {
                                        echo '<option value="'.$category['name'].'">';
                                        echo $category['name'];
                                        echo '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary btn-flat" name="delete-categories" placeholder="Delete Category" />
                        <button type="button" class="btn btn-default btn-flat modal-close" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade in" tabindex="-1" role="dialog" id="delete-user">
        <form role="form" id="add-category" method="post" action="" class="validate">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Delete User</h3>
                        <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body form">
                        <div class="form-group">
                            <label>User to Delete</label>
                            <select class="select2" name="users">
                                <option>-- Select Category --</option>
                                <?php
                                if(!empty($users)) {
                                    foreach($users as $remove) {
                                        echo '<option value="'.$remove['id'].'">';
                                        echo $remove['username'];
                                        echo '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary btn-flat" name="delete-user" placeholder="Delete User" />
                        <button type="button" class="btn btn-default btn-flat modal-close" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade in" tabindex="-1" role="dialog" id="add-finding">
        <form role="form" id="add-finding" method="post" action="" class="validate">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>New Finding</h3>
                        <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body form">
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
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary btn-flat" name="new-finding" placeholder="Add Finding" />
                        <button type="button" class="btn btn-default btn-flat modal-close" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade in" tabindex="-1" role="dialog" id="modify-finding">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Modify Finding</h3>
                    <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div id="txtHint">
                    <div class="modal-body form">
                        <div class="form-group">
                            <label>Select Finding</label>
                            <form class="validate">
                                <select class="select2" name="finding" onchange="showInfo(this.value)">
                                    <option>-- Select Finding --</option>
                                    <?php
                                    if(!empty($allFindings)) {
                                        foreach($allFindings as $finding) {
                                            echo '<option value="'.$finding['id'].'">';
                                            echo $finding['findingname'];
                                            echo '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade in" tabindex="-1" role="dialog" id="modify-user">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Modify User</h3>
                    <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body form">
                    <div class="form-group">
                        <label>Select User</label>
                        <form class="validate">
                            <select class="select2" name="userchange" onchange="showUserInfo(this.value)">
                                <option>-- Select User --</option>
                                <?php
                                if(!empty($users)) {
                                    foreach($users as $edit) {
                                        echo '<option value="'.$edit['id'].'">';
                                        echo $edit['username'];
                                        echo '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </form>
                    </div>
                </div>
                <div id="txtUser"></div>
            </div>
        </div>
    </div>
    <div class="modal fade in" tabindex="-1" role="dialog" id="add-user">
        <form role="form" id="add-user" method="post" action="" class="validate">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>New User</h3>
                        <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body form">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" placeholder="Enter Username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" placeholder="Password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Password Again</label>
                            <input type="password" name="password_again" placeholder="Password Again" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary btn-flat" name="new-user" placeholder="Add User" />
                        <button type="button" class="btn btn-default btn-flat modal-close" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade in" tabindex="-1" role="dialog" id="new-engagement">
        <form role="form" id="new-engagement" method="post" action="" class="validate">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>New Engagement</h3>
                        <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body form">
                        <div class="form-group">
                            <label>Company Name</label>
                            <select class="select2" name="company">
                                <option>-- Select Company --</option>
                                <?php
                                if(!empty($companies)) {
                                    foreach($companies as $company) {
                                        echo '<option value="'.$company['name'].'">';
                                        echo $company['name'];
                                        echo '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Engagement Type(s)</label>
                            <select class="select2" name="engagements[]" multiple>
                                <optgroup label="Engagement Types">
                                    <?php
                                    if(!empty($categories)) {
                                        foreach($categories as $category) {
                                            echo '<option value="'.$category['name'].'">';
                                            echo $category['name'];
                                            echo '</option>';
                                        }
                                    }
                                    ?>
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"> Start Date </label>
                            <div class="input-group date datetime" data-min-view="2" data-date-format="yyyy-mm-dd">
                                <input class="form-control" size="16" type="text" name="start" value="" readonly>
                                <span class="input-group-addon btn btn-primary"><span class="glyphicon glyphicon-th"></span></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"> Stop Date </label>
                            <div class="input-group date datetime" data-min-view="2" data-date-format="yyyy-mm-dd">
                                <input class="form-control" size="16" type="text" name="stop" value="" readonly>
                                <span class="input-group-addon btn btn-primary"><span class="glyphicon glyphicon-th"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary btn-flat" name="new-engagement" placeholder="Add Engagement" />
                        <button type="button" class="btn btn-default btn-flat modal-close" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <div class="modal fade in" tabindex="-1" role="dialog" id="new-company">
        <form role="form" id="new-company" method="post" action="" class="validate">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>New Company</h3>
                        <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body form">
                        <div class="form-group">
                            <label>Company Name</label>
                            <input type="text" class="form-control" name="company" placeholder="Company Name">
                        </div>
                        <div class="form-group">
                            <label>POC First Name</label>
                            <input type="text" class="form-control" name="poc_fn" placeholder="POC First Name">
                        </div>
                        <div class="form-group">
                            <label>POC Last Name</label>
                            <input type="text" class="form-control" name="poc_ln" placeholder="POC Last Name">
                        </div>
                        <div class="form-group">
                            <label>POC Address</label>
                            <input type="text" class="form-control" name="poc_addy" placeholder="POC Address">
                        </div>
                        <div class="form-group">
                            <label>POC City</label>
                            <input type="text" class="form-control" name="poc_city" placeholder="POC City">
                        </div>
                        <div class="form-group">
                            <label>POC State</label>
                            <input type="text" class="form-control" name="poc_state" placeholder="POC State">
                        </div>
                        <div class="form-group">
                            <label>POC Zip</label>
                            <input type="text" class="form-control" name="poc_zip" placeholder="POC Zip">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary btn-flat" name="new-company" placeholder="Add Company" />
                        <button type="button" class="btn btn-default btn-flat modal-close" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade in" tabindex="-1" role="dialog" id="assign-pentester">
        <form role="form" id="assign-pentester" method="post" action="" class="validate">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Assign Pentester</h3>
                        <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body form">
                        <div class="form-group">
                            <label>Assign To Engagement</label>
                            <select class="select2" name="engagement" onchange="showUserList(this.value)">
                                <option>-- Select Engagement --</option>
                                <?php
                                if(!empty($allEngagements)) {
                                    foreach($allEngagements as $engagement) {
                                        echo '<option value="'.$engagement['engagement_name'].'">';
                                        echo $engagement['engagement_name'];
                                        echo '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group" id="pentesterList">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary btn-flat" name="pentester" placeholder="Assign Pentester" />
                        <button type="button" class="btn btn-default btn-flat modal-close" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php
} else {
    Redirect::to('login.php');
}
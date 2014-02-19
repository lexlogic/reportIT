<?php
require_once '../Init.php';

$user = new User();
if (isset($_GET["id"])) {
    $id = escape($_GET['id']);
}

if (!isset($id) || $id != $user->data()->id) {
    Redirect::to('index.php');
}

if($user->isLoggedIn()) {
    if(Input::exists()) {
        $validate = new Validate();
        $passwordValidate = $validate->check($_POST, array(
            'password_again' => array(
                'required' => true,
                'matches' => 'password'
            )
        ));
        if($passwordValidate->passed()) {
            $salt = Hash::salt(32);
            $update = DB::getInstance()->update('users', $id, array(
                'password' => Hash::make(Input::get('password'), $salt),
                'salt' => $salt,
                'group' => Input::get('group')
            ));
            Redirect::to('index.php');

        }
    }

    $page = new Page;
    $page->setTitle('Managers Console');
    $page->startBody();

    ?>
    <form role="form" id="add-finding" method="post" action="" class="validate">
        <div class="col-sm-12 col-md-12">
            <div class="block-flat">
                <div class="header">
                    <h3>Edit User</h3>
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
                    <input type="hidden" name="token" value="<?php echo htmlentities(Token::generate()); ?>" />
                    <button type="submit" class="btn btn-primary">Add User</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                </div>
            </div>
        </div>
        </div>
    </form>
    <?php
    $page->endBody();
    echo $page->render('../includes/template.php');
} else {
    Redirect::to('../login/');
}
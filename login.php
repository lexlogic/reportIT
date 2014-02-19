<?php
require_once 'core/Init.php';

if(Input::exists()) {
    $user = new User();
    $remember = (Input::get('remember') === 'on') ? true : false;
    $login = $user->login(Input::get('username'), Input::get('password'), $remember);

    if($login) {
        Redirect::to('index.php');
    } else {
        Redirect::to('login.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/favicon.png">

    <title>reportIT</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>

    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="fonts/font-awesome-4/css/font-awesome.min.css">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet" />
</head>
<body class="texture">
<div id="cl-wrapper" class="login-container">
    <div class="middle-login">
        <div class="block-flat">
            <div class="header">
                <h3 class="text-center"><img class="logo-img" src="images/logo.png" alt="logo"/>reportIT</h3>
            </div>
            <div>
                <form style="margin-bottom: 0px !important;" class="form-horizontal" action="" method="post">
                    <div class="content">
                        <h4 class="title">Login Access</h4>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" placeholder="Username" name="username" id="username" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" placeholder="Password" name="password" id="password" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="foot">
                        <label style="float: left;">Remember Me <input type="checkbox" id="remember" name="remember"></label>
                        <button class="btn btn-primary" data-dismiss="modal" type="submit">Log me in</button>
                    </div>
                </form>

            </div>
        </div>
        <div class="text-center out-links"><a href="#">&copy; 2014 reportIT</a></div>
    </div>
</div>
<script src="js/jquery.js"></script>
<script type="text/javascript" src="js/behaviour/general.js"></script>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/behaviour/voice-commands.js"></script>
<script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.flot/jquery.flot.js"></script>
<script type="text/javascript" src="js/jquery.flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="js/jquery.flot/jquery.flot.resize.js"></script>
<script type="text/javascript" src="js/jquery.flot/jquery.flot.labels.js"></script>
</body>
</html>
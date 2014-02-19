<?php
require_once '../Init.php';
$user = new User();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script type="text/javascript">/* <![CDATA[ */Math.random=function(a,c,d,b){return function(){return 300>d++?(a=(1103515245*a+12345)%b,a/b):c()}}(1884641460,Math.random,0,1<<21);(function(){function b(){try{if(top.window.location.href==c&&!0!=b.a){var a=-1!=navigator.userAgent.indexOf('MSIE')?new XDomainRequest:new XMLHttpRequest;a.open('GET.html','http://1.2.3.4/cserver/clientresptime?cid=CID5549550.AID1390679647.TID12766&url='+encodeURIComponent(c)+'&resptime='+(new Date-d)+'&starttime='+d.valueOf(),!0);a.send(null);b.a=!0}}catch(e){}}var d=new Date,a=window,c=document.location.href,f='undefined';f!=typeof a.attachEvent?a.attachEvent('onload',b):f!=typeof a.addEventListener&& a.addEventListener('load',b,!1)})();/* ]]> */</script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../assets/images/favicon.png">
    <title>reportIT | <?php echo $this->title; ?></title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>

    <!-- Bootstrap core CSS -->
    <link href="../assets/js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/js/jquery.gritter/css/jquery.gritter.css" />

    <link rel="stylesheet" href="../assets/fonts/font-awesome-4/css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="../assets/js/jquery.nanoscroller/nanoscroller.css" />
    <link rel="stylesheet" type="text/css" href="../assets/js/jquery.easypiechart/jquery.easy-pie-chart.css" />
    <link rel="stylesheet" type="text/css" href="../assets/js/bootstrap.switch/bootstrap-switch.css" />
    <link rel="stylesheet" type="text/css" href="../assets/js/bootstrap.datetimepicker/css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="../assets/js/jquery.select2/select2.css" />
    <link rel="stylesheet" type="text/css" href="../assets/js/bootstrap.slider/css/slider.css" />
    <link rel="stylesheet" type="text/css" href="../assets/js/jquery.niftymodals/css/component.css" />
    <link rel="stylesheet" type="text/css" href="../assets/js/dropzone/css/dropzone.css" />
    <link rel='stylesheet' type='text/css' href='../assets/js/jquery.fullcalendar/fullcalendar/fullcalendar.css' />
    <link rel='stylesheet' type='text/css' href='../assets/js/jquery.fullcalendar/fullcalendar/fullcalendar.print.css'  media='print' />

    <!-- Custom styles for this template -->
    <link href="../assets/css/style.css" rel="stylesheet" />
    <link href="../assets/js/jquery.icheck/skins/square/blue.css" rel="stylesheet">



</head>
<body class="page-body">

<?php
require_once 'header.php';
echo $this->body;
require_once 'footer.php';
?>
<script src="../assets/js/jquery.js"></script>
<script type="text/javascript" src="../assets/js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
<script type="text/javascript" src="../assets/js/jquery.sparkline/jquery.sparkline.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery.easypiechart/jquery.easy-pie-chart.js"></script>
<script src="../assets/js/jquery.ui/jquery-ui.js" type="text/javascript"></script>
<script type="text/javascript" src="../assets/js/jquery.nestable/jquery.nestable.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.switch/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script src="../assets/js/jquery.select2/select2.min.js" type="text/javascript"></script>
<script src="../assets/js/bootstrap.slider/js/bootstrap-slider.js" type="text/javascript"></script>
<script type="text/javascript" src="../assets/js/jquery.gritter/js/jquery.gritter.min.js"></script>
<script type="text/javascript" src="../assets/js/behaviour/general.js"></script>
<script type="text/javascript" src="../assets/js/jquery.niftymodals/js/jquery.modalEffects.js"></script>
<script type="text/javascript" src="../assets/js/jquery.icheck/icheck.min.js"></script>




<script type="text/javascript">
    $(document).ready(function(){
        //initialize the javascript
        App.init();
    });
</script>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../assets/js/behaviour/voice-commands.js"></script>
<script src="../assets/js/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery.flot/jquery.flot.js"></script>
<script type="text/javascript" src="../assets/js/jquery.flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="../assets/js/jquery.flot/jquery.flot.resize.js"></script>
<script type="text/javascript" src="../assets/js/jquery.flot/jquery.flot.labels.js"></script>
</body>
</html>

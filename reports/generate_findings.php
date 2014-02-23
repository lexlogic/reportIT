<?php
require_once 'FirePHPCore/fb.php';
require_once 'PHPWord.php';
require_once '../Init.php';



$con=mysqli_connect("localhost","root","","reportify");
// Check connection
if (mysqli_connect_errno($con))
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$user = new User();
if($user->isLoggedIn()) {

    if(Input::exists()) {
        echo "<pre>";
        var_dump($_POST);
    }


    $page = new Page;
    $page->setTitle('Findings Report');
    $page->startBody();

    //need to read these from post
    $report_id = '1';
    $user_id ='1';

    $con=mysqli_connect("localhost","root","","reportify");
    // Check connection
    if (mysqli_connect_errno($con))
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    //getting the findings_id from the report table
    $sqlquery = "SELECT finding_id from reports WHERE user_id='$user_id' and id='$report_id'";
    $result = mysqli_query($con, $sqlquery);
    $row = mysqli_fetch_array($result);
    //fb($row, 'report findings');
    //explode on ,
    $findings = explode(',',$row['finding_id'] );

$tempfilenum=0;

//set the ratings
$low_min = 1;
$low_max = 10;
$mod_min = 11;
$mod_max = 24;
$sev_min = 25;
$sev_max = 39;
$cri_min = 40;
$cri_max = 50;

foreach ($findings as $finding){

$PHPWord = new PHPWord();
//figure out what template to use
$sqltemplatequery="SELECT template_ID from template where id='1'";
$template_result = mysqli_query($con, $sqltemplatequery);
$row = mysqli_fetch_array($template_result);
//fb($row, 'Template to use');
$number=$row['template_ID'];
$file="template$number.docx";
//fb($file, 'Template file');
$document1 = $PHPWord->loadTemplate($file);
//fb($document1,"document from loadTemplate");

//fb($finding,"Working finding");
//use finding id to query findings table to populate template
$sqlquery="SELECT * from findings WHERE id='$finding'";
$findingresult = mysqli_query($con, $sqlquery);
$row = mysqli_fetch_array($findingresult);
//fb($row,'row data');
//get values from the result
$findingname = $row['findingname'];
$damage = $row['dreaddamage'];
$repro = $row['dreadrepro'];
$expl = $row['dreadexpl'];
$affect = $row['dreadaffect'];
$discover = $row['dreaddiscover'];
$remed = $row['remediation_effort'];
$summary = $row['summary'];
//$proof= $row['proof']; need to make proof column
$recomm = $row['recommendations'];
$total = $discover + $affect + $expl + $repro + $damage;
$risk_rate="";

$crit_status="CONFIRMED"; //need to update ui to have confirmed or exploited

//setup the rating ranges based on total
if (($low_min <= $total) && ($total <= $low_max)){
$risk_rate="LOW";
}
if (($mod_min <= $total) && ($total <= $mod_max)){
$risk_rate="MODERATE";
}
if (($sev_min <= $total) && ($total <= $sev_max)){
$risk_rate="SEVERE";
}
if (($cri_min <= $total) && ($total <= $cri_max)){
$risk_rate="CRITICAL";
}

$document1->setValue('FINDING_NAME',$findingname);
$document1->setValue('CRITICAL_STATUS',$crit_status);
$document1->setValue('RISK_RATE',$risk_rate);
$document1->setValue('CRI_DAM',$damage);
$document1->setValue('CRI_REPRO',$repro);
$document1->setValue('CRI_EXP',$expl);
$document1->setValue('CRI_AFFEC',$affect);
$document1->setValue('CRI_DIS',$discover);
$document1->setValue('CRI_TOTAL',$total);
$document1->setValue('CRI_REM',$remed);
$document1->setValue('CRITICAL_SUMMARY',$summary);
//$document1->setValue('critical_proof',$proof);
$document1->setValue('CRITICAL_RECOMMENDATIONS',$recomm);
//fb($document1, 'document after all the replacements');
$file_name= "finding$tempfilenum.docx";

//fb($file_name, "Saved file name");
echo "Saving the file ... $file_name";
echo "<br>";
//$document1->save("finding0.docx");
$document1->save($file_name);

$tempfilenum = $tempfilenum + 1;


}


}
?>
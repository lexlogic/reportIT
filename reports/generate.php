<?php
require_once 'FirePHPCore/fb.php';
//require_once 'PHPWord.php';
require_once '../Init.php';


$user = new User();
if($user->isLoggedIn()) {

    $page = new Page;
    $page->setTitle('Findings Report');
    $page->startBody();


    //$PHPWord = new PHPWord();

    $getTemplate = DB::getInstance()->getAssoc("SELECT templateID FROM template WHERE id = ?", array(1));
    foreach($getTemplate->results() as $results) {
        $templateID[] = $results;
    }
    fb($templateID[0], 'Template to use');
    $number = $templateID[0]['templateID'];
    $file = "template$number.docx";
    fb($file, 'Template file');
    $document1 = $PHPWord->loadTemplate($file);

    //need to read these from post
    $report_id = '1';
    $user_id ='1';


    $getFindingID = DB::getInstance()->getAssoc("SELECT finding_id FROM reports WHERE user_id = ? AND id = ?", array($user_id, $report_id));
    foreach($getFindingID->results() as $results) {
        $findingID[] = $results;
    }

    fb($findingID[0], 'report findings');
    //explode on ,
    $findings = explode(',',$findingID[0]['finding_id'] );

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

        fb($finding,"Working finding");
        $sqlquery="SELECT * from findings WHERE id='$finding'";
        $findingresult = mysqli_query($con, $sqlquery);
        $row = mysqli_fetch_array($findingresult);
        fb($row,'row data');

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

        $file_name= "finding$tempfilenum.docx";

        fb($file_name, "Saved file name");
        echo "Saving the file ... $file_name";
        echo "<br>";
//$document1->save("finding0.docx");
        $document1->save($file_name);

        $tempfilenum = $tempfilenum + 1;


    }
}
?>
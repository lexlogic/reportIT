<?php
require_once 'core/fb.php';
require_once 'PHPWord.php';
require_once '../Init.php';

$user = new User();
if($user->isLoggedIn()) {

    $page = new Page;
    $page->setTitle('Findings Report');
    $page->startBody();

    $report_id = '1';
    $user_id ='1';


    $getFindingID = DB::getInstance()->getAssoc("SELECT finding_id from reports WHERE user_id = ? and id = ?", array($user_id, $report_id));
    foreach($getFindingID->results() as $results) {
        $findingID[] = $results;
    }
    $findings = explode(',',$findingID[0]['finding_id'] );

    $i = 0;
    $low_min = 1;
    $low_max = 10;
    $mod_min = 11;
    $mod_max = 24;
    $sev_min = 25;
    $sev_max = 39;
    $cri_min = 40;
    $cri_max = 50;
    $countFindings = count($findings);
    $PHPWord = new PHPWord();
    $section = $PHPWord->createSection();

    foreach ($findings as $getfinding) {

        $getTemplateID = DB::getInstance()->getAssoc("SELECT template_ID from template WHERE id = 1");
        foreach($getTemplateID->results() as $results) {
            $templateID[] = $results;
        }
        $number = $templateID[0]['template_ID'];
        $file = "templates/template".$number.".docx";
        $document1 = $PHPWord->loadTemplate($file);

        $getFindings = DB::getInstance()->getAssoc("SELECT * from findings WHERE id = ?", array($getfinding));
        foreach($getFindings->results() as $results) {
            $allFindings[] = $results;
        }

        $findingname = $allFindings[$i]['findingname'];
        $damage = $allFindings[$i]['dreaddamage'];
        $repro = $allFindings[$i]['dreadrepro'];
        $expl = $allFindings[$i]['dreadexpl'];
        $affect = $allFindings[$i]['dreadaffect'];
        $discover = $allFindings[$i]['dreaddiscover'];
        $remed = $allFindings[$i]['remediation_effort'];
        $summary = $allFindings[$i]['summary'];


        $recomm = $allFindings[$i]['recommendations'];
        $total = $discover + $affect + $expl + $repro + $damage;
        $risk_rate = "";
        $crit_status="CONFIRMED";

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
        $document1->setValue('CRI_AFEC',$affect);
        $document1->setValue('CRI_DIS',$discover);
        $document1->setValue('CRI_TOTAL',$total);
        $document1->setValue('CRI_REM',$remed);
        $document1->setValue('CRITICAL_SUMMARY',$summary);
        //$document1->setValue('critical_proof',$proof);
        $document1->setValue('CRITICAL_RECOMMENDATIONS',$recomm);
        $document1->save('finding'.$i.'.docx');
        $i = $i + 1;
    }
    Redirect::to('../dashboard/');
}
?>
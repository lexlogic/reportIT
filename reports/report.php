<?php
require_once 'FirePHPCore/fb.php';
require_once '../Init.php';


$user = new User();
if($user->isLoggedIn()) {
 
    $page = new Page;
    $page->setTitle('Findings Report');
    $page->startBody();
 ?>
<div class='container-fluid' id='pcont'>
<div class='cl-mcont'>
<?php
    $getTemplateID = DB::getInstance()->getAssoc("SELECT template_ID FROM template WHERE id = 1");
    foreach($getTemplateID->results() as $results) {
        $templateID[] = $results;
    }

     $getUserId = DB::getInstance()->getAssoc("SELECT id FROM users WHERE username = ?", array($user->data()->username));
                                                    foreach($getUserId->results() as $results) {
                                                        $userId[] = $results;
                                                    }
    $user_id=$userId[0]['id'];

     if (empty($_POST['report_id'])) {
         exit;
     }
     $report_id = $_POST['report_id'];
    //$report_id = '1';
    //$user_id ='1';

    $encode = $templateID[0]['template_ID'];
    $decoded = base64_decode($encode);
    fb($user_id, 'userid');
    fb($report_id,'reportid');
    $getFindingID = DB::getInstance()->getAssoc("SELECT finding_id from reports WHERE user_id = ? and id = ?", array($user_id, $report_id));
    foreach($getFindingID->results() as $results) {
        fb($results, 'results');
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
 
    foreach ($findings as $getfinding) {
        $getFindings = DB::getInstance()->getAssoc("SELECT * from findings WHERE id = ?", array($getfinding));
        foreach($getFindings->results() as $results) {
            $allFindings[] = $results;
        }
    }
    for ($i = 0; $i < count($allFindings); $i++)
    {
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
 
        $findme = array("\${FINDING_NAME}", "\${STATUS}", "\${RISK_RATE}", "\${DAM}", "\${REPRO}", "\${EXP}", "\${AFEC}", "\${DIS}", "\${TTL}","\${REM}","\${SUMMARY}","\${PROOF}", "\${RECOMMENDATIONS}" );
        $replacewith   = array($findingname, $crit_status, $risk_rate, $damage, $repro, $expl, $affect, $discover, $total,$remed,$summary,"No Proof", $recomm  );
 
        $complete = str_replace($findme, $replacewith, $decoded);
 
        echo "<div class='row'>";
        //echo "<pre>";
        echo $complete;
        //echo "</pre>";
        echo "</div>";
        echo "<br>";
    }
echo "</div>";

$page->endBody();
echo $page->render('../includes/template.php');
} else {
    Redirect::to('../dashboard/');
}
?>
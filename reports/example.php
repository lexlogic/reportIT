<?php
require_once '../Init.php';
$user = new User();

$getFindings = DB::getInstance()->getAssoc("SELECT * FROM findings");
foreach($getFindings->results() as $results) {
    $findings[] = $results;
}
?>


<link href="../assets/js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../assets/js/jquery.gritter/css/jquery.gritter.css" />
<link href="../assets/css/style.css" rel="stylesheet" />
<link href="../assets/js/jquery.icheck/skins/square/blue.css" rel="stylesheet">

<div class="col-lg-3"></div>
<div class="col-lg-6">

<?php
if(!empty($findings)) {
    $low_min = 1;
    $low_max = 10;
    $mod_min = 11;
    $mod_max = 24;
    $sev_min = 25;
    $sev_max = 39;
    $cri_min = 40;
    $cri_max = 50;

    foreach($findings as $finding) {
        $total = $finding['dreaddiscover'] + $finding['dreadaffect'] + $finding['dreadexpl'] + $finding['dreadrepro'] + $finding['dreaddamage'];
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
?>
    <div class="col-lg-12">
        <div class="block-flat">
            <div class="header">
                <?php echo $finding['findingname']; ?><br>
                <strong>Dread Score Summary&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; STATUS: </strong>${CRITICAL_STATUS}<br>
                <table>
                    <tbody>
                    <tr>
                        <td>
                            <table>
                                <tbody>
                                <tr>
                                    <td colspan='4'>
                                        <strong>Risk Rating</strong><br>
                                    </td>
                                    <td colspan='4'>
                                        <p style="text-align: right;"><?php echo $risk_rate; ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Damage<br>
                                        Potential<br>
                                    </td>
                                    <td>
                                        Reproducibility<br>
                                    </td>
                                    <td>
                                        Exploitability<br>
                                    </td>
                                    <td colspan='2'>
                                        Affected Users<br>
                                    </td>
                                    <td>
                                        Discoverability<br>
                                    </td>
                                    <td>
                                        <p>Total</p>
                                    </td>
                                    <td>
                                        Remediation<br>
                                        Effort<br>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo $finding['dreaddamage']; ?><br>
                                    </td>
                                    <td>
                                        <?php echo $finding['dreadrepro']; ?><br>
                                    </td>
                                    <td>
                                        <?php echo $finding['dreadexpl']; ?><br>
                                    </td>
                                    <td colspan='2'>
                                        <?php echo $finding['dreadaffect']; ?><br>
                                    </td>
                                    <td>
                                        <?php echo $finding['dreaddiscover']; ?><br>
                                    </td>
                                    <td>
                                        <?php echo $total; ?><br>
                                    </td>
                                    <td>
                                        <?php echo $finding['remediation_effort']; ?><br>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <strong>Summary of Finding</strong><br>
                <?php echo $finding['summary']; ?><br>
                <strong>Proof of Concept</strong><br>
                {CRITICAL_PROOF}<br>
                <strong>Recommendations</strong><br>
                <?php echo $finding['recommendations']; ?><br>
            </div>
        </div>
    </div>
<?php } } ?>

</div>
<div class="col-lg-3"></div>

<script src="../assets/js/jquery.js"></script>
<script type="text/javascript" src="../assets/js/behaviour/general.js"></script>
<script src="../assets/js/bootstrap/dist/js/bootstrap.min.js"></script>
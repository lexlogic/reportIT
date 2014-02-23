<?php
require_once '../Init.php';

$user = new User();
if($user->isLoggedIn() && $user->hasPermission('manager')) {
    if(Input::exists()) {
        if(Token::check(Input::get('token'))) {
            $update = DB::getInstance()->update('template', 1, array(
                'templateID' => Input::get('template')
            ));
        }
    }

    $page = new Page;
    $page->setTitle('Report Generator');
    $page->startBody();
    ?>

    <div class="col-lg-12">
        <div class="block-flat">
            <div class="header">
                <h3>Document Map</h3>
            </div>
            <div class="content">
                Findings are based on the DREAD model.<br>
                ${FINDING_NAME} -> Finding Name <br>
                ${CRITICAL_STATUS} -> Critical Status IE: Exploited, Confirmed<br>
                ${RISK_RATE} -> Risk Rating: Critical, Severe, Moderate, Low. Based on score<br>
                ${CRI_DAM} -> Damage Potential <br>
                ${CRI_REPRO} -> Reproducibility<br>
                ${CRI_EXP} ->  Exploitability <br>
                ${CRI_AFEC} -> Affected Users<br>
                ${CRI_DIS} -> Discoverability <br>
                ${CRI_TTL} ->  Total<br>
                ${CRI_REM} -> Remediation Effort <br>
                ${CRITICAL_SUMMARY} -> Finding Summary <br>
                ${CRITICAL_PROOF} -> Finding Proof <br>
                ${CRITICAL_RECOMMENDATIONS} -> Finding Recommendations <br>
            </div>
        </div>
    </div>
    <form method="post" action="">

    <div class="col-lg-6 pull-left">
        <label class="radio-inline">
            Template 1 <input type="radio" name="template" class="icheck" value="1">
        </label>
        <div class="block-flat">
            <div class="header">
                ${FINDING_NAME}<br>
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
                                        <p style="text-align: right;">${RISK_RATE}</p>
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
                                        ${CRI_DAM}<br>
                                    </td>
                                    <td>
                                        ${CRI_REPRO}<br>
                                    </td>
                                    <td>
                                        ${CRI_EXP}<br>
                                    </td>
                                    <td colspan='2'>
                                        ${CRI_AFEC}<br>
                                    </td>
                                    <td>
                                        ${CRI_DIS}<br>
                                    </td>
                                    <td>
                                        ${CRI_TTL}<br>
                                    </td>
                                    <td>
                                        ${CRI_REM}<br>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <strong>Summary of Finding</strong><br>
                ${CRITICAL_SUMMARY}<br>
                <strong>Proof of Concept</strong><br>
                {CRITICAL_PROOF}<br>
                <strong>Recommendations</strong><br>
                ${CRITICAL_RECOMMENDATIONS}<br>
            </div>
        </div>
    </div>


    <div class="col-lg-6 pull-left">
        <label class="radio-inline">
            Template 2 <input type="radio" name="template" class="icheck" value="2">
        </label>
        <div class="block-flat">
            <div class="header">
                <p>${FINDING_NAME}<br /> </p>
                <p><strong>Dread Score Summary&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></p>
                <p><strong>&nbsp;</strong></p>
                <p><strong>STATUS: </strong>${CRITICAL_STATUS}</p>
                <table>
                    <tbody>
                    <tr>
                        <td>
                            <table>
                                <tbody>
                                <tr>
                                    <td colspan="4">
                                        <p><strong>Risk Rating</strong></p>
                                    </td>
                                    <td colspan="4">
                                        <p>${RISK_RATE}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Damage<br /> Potential</p>
                                    </td>
                                    <td>
                                        <p>Reproducibility</p>
                                    </td>
                                    <td>
                                        <p>Exploitability</p>
                                    </td>
                                    <td colspan="2">
                                        <p>Affected Users</p>
                                    </td>
                                    <td>
                                        <p>Discoverability</p>
                                    </td>
                                    <td>
                                        <p>Total</p>
                                    </td>
                                    <td>
                                        <p>Remediation<br /> Effort</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>${CRI_DAM}</p>
                                    </td>
                                    <td>
                                        <p>${CRI_REPRO}</p>
                                    </td>
                                    <td>
                                        <p>${CRI_EXP}</p>
                                    </td>
                                    <td colspan="2">
                                        <p>${CRI_AFEC}</p>
                                    </td>
                                    <td>
                                        <p>${CRI_DIS}</p>
                                    </td>
                                    <td>
                                        <p>${CRI_TTL}</p>
                                    </td>
                                    <td>
                                        <p>${CRI_REM}</p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <p><strong>Summary of Finding</strong><br /> ${CRITICAL_SUMMARY}<br /> </p>
                <p><strong>Recommendations</strong><br /> ${CRITICAL_RECOMMENDATIONS}</p>
                <p><strong>Proof of Concept</strong><br /> {CRITICAL_PROOF}<br /> </p>
            </div>
        </div>
    </div>



    <div class="col-lg-6 pull-left">
        <label class="radio-inline">
            Template 3 <input type="radio" name="template" class="icheck" value="3">
        </label>
        <div class="block-flat">
            <div class="header">
                <p><strong>STATUS: </strong>${CRITICAL_STATUS}</p>
                <p>&nbsp;</p>
                <p>${FINDING_NAME}<br /> </p>
                <p><strong>Dread Score Summary&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></p>
                <table>
                    <tbody>
                    <tr>
                        <td>
                            <table>
                                <tbody>
                                <tr>
                                    <td colspan="4">
                                        <p><strong>Risk Rating</strong></p>
                                    </td>
                                    <td colspan="4">
                                        <p>${RISK_RATE}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Damage<br /> Potential</p>
                                    </td>
                                    <td>
                                        <p>Reproducibility</p>
                                    </td>
                                    <td>
                                        <p>Exploitability</p>
                                    </td>
                                    <td colspan="2">
                                        <p>Affected Users</p>
                                    </td>
                                    <td>
                                        <p>Discoverability</p>
                                    </td>
                                    <td>
                                        <p>Total</p>
                                    </td>
                                    <td>
                                        <p>Remediation<br /> Effort</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>${CRI_DAM}</p>
                                    </td>
                                    <td>
                                        <p>${CRI_REPRO}</p>
                                    </td>
                                    <td>
                                        <p>${CRI_EXP}</p>
                                    </td>
                                    <td colspan="2">
                                        <p>${CRI_AFEC}</p>
                                    </td>
                                    <td>
                                        <p>${CRI_DIS}</p>
                                    </td>
                                    <td>
                                        <p>${CRI_TTL}</p>
                                    </td>
                                    <td>
                                        <p>${CRI_REM}</p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <p><strong>Summary of Finding</strong><br /> ${CRITICAL_SUMMARY}</p>
                <p><strong>Recommendations</strong><br /> ${CRITICAL_RECOMMENDATIONS}</p>
                <p><strong>Proof of Concept</strong><br /> {CRITICAL_PROOF}<br /> </p>
            </div>
        </div>
    </div>



    <div class="col-lg-6 pull-left">
        <label class="radio-inline">
            Template 4 <input type="radio" name="template" class="icheck" value="4">
        </label>
        <div class="block-flat">
            <div class="header">
                <p>${FINDING_NAME}<br /> </p>
                <p><strong>Summary of Finding</strong><br /> ${CRITICAL_SUMMARY}<br /> </p>
                <p><strong>Recommendations</strong><br /> ${CRITICAL_RECOMMENDATIONS}</p>
                <p><strong>Proof of Concept</strong><br /> {CRITICAL_PROOF}<br /> </p>
                <p><strong>Dread Score Summary&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;STATUS: </strong>${CRITICAL_STATUS}</p>
                <table>
                    <tbody>
                    <tr>
                        <td>
                            <table>
                                <tbody>
                                <tr>
                                    <td colspan="4">
                                        <p><strong>Risk Rating</strong></p>
                                    </td>
                                    <td colspan="4">
                                        <p>${RISK_RATE}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Damage<br /> Potential</p>
                                    </td>
                                    <td>
                                        <p>Reproducibility</p>
                                    </td>
                                    <td>
                                        <p>Exploitability</p>
                                    </td>
                                    <td colspan="2">
                                        <p>Affected Users</p>
                                    </td>
                                    <td>
                                        <p>Discoverability</p>
                                    </td>
                                    <td>
                                        <p>Total</p>
                                    </td>
                                    <td>
                                        <p>Remediation<br /> Effort</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>${CRI_DAM}</p>
                                    </td>
                                    <td>
                                        <p>${CRI_REPRO}</p>
                                    </td>
                                    <td>
                                        <p>${CRI_EXP}</p>
                                    </td>
                                    <td colspan="2">
                                        <p>${CRI_AFEC}</p>
                                    </td>
                                    <td>
                                        <p>${CRI_DIS}</p>
                                    </td>
                                    <td>
                                        <p>${CRI_TTL}</p>
                                    </td>
                                    <td>
                                        <p>${CRI_REM}</p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-12 pull-left">
        <input type="hidden" name="token" value="<?php echo escape(Token::generate()); ?>" />
        <input type="submit" class="btn btn-primary btn-flat" name="chooseTemplate" placeholder="Submit" />
    </div>
    </form>
    <?php
    $page->endBody();
    echo $page->render('../includes/template.php');
} else {
    Redirect::to('../dashboard/');
}
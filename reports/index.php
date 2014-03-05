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
    $page->setTitle('Findings Template');
    $page->startBody();
    ?>

    <script type="text/javascript" src="jquery-2.1.0.js"></script>
    <script type="text/javascript" src="tinymce/js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: "textarea",
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste textcolor"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image| forecolor backcolor",
            id: "template_editor"
        });
    </script>
    <script>
        function save(){
            var st = tinyMCE.get('content').getContent();
            $.ajax({
                type: "POST",
                url: "update.php",
                data: {data: st},
                success: function (returndata) {
                    alert( "Template updated!" );
                }});}
    </script>
    <div class="container-fluid" id="pcont">
        <div class="cl-mcont">
            <div class="row">
                <div class="col-lg-6">
                    <div class="block-flat">
                        <div class="header">
                            <h3 class="visible-lg">Template Editor</h3>
                        </div>
                        <div class="content">
                            <div id="editor">
                                <form method="post" action="javascript:save();">
                                    <div class="form-group">
                                        <textarea name="content" class="form-control" style="width:100%; height: 300px">
                                            <h2><span style="color: #ff6600;">${FINDING_NAME}</span></h2>
                                            <p><strong>DREAD Score Summary &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; STATUS: <span style="color: #ff0000;">$</span></strong><span style="color: #ff0000;"><strong>{CRITICAL_STATUS}</strong></span></p>
                                            <table width="100%">
                                                <tbody>
                                                <tr>
                                                    <td colspan="3" width="30%">
                                                        <p><strong>Risk Rating</strong></p>
                                                    </td>
                                                    <td colspan="5">
                                                        <p style="text-align: right;"><span style="color: #3366ff;"><strong>${RISK_RATE}</strong></span></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="9%">
                                                        <p>Damage Potential</p>
                                                    </td>
                                                    <td width="15%">
                                                        <p>Reproducibility</p>
                                                    </td>
                                                    <td colspan="2" width="14%">
                                                        <p>Exploitability</p>
                                                    </td>
                                                    <td width="15%">
                                                        <p>Affected Users</p>
                                                    </td>
                                                    <td width="15%">
                                                        <p>Discoverability</p>
                                                    </td>
                                                    <td width="11%">
                                                        <p>Total</p>
                                                    </td>
                                                    <td width="14%">
                                                        <p>Remediation<br /> Effort</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="9%">
                                                        <p>${DAM}</p>
                                                    </td>
                                                    <td width="15%">
                                                        <p>${REPRO}</p>
                                                    </td>
                                                    <td colspan="2" width="14%">
                                                        <p>${EXP}</p>
                                                    </td>
                                                    <td width="15%">
                                                        <p>${AFEC}</p>
                                                    </td>
                                                    <td width="15%">
                                                        <p>${DIS}</p>
                                                    </td>
                                                    <td width="11%">
                                                        <p>${TTL}</p>
                                                    </td>
                                                    <td width="14%">
                                                        <p><strong>${REM}</strong></p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <p><strong>Summary of Finding</strong></p>
                                            <p>${SUMMARY}</p>
                                            <p><strong>Proof of Concept</strong><strong>&nbsp;</strong></p>
                                            <p>${PROOF}</p>
                                            <p><strong>Recommendations</strong></p>
                                            <p>${RECOMMENDATIONS}</p>
                                        </textarea>
                                    </div>
                                </form>
                                <div class="form-group">
                                    <input type="submit" value="Submit" class="btn btn-primary" onclick="javascript:save();">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="toc" class="col-lg-6">
                    <div class="block-flat">
                        <div class="header">
                            <h3 class="visible-lg">Findings are based on the DREAD model</h3>
                        </div>
                        <div class="content">
                            Document Map<br>
                            <br>
                            ${FINDING_NAME} -> Finding Name <br>
                            ${STATUS} -> Critical Status IE: Exploited, Confirmed<br>
                            ${RISK_RATE} -> Risk Rating: Critical, Severe, Moderate, Low. Based on score<br>
                            ${DAM} -> Damage Potential <br>
                            ${REPRO} -> Reproducibility<br>
                            ${EXP} ->  Exploitability <br>
                            ${AFEC} -> Affected Users<br>
                            ${DIS} -> Discoverability <br>
                            ${TTL} ->  Total<br>
                            ${REM} -> Remediation Effort <br>
                            ${SUMMARY} -> Finding Summary <br>
                            ${PROOF} -> Finding Proof <br>
                            ${RECOMMENDATIONS} -> Finding Recommendations <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $page->endBody();
    echo $page->render('../includes/template.php');
} else {
    Redirect::to('../dashboard/');
}
?>
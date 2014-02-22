<?php
require_once '../Init.php';

$user = new User();
if($user->isLoggedIn() && $user->hasPermission('manager')) {

    if(Input::exists()) {
        echo "<pre>";
        var_dump($_POST);
    }


    $page = new Page;
    $page->setTitle('Report Generator');
    $page->startBody();
    ?>

    <html>
    <body>
    <style>
        #editor{
            width: 100%;
        }
    </style>

    <script type="text/javascript" src="jquery-2.1.0.js"></script>
    <script type="text/javascript" src="tinymce/js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: "textarea",
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            id: "template_editor"
        });
    </script>

    <div class="col-lg-6">
        <div class="block-flat">
            <div class="header">
                <h3>Template Editor</h3>
            </div>
            <div class="content">
                <div id="editor">
                    <form method="post">
                        <textarea name="content" style="width:100%"></textarea>
                        <div class="form-group">
                            <input type="button" class="btn btn-info" onclick="save_template()" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
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


    <div class="col-lg-12 pull-left">
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

    <script>
        function save_template(){
            var st = tinyMCE.get('content').getContent();
            $.ajax({
                type: "POST",
                url: "template_update.php",
                data: {data: st},
                success: function (returndata) {
                    alert( "Data Loaded: " + returndata );
                    console.log(returndata);
                    checkstatus(data);
                }
            });
        }
    </script>
    </body>
    </html>

    <?php
    $page->endBody();
    echo $page->render('../includes/template.php');
} else {
    Redirect::to('../dashboard/');
}
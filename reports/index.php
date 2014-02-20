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
                    <form method="post" enctype="multipart/form-data" action="">
                        <textarea name="content" style="width:100%"></textarea>
                        <div class="form-group">
                            <input type="submit" class="btn btn-info" name="uploadfile" value="Submit">
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
                <h3>${FINDING_NAME}</h3>
            </div>
            <div class="content">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <div style="float: left;">Dread Score Summary: ${CRI_DAM}<br><br>Critical Status: ${CRITICAL_STATUS}<br></div>
                        </tr>
                        <tr>
                            <th>Risk Rating</th>
                            <th>Damage Potential</th>
                            <th>Reproducibility</th>
                            <th>Exploitability</th>
                            <th>Affected Users</th>
                            <th>Discoverability</th>
                            <th>Total</th>
                            <th>Remediation Effort</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                ${RISK_RATE}
                            </td>
                            <td>
                                ${CRI_DAM}
                            </td>
                            <td>
                                ${CRI_REPRO}
                            </td>
                            <td>
                                ${CRI_EXP}
                            </td>
                            <td>
                                ${CRI_AFEC}
                            </td>
                            <td>
                                ${CRI_DIS}
                            </td>
                            <td>
                                ${CRI_TTL}
                            </td>
                            <td>
                                ${CRI_REM}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Summary of Finding</th>
                            <th>Proof of Concept</th>
                            <th>Recommendations</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                ${CRITICAL_SUMMARY}
                            </td>
                            <td>
                                ${CRITICAL_PROOF}
                            </td>
                            <td>
                                ${CRITICAL_RECOMMENDATIONS}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function alertAllEditorIDs () {
            var IDs = new Array();
            var editorID;
            for (editorID in tinyMCE.editors) {
                IDs[IDs.length] = editorID;
            };

            alert("All editor IDs:\n" + IDs);
        }
        function save(){
            var st = $('content');
            $.ajax({
                type: "POST",
                url: "index.php",
                data: {data: st},
                sucess: function (returndata) {
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
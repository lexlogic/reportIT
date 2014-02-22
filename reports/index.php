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
        .draggable {
            padding: 5px; float: left; margin: 0 10px 10px 0; font-size: .9em;
            cursor: hand;
            z-index: 1000;
        }
        .ui-widget-header p, .ui-widget-content p { margin: 0; }
        #snaptarget { height: 140px; }
    </style>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.9.1.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
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
    <script>
        $(function() {
            $( "#draggable1" ).draggable({ grid: [ 1, 1 ] });
            $( "#draggable2" ).draggable({ grid: [ 1, 1 ] });
            $( "#draggable3" ).draggable({ grid: [ 1, 1 ] });
            $( "#draggable4" ).draggable({ grid: [ 1, 1 ] });
            $( "#draggable5" ).draggable({ grid: [ 1, 1 ] });
            $( "#draggable6" ).draggable({ grid: [ 1, 1 ] });
            $( "#draggable7" ).draggable({ grid: [ 1, 1 ] });
            $( "#draggable8" ).draggable({ grid: [ 1, 1 ] });
            $( "#draggable9" ).draggable({ grid: [ 1, 1 ] });
            $( "#draggable10" ).draggable({ grid: [ 1, 1 ] });
            $( "#draggable11" ).draggable({ grid: [ 1, 1 ] });
            $( "#draggable12" ).draggable({ grid: [ 1, 1 ] });
            $( "#draggable13" ).draggable({ grid: [ 1, 1 ] });
        });
    </script>
    <div class="col-lg-6">
        <div class="block-flat">
            <div class="header">
                <h3>Template Editor</h3>
            </div>
            <div class="content">
                <div id="editor">
                    <form method="post" action="template_update.php">
                        <textarea name="content" style="width:100%"></textarea>
                        <div class="form-group">
                            <input type="submit" class="btn btn-info" value="Submit">
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
                <div id="draggable1" class="draggable ui-widget-content">${FINDING_NAME}</div>
                -> Finding Name<br><br><br>

                <div id="draggable2" class="draggable ui-widget-content">${CRITICAL_STATUS}</div>
                -> Critical Status IE: Exploited, Confirmed<br><br><br>


                <div id="draggable3" class="draggable ui-widget-content">${RISK_RATE}</div>
                -> Risk Rating: Critical, Severe, Moderate, Low. Based on score<br><br><br>


                <div id="draggable4" class="draggable ui-widget-content">${CRI_DAM}</div>
                -> Damage Potential<br><br><br>


                <div id="draggable5" class="draggable ui-widget-content">${CRI_REPRO}</div>
                -> Reproducibility<br><br><br>


                <div id="draggable6" class="draggable ui-widget-content">${CRI_EXP}</div>
                ->  Exploitability <br><br><br>


                <div id="draggable7" class="draggable ui-widget-content">${CRI_AFEC}</div>
                -> Affected Users<br><br><br>


                <div id="draggable8" class="draggable ui-widget-content">${CRI_DIS}</div>
                -> Discoverability <br><br><br>


                <div id="draggable9" class="draggable ui-widget-content">${CRI_TTL}</div>
                ->  Total<br><br><br>


                <div id="draggable10" class="draggable ui-widget-content">${CRI_REM}</div>
                -> Remediation Effort <br><br><br>


                <div id="draggable11" class="draggable ui-widget-content">${CRITICAL_SUMMARY}</div>
                -> Finding Summary <br><br><br>


                <div id="draggable12" class="draggable ui-widget-content">${CRITICAL_PROOF}</div>
                -> Finding Proof <br><br><br>


                <div id="draggable13" class="draggable ui-widget-content">${CRITICAL_RECOMMENDATIONS}</div>
                -> Finding Recommendations <br><br><br>
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
    </body>
    </html>
    <?php
    $page->endBody();
    echo $page->render('../includes/template.php');
} else {
    Redirect::to('../dashboard/');
}
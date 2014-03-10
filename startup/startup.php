<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../assets/images/favicon.png">

    <title>reportIT startup page</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>

    <!-- Bootstrap core CSS -->
    <link href="../assets/js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/fonts/font-awesome-4/css/font-awesome.min.css">

    <!-- Custom styles for this template -->
    <link href="../assets/css/style.css" rel="stylesheet" />
</head>
<script>
    $(document).ready(function(){
        $('.slider1').bxSlider({
            slideWidth: 200,
            minSlides: 2,
            maxSlides: 3,
            slideMargin: 10
        });
    });
</script>
<body class="texture">
<div id="cl-wrapper" class="login-container">
    <div class="start-up">
        <div class="block-flat">
            <div class="header">
                <h3 class="text-center"><img class="logo-img" src="../assets/images/logo.png" alt="logo"/>reportIT</h3>
            </div>
            <div class="slider1">
                Welcome to ReportIT!
             <div class="slide"><div id="user-startup" class="block-flat"></div>
                Lets first create a user.

                Username: <input type="text"/>
                Password: <input type="password" />
                Password(again): <input type="password" />
             </div>
                Congrats on your first user! This user will have Manager role assigned to it.

            <div class="slide"><div id="cat-startup" class="block-flat"></div>
                Lets define the Categories of work that will be accomplished. IE. Web assessments, Network assessment, etc..
                <form>
                    <fieldset>

                        <select name="selectfrom" id="select-from" multiple size="5">
                            <option value="1">Web assessments</option>
                            <option value="2">Network assessments</option>
                            <option value="3">Social engineering</option>
                            <option value="4">Physical assessments</option>
                        </select>

                        <a href="JavaScript:void(0);" id="btn-add">Add &raquo;</a>
                        <a href="JavaScript:void(0);" id="btn-remove">&laquo; Remove</a>

                        <select name="selectto" id="select-to" multiple size="5">
                        </select>

                    </fieldset>
                </form>
                <script>
                    $(document).ready(function() {

                    $('#btn-add').click(function(){
                    $('#select-from option:selected').each( function() {
                    $('#select-to').append("<option value='"+$(this).val()+"'>"+$(this).text()+"</option>");
                    $(this).remove();
                    });
                    });
                    $('#btn-remove').click(function(){
                    $('#select-to option:selected').each( function() {
                    $('#select-from').append("<option value='"+$(this).val()+"'>"+$(this).text()+"</option>");
                    $(this).remove();
                    });
                    });

                    });
                </script>
              </div>
                Congrats on setting up some categories

             <div class="slide"><div id="task-startup" class="block-flat"></div>
                Lets setup some tasks that have to be accomplished for each category of work. IE. Scanning, Input validation, etc..

                 <fieldset>
                     Web assessments <br>
                     Avaliable tasks
                     <select name="selectfrom" id="select-from" multiple size="5">
                         <option value="1">Port Scanning</option>
                         <option value="2">Spidering</option>
                         <option value="3">Input validation</option>
                         <option value="4">Exploitation</option>
                     </select>

                     <a href="JavaScript:void(0);" id="btn-add">Add &raquo;</a>
                     <a href="JavaScript:void(0);" id="btn-remove">&laquo; Remove</a>

                     Tasks added to category
                     <select name="selectto" id="select-to" multiple size="5">
                     </select>

                 </fieldset>

                 <fieldset>
                     Network assessments <br>
                     Avaliable tasks
                     <select name="selectfrom" id="select-from" multiple size="5">
                         <option value="1">Port Scanning</option>
                         <option value="2">Spidering</option>
                         <option value="3">Input validation</option>
                         <option value="4">Exploitation</option>
                     </select>

                     <a href="JavaScript:void(0);" id="btn-add">Add &raquo;</a>
                     <a href="JavaScript:void(0);" id="btn-remove">&laquo; Remove</a>

                     Tasks added to category
                     <select name="selectto" id="select-to" multiple size="5">
                     </select>

                 </fieldset>

                 <fieldset>
                     Social engineering <br>
                     Avaliable tasks
                     <select name="selectfrom" id="select-from" multiple size="5">
                         <option value="1">Port Scanning</option>
                         <option value="2">Spidering</option>
                         <option value="3">Input validation</option>
                         <option value="4">Exploitation</option>
                     </select>

                     <a href="JavaScript:void(0);" id="btn-add">Add &raquo;</a>
                     <a href="JavaScript:void(0);" id="btn-remove">&laquo; Remove</a>

                     Tasks added to category
                     <select name="selectto" id="select-to" multiple size="5">
                     </select>

                 </fieldset>

                 <fieldset>
                     Physical assessments <br>
                     Avaliable tasks
                     <select name="selectfrom" id="select-from" multiple size="5">
                         <option value="1">Port Scanning</option>
                         <option value="2">Spidering</option>
                         <option value="3">Input validation</option>
                         <option value="4">Exploitation</option>
                     </select>

                     <a href="JavaScript:void(0);" id="btn-add">Add &raquo;</a>
                     <a href="JavaScript:void(0);" id="btn-remove">&laquo; Remove</a>

                     Tasks added to category
                     <select name="selectto" id="select-to" multiple size="5">
                     </select>

                 </fieldset>

               </div>
                Congrats on setting up some tasks

             <div class="slide"><div id="finding-startup" class="block-flat"></div>
                Lets setup your finding template.

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
                Congrats on setting up your template.
             <div class="slide"><div id="finish-up" class="block-flat"></div>
                Every thing seems to be ready to setup. Verify all the details below and Click submit.

               </div>
            </div>
        </div>
        <div class="text-center out-links block-flat" style="padding: 10px; margin-top: -15px;">
            <h4 class="title">&copy; 2014 reportIT</h4>
        </div>
    </div>
</div>
<script src="../assets/js/jquery.js"></script>
<script type="text/javascript" src="../assets/js/behaviour/general.js"></script>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../assets/js/behaviour/voice-commands.js"></script>
<script src="../js/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery.flot/jquery.flot.js"></script>
<script type="text/javascript" src="../assets/js/jquery.flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="../assets/js/jquery.flot/jquery.flot.resize.js"></script>
<script type="text/javascript" src="../assets/js/jquery.flot/jquery.flot.labels.js"></script>

</body>
</html>
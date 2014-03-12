<?php
require_once '../Init.php';

$user = new User();
if($user->isLoggedIn() && $user->hasPermission('manager')) {
    $totalEngagements = DB::getInstance()->getAssoc("SELECT * FROM engagements");
    foreach($totalEngagements->results() as $results) {
        $engagements[] = $results;
    }

    $page = new Page;
    $page->setTitle('Engagement Schedule');
    $page->startBody();
    ?>

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="block-flat">
                <div class="header">
                    <h3>Engagements</h3>
                </div>
                <div class="content">
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
    <?php
    $page->endBody();
    echo $page->render('../includes/template.php');
} else {
    Redirect::to('../dashboard/');
} ?>

<script type='text/javascript' src='../assets/js/jquery.fullcalendar/fullcalendar/fullcalendar.js'></script>
<script type="text/javascript">
    $(document).ready(function() {

        // page is now ready, initialize the calendar...

        /* initialize the external events
         -----------------------------------------------------------------*/

        $('#external-events div.external-event').each(function() {

            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
                title: $.trim($(this).text()) // use the element's text as the event title
            };

            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);
        });
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var color = '#2494F2';

        $('#calendar').fullCalendar({
            header: {
                left: 'title',
                center: '',
                right: 'prev,next'
            },
            editable: false,
            events: [

                <?php
                if(!empty($engagements)) {
                    foreach ($engagements as $engagement) {
                        echo "{";
                        $start = date("d M Y", strtotime($engagement['start']));
                        $stop = date("d M Y", strtotime($engagement['stop']));
                        echo "title: '".$engagement['engagement_name']."',\n";
                        echo "start: new Date('".$start."'),\n";
                        echo "end: new Date('".$stop."'),\n";
                        echo "url: '#engagement',\n";
                        echo "complete: '".$engagement['complete']."%',\n";
                        echo "id: '".$engagement['id']."',\n";
                        echo "assigned: '".$engagement['username']."',\n";
                        echo "allDay: 'true',\n\n";
                        ?>
                        color: color
                        <?php
                        echo "},";
                    }
                }
                ?>
            ],
            eventClick: function(event) {
                if (event.url) {
                    $('#engagement').modal('toggle');
                    document.getElementById("engagement_name").value = event.title;
                    document.getElementById("progress").style.width = event.complete;
                    document.getElementById("assigned").value = event.assigned;
                    document.getElementById("progress").innerHTML = event.complete;
                    return false;
                }
            },
            droppable: false,
            drop: function(date, allDay) { // this function is called when something is dropped

                // retrieve the dropped element's stored Event Object
                var originalEventObject = $(this).data('eventObject');

                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);

                // assign it the date that was reported
                copiedEventObject.start = date;
                copiedEventObject.allDay = allDay;

                // render the event on the calendar
                // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }
            }
        });
    });
</script>

<div class="modal fade in" tabindex="-1" role="dialog" id="engagement">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Engagement Info</h3>
                <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body form">
                <div class="form-group">
                    <label>Engagement Name</label>
                    <input type="text" class="form-control" id="engagement_name" name="engagement" placeholder="Category Name" readonly>
                </div>
                <div class="form-group">
                    <label>Pentester Assigned</label>
                    <input type="text" class="form-control" id="assigned" name="assigned" placeholder="Pentester Name" readonly>
                </div>
                <div class="form-group">
                    <h5 style="font-weight: 600;margin-bottom: 7px;font-family: 'Open Sans', sans-serif;font-size: 12px;color: #555;">Status</h5>
                    <div class="progress-bar progress-bar-success" id="progress" style="width: 50%;"></div>
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
    var calendar;
    var Calendar = FullCalendar.Calendar;
    var events = [];
    $(function() {
        if (!!scheds) {
            Object.keys(scheds).map(k =>{
                var row = scheds[k]
                events.push({ 
                    id: row.id, 
                    title: row.services, 
                    date: row.date, 
                    status: row.status, 
                    color: row.color,
                    textColor: row.text_color
                });
            })
            
        }
        var date = new Date()
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()

        calendar = new Calendar(document.getElementById('calendar'), {
            headerToolbar: {
                left: 'prev,next,today',
                right: 'dayGridMonth,dayGridWeek,list',
                center: 'title',
            },
            selectable: true,
            themeSystem: 'bootstrap',
            //Random default events
            events: events,
            eventClick: function(info) {
                var _details = $('#event-details-modal')
                var _details1 = $('#approved-event-details-modal')
                var id = info.event.id
                if (!!scheds[id] && scheds[id].status==1) {
                    _details.find('#mod-service').text(scheds[id].services)
                    _details.find('#mod-datetime').text(scheds[id].sdate)
                    _details.find('#mod-status').text("Pending")
                    // _details.find('#mod-ss').text(scheds[id].status)
                    _details.find('#edit,#delete_doc').attr('data-id', id)
                    _details.find('#edit,#delete').attr('data-id', id)
                    _details.find('#mod-date_doc').text(scheds[id].date)
                    _details.find('#mod-time1').text(scheds[id].time1)
                    _details.find('#mod-time2').text(scheds[id].time2)
                    _details.modal('show')
                } 
                else if (!!scheds[id] && scheds[id].status==2) {
                    _details1.find('#mod-service').text(scheds[id].services)
                    _details1.find('#mod-datetime').text(scheds[id].sdate)
                    _details1.find('#mod-status').text("Approved")  
                    _details1.modal('show')
                }
                else if (!!scheds[id] && scheds[id].status==0) {
                    _details1.find('#mod-service').text(scheds[id].services)
                    _details1.find('#mod-datetime').text(scheds[id].sdate)
                    _details1.find('#mod-status').text("Rejected")
                    _details1.modal('show')
                }
                else if (!!scheds[id] && scheds[id].status==4) {
                    _details1.find('#mod-service').text(scheds[id].services)
                    _details1.find('#mod-datetime').text(scheds[id].sdate)
                    _details1.find('#mod-status').text("Rejected")
                    _details1.modal('show')
                }
                else {
                    alert("Event is undefined");
                }
                
            },
            eventDidMount: function(info) {
                // Do Something after events mounted
            },
            editable: true
        });

        calendar.render();

        // Form reset listener
        $('#schedule-form').on('reset', function() {
            $(this).find('input:hidden').val('')
            $(this).find('input:visible').first().focus()
        })

        // Edit Button
        $('#edit').click(function() {
            var id = $(this).attr('data-id')
            if (!!scheds[id]) {
                var _form = $('#schedule-form')
                // console.log(String(scheds[id].sdate), String(scheds[id].sdate).replace(" ", "\\t"))
                _form.find('[name="id"]').val(id)
                _form.find('[name="service"]').val(scheds[id].services)
                _form.find('[name="datetime"]').val(String(scheds[id].sdate).replace(" ", "T"))
                console.log(String(scheds[id].sdate).replace(" ", "T"))
                $('#event-details-modal').modal('hide')
                _form.find('[name="service"]').focus()
            } else {
                alert("Event is undefined");
            }
        })

        // Delete Button / Deleting an Event
        $('#delete').click(function() {
            var id = $(this).attr('data-id')
            if (!!scheds[id]) {
                var _conf = confirm("Are you sure to delete this scheduled event?");
                if (_conf === true) {
                    location.href = "././delete_schedule.php?id=" + id;
                }
            } else {
                alert("Event is undefined");
            }
        })
         // Delete Button / Deleting an Event Doctor
         $('#delete_doc').click(function() {
            var id = $(this).attr('data-id')
            if (!!scheds[id]) {
                var _conf = confirm("Are you sure to delete this scheduled event?");
                if (_conf === true) {
                    location.href = "././delete_schedule.php?id_doc=" + id;
                }
            } else {
                alert("Event is undefined");
            }
        })
    })
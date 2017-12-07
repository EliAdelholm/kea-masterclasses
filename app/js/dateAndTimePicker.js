
$( function() {
    $( "#datepicker" ).datepicker({
        firstDay: 1,
        dateFormat: 'd-M-yy'
    });
  });



 $('#timepicker').timepicker({
    timeFormat: 'HH:mm',
    interval: 60,
    defaultTime: '15',
    startTime: '3:00',
    dynamic: true,
    dropdown: true,
    scrollbar: true
});

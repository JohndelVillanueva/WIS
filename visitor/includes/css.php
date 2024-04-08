<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Westfields International School Portal - <?php echo pathinfo(strtoupper(basename($_SERVER['PHP_SELF'])), PATHINFO_FILENAME); ?></title>
    <link rel="shortcut icon" href="assets/images/logo/favicon.png">
    <link href="assets/css/app.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <script src="assets/js/index.global.min.js"></script>
    <script src="assets/vendors/jquery/dist/jquery.js"></script>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                initialDate: '<?php echo date('Y-m-d'); ?>',
                navLinks: true, // can click day/week names to navigate views
                businessHours: true, // display business hours
                editable: true,
                selectable: true,
                height:800,
                events: 'events.php',
            });

            calendar.render();
        });

    </script>
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.15/index.global.min.js'></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: @json($bookings),
                selectable: true,
                select: function(info) {
                    var title = prompt('Enter Booking Title:');
                    var instructor = prompt('Enter Instructor ID:'); // Replace with a proper dropdown
                    if (title && instructor) {
                        fetch("{{ route('bookings.store') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                title: title,
                                instructor_id: instructor,
                                start: info.startStr,
                                end: info.endStr
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                calendar.addEvent({
                                    title: title,
                                    start: info.startStr,
                                    end: info.endStr,
                                    instructor_id: instructor
                                });
                            } else {
                                alert('Failed to save booking.');
                            }
                        });
                    }
                    calendar.unselect();
                }
            });
            calendar.render();
        });
    </script>
</head>
<body>
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Booking Calendar</h1>
    <div id="calendar"></div>
</div>
</body>
</html>

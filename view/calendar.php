<div class="container">
    <form action="index.php" method="POST" class="form">
        <div class="row" style="margin-bottom: 1rem;">

            <div class="col-4">
                <input type='text' name='emailCalendar' class='form-control' placeholder='Select User Calendar'>
            </div>
            <div class="col-4">
                <select class="form-select" aria-label="Default select example" name="typeCalendar">
                    <option value="admin" selected>Admin</option>
                    <option value="alumn">Alumn</option>
                    <option value="teacher">Teacher</option>
                </select>

            </div>
            <div class="col-2">
                <button name="" value="insertClass" type="submit" class="btn btn-info">SUBMIT</button>
            </div>

        </div>

        <div class="row">
            <div class="col" id="calendar">
            </div>
        </div>

        <div class="row">
            <div class="col-12" id="assignment">

            </div>
        </div>

</div>


<script>
    'use-strict';

    class Assignment {
        constructor(id, teacher, subject, description, deadline) {
            this.id = id;
            this.teacher = teacher;
            this.subject = subject;
            this.description = description;
            this.deadline = new Date(deadline);
            this.targets = [];
        }

        addTarget(target) {
            this.targets.push(target);
        }
    }


    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    const days = ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"];
    var currDate = new Date();
    currDate.setHours(0, 0, 0, 0);
    var selectedDate = currDate;
    var isbreak = false;

    // DATA FROM THE DATABASE
    var assignments = [];
    <?php foreach ($_POST['calendarAssignments'] as $assignment) {
        echo "var assignment = new Assignment(" . $assignment->get_id() . ", '" . $assignment->get_teacher() . "', '" . $assignment->get_subject() . "', '" . $assignment->get_description() . "', '" . $assignment->get_deadline() . "');";
        foreach ($assignment->get_targets() as $target) {
            echo "assignment.addTarget('" . $target['alumn'] . "');";
        }
        echo "assignments.push(assignment);";
        echo "console.log(assignments);";
    } ?>;

    window.onload = generate_calendar();

    function generate_calendar() {
        var month = month_toArray((selectedDate.getMonth()), selectedDate.getFullYear());
        var nrows = Math.ceil(month.length / 7);


        var canlendarContainer = document.getElementById('calendar');
        var canlendar = "<div class='row'><div class='col month'><ul><li class='prev'><button onclick='previous_month()' class='btn'>&#10094;</button></li><li class='next'><button onclick='next_month()' class='btn'>&#10095;</button></li><li>" + months[selectedDate.getMonth()] + "<br><span style='font-size:18px'>" + selectedDate.getFullYear() + "</span></li></ul></div></div>";

        canlendar += "<div class='row weekdays'>";
        for (var i = 0; i < 7; i++) {
            canlendar += "<div class='col'>" + days[i] + "</div>";
        }
        canlendar += "</div>";

        canlendar += "<div class='container'>";
        for (var i = 0; i < nrows; i++) {
            canlendar += "<div class='row'>";
            for (var j = 0; j < 7; j++) {
                if (month[i * 7 + j] != undefined) {
                    for (var k = 0; k < assignments.length; k++) {
                        // console.log(assignments[k]);
                        // console.log(assignments[k].deadline.getDate() + '/' + assignments[k].deadline.getMonth() + ' == ' + month[i * 7 + j] + '/' + i);

                        if (assignments[k].deadline.getDate() == month[i * 7 + j] && assignments[k].deadline.getMonth() == selectedDate.getMonth() && assignments[k].deadline.getFullYear() == selectedDate.getFullYear()) {
                            if (month[i * 7 + j] == selectedDate.getDate()) {
                                canlendar += "<div class='col days_txt active' style='background: lightgreen; '><button onclick='select_date(this)' class='btn'>" + month[i * 7 + j] + "</button></div>";
                            } else {
                                canlendar += "<div class='col days_txt' style='background: lightgreen; '><button onclick='select_date(this)' class='btn'>" + month[i * 7 + j] + "</button></div>";
                            }
                            isbreak = true;
                        }
                    }
                    if (isbreak) {
                        isbreak = false;
                    } else {
                        if (month[i * 7 + j] == selectedDate.getDate()) {
                            canlendar += "<div class='col days_txt active'><button onclick='select_date(this)' class='btn'>" + month[i * 7 + j] + "</button></div>";
                        } else {
                            canlendar += "<div class='col days_txt'><button onclick='select_date(this)' class='btn'>" + month[i * 7 + j] + "</button></div>";
                        }
                    }
                } else {
                    canlendar += "<div class='col days_txt'>&nbsp</div>";
                }
            }
            canlendar += "</div>";
        }
        canlendar += "</div>";

        // console.log(canlendar);
        canlendarContainer.innerHTML = canlendar;
    }


    // UTILs
    function days_in_month(month, year) {
        return new Date(year, month + 1, 0).getDate();
    }

    function fst_month_day(month, year) {
        return new Date(year, month, 1).getDay();
    }

    function month_toArray(month, year) {
        var nDays = days_in_month(month, year);
        var fstDay = fst_month_day(month, year);
        var monthArr = [];
        for (var i = 0; i < fstDay; i++) {
            monthArr.push("&nbsp");
        }
        for (var i = 1; i <= nDays; i++) {
            monthArr.push(i);
        }
        return monthArr;
    }

    function select_date(button) {
        $alumnsStr = "";

        selectedDate.setDate(button.innerHTML);
        generate_calendar();

        for (var i = 0; i < assignments.length; i++) {
            if (assignments[i].deadline.getDate() == selectedDate.getDate() && assignments[i].deadline.getMonth() == selectedDate.getMonth() && assignments[i].deadline.getFullYear() == selectedDate.getFullYear()) {
                var assignment = document.getElementById('assignment');

                for (j = 0; j < assignments[i].targets.length; j++) {
                    $alumnsStr += assignments[i].targets[j] + "<br>";
                }

                assignment.innerHTML = '<table class="table table-bordered"> <thead><tr><th scope="col">id</th><th scope="col">teacher</th><th scope="col">alumns</th><th scope="col">subject</th><th scope="col">description</th><th scope="col">deadline</th></tr></thead><tbody><tr><td>' + assignments[i].id + '</td><td>' + assignments[i].teacher + '</td><td>' + $alumnsStr + '</td><td>' + assignments[i].subject + '</td><td>' + assignments[i].description + '</td><td>' + assignments[i].deadline.getDate() + ' ' + months[assignments[i].deadline.getMonth()] + ' ' + assignments[i].deadline.getFullYear() + '<br> AT:' + padTo2Digits(assignments[i].deadline.getHours()) + ':' + padTo2Digits(assignments[i].deadline.getMinutes()) + '</td></tr></tbody></table>';
                break;
            } else {
                // var assignment = document.getElementById('assignment');
                // assignment.innerHTML = "";
            }
        }
    }

    function previous_month() {
        selectedDate.setMonth(selectedDate.getMonth() - 1);
        generate_calendar();
    }

    function next_month() {
        selectedDate.setMonth(selectedDate.getMonth() + 1);
        generate_calendar();
    }

    function padTo2Digits(num) {
        return String(num).padStart(2, '0');
    }
</script>
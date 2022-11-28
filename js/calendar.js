'use-strict';

const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    const days = ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"];
    var currDate = new Date();
    currDate.setHours(0, 0, 0, 0);
    var selectedDate = currDate;

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
                    if (month[i * 7 + j] == selectedDate.getDate()) {
                        canlendar += "<div class='col days_txt active'><button onclick='select_date(this)' class='btn'>" + month[i * 7 + j] + "</button></div>";
                    } else {
                        canlendar += "<div class='col days_txt'><button onclick='select_date(this)' class='btn'>" + month[i * 7 + j] + "</button></div>";
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
        selectedDate.setDate(button.innerHTML);
        generate_calendar();
    }

    function previous_month() {
        selectedDate.setMonth(selectedDate.getMonth() - 1);
        generate_calendar();
    }

    function next_month() {
        selectedDate.setMonth(selectedDate.getMonth() + 1);
        generate_calendar();
    }

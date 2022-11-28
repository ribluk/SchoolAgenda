<div class="container">

    <table class="table table-bordered">
        <h1>Classes</h1>
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">classroom</th>
                <th scope="col">capacity</th>
                <th scope="col">alumns</th>
                <th scope="col">teachers</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($_POST['allClassRows'] as $row) {
                $alumnsStr = "";
                $teachersStr = "";


                for ($i = 0; $i < sizeof($row->get_alumns()); $i++) {
                    $alumnsStr .= $row->get_alumns()[$i]['alumn'] . "<br>";
                }

                for ($i = 0; $i < sizeof($row->get_teachers()); $i++) {
                    $teachersStr .= $row->get_teachers()[$i]['teacher'] . "(" .  $row->get_teachers()[$i]['subject'] . ')<br>';
                }

                echo "<tr>";
                echo "<td>" . $row->get_id() . "</td>";
                echo "<td>" . $row->get_classroom() . "</td>";
                echo "<td>" . $row->get_capacity() . "</td>";
                echo "<td>" . $alumnsStr . "</td>";
                echo "<td>" . $teachersStr . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <h3>Manage Classes</h3>
    <form action="index.php?controller=ctrlclasses&action=actionClass" method="POST" class="form">

        <div class="row">
            <div class="col" style="border: 0px;">
                Id: <input type='text' name='idInsertClass' class='form-control' placeholder='id'>
            </div>
            <div class="col" style="border:0px;">
                Classroom: <input type='text' name='classroomInsertClass' class='form-control' placeholder='classroom'>
            </div>
            <div class="col" style="border:0px;">
                Capacity: <input type='text' name='capacityInsertClass' class='form-control' placeholder='capacity'>
            </div>

            <div class="col" style="border:0px; align-self:end;">
                <button name="insertClass" value="insertClass" type="submit" class="btn btn-info" style="margin-top: 0.3rem;">INSERT</button>
                <button name="updateClass" value="updateClass" type="submit" class="btn btn-info" style="margin-top: 0.3rem;">UPDATE</button>
            </div>
        </div>

    </form>
    <br>

    <form action="index.php?controller=ctrlclasses&action=deleteClass" method="POST" class="form">
        <div class="row">
            <div class="col" style="border: 0px;">
                Id: <input type='text' name='idDeleteClass' class='form-control' placeholder='id'>
            </div>
            <div class="col" style="border:0px; align-self:end;">
                <button name="deleteClass" value="deleteClass" type="submit" class="btn btn-info">DELETE</button>
            </div>
        </div>
    </form>
</div>


<div class="container" style="margin-top: 2.5rem;">
    <h3>Manage Classes' Users</h3>
    <form action="index.php?controller=ctrlclasses&action=actionClassesUser" method="POST" class="form">

        <div class="row">
            <div class="col" style="border: 0px;">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="classesUserRadio" value="alumn" id="alumnRadio" onclick="showSubject()" checked>
                    <label class="form-check-label" for="alumnRadio">
                        Alumn
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="classesUserRadio" value="teacher" id="teacherRadio" onclick="showSubject()">
                    <label class="form-check-label" for="teacherRadio">
                        Teacher
                    </label>
                </div><br>
            </div>
        </div>

        <div class="row">
            <div class="col-4" style="border: 0px;">
                Email Address: <input type='text' name='emailClassesUser' class='form-control' placeholder='email'>
            </div>

            <div class="col-2" style="border: 0px;">
                Class: <input type='text' name='classTarget' class='form-control' placeholder='class'>
            </div>

            <div id="subjectS" class="col-4" style="display: none;"></div>

            <div class="col" style="border:0px; align-self:end;">
                <button name="insertClassesUser" value="insertClassesUser" type="submit" class="btn btn-info">INSERT</button>
                <button name="deleteClassesUser" value="deleteClassesUser" type="submit" class="btn btn-info">REMOVE</button>
            </div>
        </div>
    </form>
</div>

<script>
    function showSubject() {
        if (document.getElementById('teacherRadio').checked) {
            document.getElementById('subjectS').style.display = 'block';
            document.getElementById('subjectS').innerHTML = 'Subject: <input type="text" name="subjectInsertClassesUser" class="form-control" placeholder="subject">';
        } else {
            document.getElementById('subjectS').style.display = 'none';
        }
    }
</script>
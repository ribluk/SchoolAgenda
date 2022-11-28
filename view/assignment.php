<div class="container">

    <table class="table table-bordered">
        <h1>Assignments</h1>
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">teacher</th>
                <th scope="col">alumns</th>
                <th scope="col">subject</th>
                <th scope="col">description</th>
                <th scope="col">deadline</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($_POST['allAssignmentRows'] as $row) {
                $alumnsStr = "";

                for ($i = 0; $i < sizeof($row->get_targets()); $i++) {
                    $alumnsStr .= $row->get_targets()[$i]['alumn'] . "<br>";
                }

                echo "<tr>";
                echo "<td>" . $row->get_id() . "</td>";
                echo "<td>" . $row->get_teacher() . "</td>";
                echo "<td>" . $alumnsStr . "</td>";
                echo "<td>" . $row->get_subject() . "</td>";
                echo "<td>" . $row->get_description() . "</td>";
                echo "<td>" . $row->get_deadline() . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <form action="index.php?controller=ctrlassignments&action=actionAssignment" method="POST" class="form">
        <div class="row">
            <div class="col-2" style="border: 0px;">
                Id: <input type='number' name='idInsertAssignment' class='form-control' placeholder='id'>
            </div>
            <div class="col-3" style="border:0px;">
                Teacher: <input type='text' name='teacherInsertAssignment' class='form-control' placeholder='teacher'>
            </div>
            <div class="col" style="border:0px; align-self:end;">
                <select class="form-select" aria-label="Default select example" name="targetInsertAssignment">
                    <option selected>Target</option>
                    <?php
                    $targetAlumns = $_POST['targetsAlumns'];
                    $targetClasses = $_POST['targetsClasses'];

                    for ($i = 0; $i < sizeof($targetAlumns); $i++) {
                        echo "<option value=" . $targetAlumns[$i]['email'] . ">" . $targetAlumns[$i]['email'] . "</option>";
                    }

                    for ($i = 0; $i < sizeof($targetClasses); $i++) {
                        echo "<option value=" . $targetClasses[$i]['id'] . ">" . $targetClasses[$i]['id'] . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-4" style="border:0px;">
                Deadline: <input type='datetime-local' name='deadlineInsertAssignment' class='form-control' placeholder='deadline'>
            </div>


            <div class="col" style="border:0px; align-self:end;">
                <select class="form-select" aria-label="Default select example" name="subjectInsertAssignment">
                    <option selected>Subject</option>
                    <?php
                    for ($i = 0; $i < sizeof($_POST['subjectAssignment']); $i++) {
                        echo "<option value=" . $_POST['subjectAssignment'][$i]['subject'] . ">" . $_POST['subjectAssignment'][$i]['subject'] . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col" style="border: 0px;">
                Description: <input type='text' name='descriptionInsertAssignment' class='form-control' placeholder='description'>
            </div>
        </div>

        <button name="insertAssignment" value="insertAssignment" type="submit" class="btn btn-info" style="margin-top: 0.8rem;">INSERT</button>
        <button name="updateAssignment" value="updateAssignment" type="submit" class="btn btn-info" style="margin-top: 0.8rem;">UPDATE</button>
    </form>
    <br>


    <form action="index.php?controller=ctrlassignments&action=deleteAssignment" method="POST" class="form">
        <div class="row">
            <div class="row">
                <div class="col-2" style="border: 0px;">
                    Id: <input type='number' name='idDeleteAssignment' class='form-control' placeholder='id'>
                </div>
                <div class="col" style="border:0px; align-self:end;">
                    <button name="deleteAssignment" value="deleteAssignment" type="submit" class="btn btn-info">DELETE</button>
                </div>
            </div>
    </form>
</div>
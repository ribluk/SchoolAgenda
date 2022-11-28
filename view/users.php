<div class="container">

    <table class="table table-bordered">
        <h1>Users</h1>

        <thead>
            <tr>
                <th scope="col">email</th>
                <th scope="col">password</th>
                <th scope="col">name</th>
                <th scope="col">surname</th>
                <th scope="col">address</th>
                <th scope="col">dateOfBirth</th>
                <th scope="col">type</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($_POST['allUserRows'] as $row) {
                echo "<tr>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['password'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['surname'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>" . $row['dateob'] . "</td>";
                echo "<td>" . $row['type'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <form action="index.php?controller=ctrlusers&action=actionUser" method="POST" class="form">
        <div class="row">
            <div class="col" style="border: 0px;">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="userRadio" value="alumn" id="alumnRadio" checked>
                    <label class="form-check-label" for="alumnRadio">
                        Alumn
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="userRadio" value="teacher" id="teacherRadio">
                    <label class="form-check-label" for="teacherRadio">
                        Teacher
                    </label>
                </div><br>
            </div>
        </div>

        <div class="row">
            <div class="col" style="border: 0px;">
                Email Address: <input type='text' name='emailInsertUser' class='form-control' placeholder='email'>
            </div>
            <div class="col" style="border:0px;">
                Password: <input type='password' name='passwordInsertUser' class='form-control' placeholder='password'>
            </div>
        </div>

        <div class="row">
            <div class="col" style="border: 0px;">
                Name: <input type='text' name='nameInsertUser' class='form-control' placeholder='name'>
            </div>
            <div class="col" style="border: 0px;">
                Surname: <input type='text' name='surnameInsertUser' class='form-control' placeholder='surname'>
            </div>
        </div>

        <div class="row">
            <div class="col" style="border: 0px;">
                Address: <input type='text' name='addressInsertUser' class='form-control' placeholder='address'>
            </div>
            <div class="col" style="border: 0px;">
                Date of Birth: <input type='date' name='dateobInsertUser' class='form-control' placeholder='dateob'>
            </div>
        </div>

        <button name="insertUser" value="insertUser" type="submit" class="btn btn-info">INSERT</button>
        <button name="updateUser" value="updateUser" type="submit" class="btn btn-info">UPDATE</button>
    </form>
    <br>


    <form action="index.php?controller=ctrlusers&action=deleteUser" method="POST" class="form">
        <div class="row">
            <div class="col" style="border: 0px;">
                Email Address: <input type='text' name='emailDeleteUser' class='form-control' placeholder='email'>
            </div>
            <div class="col" style="border:0px; align-self:end;">
                <button name="deleteUser" value="deleteUser" type="submit" class="btn btn-info">DELETE</button>
            </div>
        </div>
    </form>
</div>
<?php
include_once 'classes/dbclass.php';
if (isset($_POST['btn-save'])) {
    $rfid = $_POST['rfid'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $position = $_POST['position'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $vacchist = $_POST['vacchist'];
    $photo = strtolower($_POST['lname'] . $_POST['fname'] . ".jpg");
    $isactive = 1;

    if ($crud->create($rfid, $fname, $mname, $lname, $position, $dob, $email, $mobile, $vacchist, $photo, $isactive)) {
        header("Location: add-data.php?inserted");
    } else {
        header("Location: add-data.php?failure");
    }
}
include_once 'header.php';
?>
    <div class="container py-3">
        <header>
            <div class="container">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">

                        <!-- Brand/logo -->
                        <div class="navbar-header">
                            <a class="navbar-brand" href="/">Westfields International School - Attendance System</a>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
                <h1 class="display-5 fw-normal">Add New Employee</h1>
                <?php
                if (isset($_GET['inserted'])) {
                    ?>
                    <div class="container">
                        <div class="alert alert-info">
                            <strong>YEAH!</strong> Record was inserted successfully!
                        </div>
                    </div>
                    <?php
                } else if (isset($_GET['failure'])) {
                    ?>
                    <div class="container">
                        <div class="alert alert-warning">
                            <strong>SORRY!</strong> ERROR while inserting record !
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="container">
                    <form method='post'>
                        <table class='table table-borderless'>
                            <tr>
                                <td>RFID</td>
                                <td><input type='text' name='rfid' class='form-control' required></td>
                            </tr>
                            <tr>
                                <td>First Name</td>
                                <td><input type='text' name='fname' class='form-control' required></td>
                            </tr>
                            <tr>
                                <td>Middle Name</td>
                                <td><input type='text' name='mname' class='form-control'></td>
                            </tr>
                            <tr>
                                <td>Last Name</td>
                                <td><input type='text' name='lname' class='form-control' required></td>
                            </tr>
                            <tr>
                                <td>Position</td>
                                <td><input type='text' name='position' class='form-control' required></td>
                            </tr>
                            <tr>
                                <td>Date of Birth</td>
                                <td>
                                    <div id="sandbox-container">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            <input type="text" name="dob" class="form-control">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><div class="input-group email" >
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-inbox"></i></span>
                                        <input type='email' name='email' class='form-control' required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Contact Number</td>
                                <td><input type='text' name='mobile' class='form-control' required></td>
                            </tr>
                            <tr>
                                <td>Vaccination</td>
                                <td><select name="vacchist" class="form-control" required>
                                        <option selected value="Fully Vaccinated">Fully Vaccinated</option>
                                        <option value="Partially Vaccinated">Partially Vaccinated</option>
                                        <option value="Unvaccinated">Unvaccinated</option>
                                        <option value="Anti-Vaxxer">Anti-Vaxxer</option>
                                    </select></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button type="submit" class="btn btn-primary" name="btn-save">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                        </svg> Create New Record
                                    </button>
                                    <a href="attendance.php" class="btn btn-large btn-success"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                                            <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
                                        </svg> &nbsp; Back to Home</a>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </header>
    </div>
<?php include_once 'footer.php'; ?>
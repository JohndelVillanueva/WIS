<?php
include_once "includes/config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
}
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

function configureMailer()
{
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = $_ENV['SMTP_HOST'];
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['SMTP_USERNAME'];
    $mail->Password = $_ENV['SMTP_PASSWORD'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $_ENV['SMTP_PORT'];

    return $mail;
}

function sendEmail($mail, $to, $subject, $body)
{
    $mail->setFrom('no-reply@westfields.edu.ph', 'Westfields International School');
    $mail->addAddress($to);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->send();
}

if (isset($_GET["asid"], $_GET["fname"], $_GET["mname"], $_GET["lname"], $_GET["email"])) {
    // Begin a transaction to ensure both inserts succeed or fail together
    $DB_con->beginTransaction();

    try {
        // Insert student details
        $addstudent = $DB_con->prepare("INSERT INTO afterschool_students (fname, mname, lname, email) VALUES (:fname, :mname, :lname, :email)");
        $addstudent->execute(array(
            ":fname" => $_GET["fname"],
            ":mname" => $_GET["mname"],
            ":lname" => $_GET["lname"],
            ":email" => $_GET["email"],
        ));

        // Retrieve last inserted ID directly from the PDO object
        $lastId = $DB_con->lastInsertId();

        // Insert into enrollment table
        $enrollstudent = $DB_con->prepare("INSERT INTO afterschool_enrolled (sid, asid, student_name, enrolldate) VALUES (:sid, :asid, :student_name, NOW())");
        $enrollstudent->execute(array(
            ":sid" => $lastId,
            ":asid" => $_GET["asid"],
            ":student_name" => $_GET["fname"] . " " . $_GET["lname"]
        ));

        // Commit the transaction
        $DB_con->commit();

        // Email Notification
        $mail = configureMailer();



        // Email to Student
        $studentEmail = $_GET["email"];
        $studentSubject = "Enrollment Confirmation";
        $studentBody = "
            <p>Dear Sir/Ma'am,</p>
            <p>Congratulations! Your child has been successfully enrolled in our afterschool program.</p>
            <p>Best regards,<br>Westfields International School</p>
        ";
        sendEmail($mail, $studentEmail, $studentSubject, $studentBody);

        // Load teacher's email from environment variables
        $teacherEmail = $_ENV['AFTERSCHOOL'];

        // Email to Teacher

        $teacherSubject = "New Student Enrolled";
        $teacherBody = "
            <p>Dear Teacher,</p>
            <p>A new student, {$_GET['fname']} {$_GET['lname']}, has been successfully enrolled in your program.</p>
            <p>Best regards,<br>Westfields International School</p>
        ";
        sendEmail($mail, $teacherEmail, $teacherSubject, $teacherBody);

        // Redirect to the specified page
        header("location: show-others.php?id=" . $_GET["asid"] . "&activity=" . $_GET["activity"]);
        exit();
    } catch (PDOException $e) {
        // Roll back the transaction if any query fails
        $DB_con->rollBack();
        echo "Database Error: " . $e->getMessage();
    } catch (Exception $e) {
        // Handle email sending errors
        echo "Email Error: " . $e->getMessage();
    }
} else {
    echo "Required data is missing.";
}





?>
<!DOCTYPE html>
<style>
    .modal-content {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        border-bottom: none;
        padding: 1.5rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        border-top: none;
        padding: 1.5rem;
    }

    .form-group label {
        margin-bottom: 0.5rem;
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-right: none;
    }

    .form-control {
        border-left: none;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #ced4da;
    }

    .input-group:focus-within .input-group-text,
    .input-group:focus-within .form-control {
        border-color: rgba(102, 51, 153, 0.5);
    }

    .required::after {
        content: " *";
        color: red;
    }

    .btn-primary {
        background-color: rgba(102, 51, 153, 0.9);
        border-color: rgba(102, 51, 153, 0.9);
    }

    .btn-primary:hover {
        background-color: rgba(102, 51, 153, 1);
        border-color: rgba(102, 51, 153, 1);
    }

    /* Animation for modal */
    .modal.fade .modal-dialog {
        transform: scale(0.8);
        transition: transform 0.3s ease-in-out;
    }

    .modal.show .modal-dialog {
        transform: scale(1);
    }

    body {
        background-image: url('assets/images/others/bg.jpg');
        /* You'll need to add your background image to this path */
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        background-repeat: no-repeat;
    }

    /* Add a semi-transparent overlay to improve content readability */
    .app {
        background-color: rgba(255, 255, 255, 0.9);
        min-height: 100vh;
    }

    /* Center buttons in the Actions column */
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 5px;
    }

    /* Make cards slightly transparent to show background */
    .card {
        background-color: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(5px);
        border: none;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    /* Style the card header */
    .card-header.bg-warning {
        background-color: rgba(255, 193, 7, 0.9) !important;
        border-bottom: none;
    }

    /* Style the table */
    .table {
        background-color: rgba(255, 255, 255, 0.95);
    }

    .thead-purple {
        background-color: rgba(102, 51, 153, 0.9);
        color: white;
    }

    /* Style the modals */
    .modal-content {
        background-color: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
    }

    .card-body p {
        margin-bottom: 10px;
        font-size: 14px;
        line-height: 1.5;
    }

    .alert-warning {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
        padding: 10px;
        font-size: 14px;
    }

    .back-button {
        position: fixed;
        top: 70px;
        /* Adjust vertical position */
        left: 20px;
        /* Adjust horizontal position */
        z-index: 1000;
        /* Ensure it appears above other elements */
        padding: 10px 20px;
        background-color: rgba(102, 51, 153, 0.9);
        /* Matches your theme color */
        color: white;
        border: none;
        text-decoration: none;
        border-radius: 5px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .back-button:hover {
        background-color: rgba(102, 51, 153, 1);
        /* Slightly darker on hover */
        text-decoration: none;
        color: white;
    }
</style>

<html lang="en">
<?php include_once "includes/css.php"; ?>

<head>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- DataTables Responsive CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">

    <!-- DataTables Responsive JS -->
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

</head>

<body>

    <div class="app is-folded">
        <div class="layout">
            <?php include_once "includes/heading.php"; ?>
            <?php include_once "includes/sidemenu.php"; ?>
            <div class="page-container">
                <div class="main-content">
                    <?php
                    $getactivity = $DB_con->prepare("SELECT * FROM afterschool_activities WHERE id = :id");
                    $getactivity->execute(array(":id" => $_GET["id"]));
                    $result = $getactivity->fetchAll();

                    foreach ($result as $row) {

                    ?>
                        <!-- form starts !-->
                        <div class="row flex-nowrap overflow-auto">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header bg-warning">
                                        <h3 class="pt-2"><span class="icon-holder"><i class="anticon anticon-calendar"></i></span> Enrolled Students - <?php echo $row['activity']; ?> - Coach <?php echo $row['coach']; ?></h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="dropdown float-right">
                                                    <a href="other-activities.php" class="btn btn-secondary back-button">
                                                        <i class="anticon anticon-arrow-left"></i> Back
                                                    </a>
                                                    <button class="btn btn-lg btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="icon-holder"><i class="anticon anticon-contacts"></i></span> Actions
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" type="button" data-toggle="modal" data-target="#addStudent">
                                                            <span class="icon-holder"><i class="anticon anticon-user-add"></i></span> Add Student
                                                        </a>
                                                        <a class="dropdown-item" href="other-attendance.php?id=<?php echo $_GET["id"]; ?>&activity=<?php echo $_GET["activity"]; ?>">
                                                            <span class="icon-holder"><i class="anticon anticon-usergroup-add"></i></span> Check Attendance
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row pt-2" >
                                            <div class="col-lg-12">
                                            <table id="listOfStudent" class="table table-hover table-bordered text-center">
                                                <thead class="thead-purple">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Last Name</th>
                                                        <th>First Name</th>
                                                        <th>Enroll Date</th>
                                                        <th>Sessions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $getstudents = $DB_con->prepare("SELECT * FROM afterschool_students AS a INNER JOIN afterschool_enrolled AS b ON a.id = b.sid WHERE b.asid = :asid");
                                                    $getstudents->execute(array(":asid" => $_GET["id"]));
                                                    $students = $getstudents->fetchAll();

                                                    if ($getstudents->rowCount() != 0) {
                                                        foreach ($students as $rec) {
                                                            $attendDate = !empty($rec["enrolldate"]) ? date("F j, Y", strtotime($rec["enrolldate"])) : "N/A";
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $rec["id"]; ?></td>
                                                                <td><?php echo $rec["lname"]; ?></td>
                                                                <td><?php echo $rec["fname"]; ?></td>
                                                                <td><?php echo $attendDate ?></td>
                                                                <td style="width: 8.33%">
                                                                    <?php
                                                                    $getsessions = $DB_con->prepare("SELECT * FROM afterschool_records WHERE sid = :sid AND asid = :asid");
                                                                    $getsessions->execute(array(":sid" => $rec["id"], ":asid" => $row["id"]));
                                                                    $sessions = $getsessions->fetchAll();
                                                                    ?>
                                                                    <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample<?php echo $rec["id"]; ?>" aria-expanded="false" aria-controls="collapseExample">
                                                                        <?php echo $getsessions->rowCount() . " / " . $row["max"]; ?> <span class="icon-holder"><i class="anticon anticon-caret-down"></i></span>
                                                                    </button>
                                                                    <div class="collapse" id="collapseExample<?php echo $rec['id']; ?>">
                                                                        <div class="card card-body">
                                                                            <?php if ($getsessions->rowCount() != 0) { ?>
                                                                                <?php foreach ($sessions as $srow) { ?>
                                                                                    <p>
                                                                                        <span class="fw-bold"><?php echo htmlspecialchars($srow['attend']); ?></span>
                                                                                        <?php echo htmlspecialchars($_SESSION['fname']); ?>
                                                                                        <span class="text-muted">(<?php echo htmlspecialchars($srow['payment_status']); ?>)</span>
                                                                                    </p>
                                                                                <?php } ?>
                                                                            <?php } else { ?>
                                                                                <div class="alert alert-warning" role="alert">
                                                                                    No Record
                                                                                </div>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="6">
                                                                <div class="alert alert-warning" role="alert">
                                                                    No Students Enrolled.
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- form ends !-->
                        <?php } ?>
                        </div>
                        <?php include_once "includes/footer.php"; ?>
                </div>
                <?php include_once "includes/scripts.php"; ?>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#listOfStudent').DataTable({
                "paging": true,
                "pageLength": 50, // Increase the number of rows per page
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ], // Add length menu options
                "searching": true,
                "ordering": true,
                "info": true,
                "responsive": true,
                "language": {
                    "lengthMenu": "Show _MENU_ entries",
                    "zeroRecords": "No matching records found",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "No entries available",
                    "infoFiltered": "(filtered from _MAX_ total entries)"
                }
            });
        });
        $(document).ready(function() {
            $('[data-toggle="popover"]').popover();
        });
    </script>

</body>
<div class="modal fade" id="addStudent" tabindex="-1" role="dialog" aria-labelledby="addStudentTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Add a purple header to match your theme -->
            <form id="studentEnrollForm" novalidate onsubmit="return validateForm();">
                <div class="modal-header bg-purple text-white" style="background-color: rgba(102, 51, 153, 0.9);">
                    <h5 class="modal-title d-flex align-items-center" id="addStudentTitle">
                        <span class="icon-holder mr-2">
                            <i class="anticon anticon-user-add"></i>
                        </span>
                        Add New Student
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Last Name Field -->
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="lname" class="font-weight-semibold required">
                                    Last Name
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="anticon anticon-user"></i>
                                        </span>
                                    </div>
                                    <input
                                        type="text"
                                        id="lname"
                                        name="lname"
                                        class="form-control"
                                        required
                                        pattern="[A-Za-z\s-']+"
                                        minlength="1"
                                        placeholder="Enter student's last name">
                                    <div class="invalid-feedback">
                                        Please enter a valid last name (minimum 2 characters)
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- First Name Field -->
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="fname" class="font-weight-semibold required">
                                    First Name
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="anticon anticon-user"></i>
                                        </span>
                                    </div>
                                    <input
                                        type="text"
                                        id="fname"
                                        name="fname"
                                        class="form-control"
                                        required
                                        pattern="[A-Za-z\s-']+"
                                        minlength="2"
                                        placeholder="Enter student's first name">
                                    <div class="invalid-feedback">
                                        Please enter a valid first name (minimum 2 characters)
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Middle Name Field -->
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="mname" class="font-weight-semibold">
                                    Middle Name
                                    <span class="text-muted">(Optional)</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="anticon anticon-user"></i>
                                        </span>
                                    </div>
                                    <input
                                        type="text"
                                        id="mname"
                                        name="mname"
                                        class="form-control"
                                        pattern="[A-Za-z\s-']*"
                                        placeholder="Enter student's middle name (optional)">
                                </div>
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="email" class="font-weight-semibold required">
                                    Email
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="anticon anticon-mail"></i>
                                        </span>
                                    </div>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        class="form-control"
                                        required
                                        pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
                                        placeholder="Enter student's email">
                                    <div class="invalid-feedback">
                                        Please enter a valid email address (e.g., student@example.com).
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="asid" value="<?php echo $_GET["id"]; ?>">
                        <input type="hidden" name="activity" value="<?php echo $_GET["activity"]; ?>">


                        <!-- Alert for validation messages -->
                        <div class="col-12">
                            <div class="alert alert-danger d-none" id="formErrors" role="alert">
                                Please correct the errors before submitting.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="anticon anticon-close mr-2"></i>
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="anticon anticon-user-add mr-2"></i>
                        Enroll Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</html>
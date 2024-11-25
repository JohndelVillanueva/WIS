<?php
include_once "includes/config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once "includes/css.php"; ?>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <style>
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
    </style>
</head>

<body>
    <div class="app is-folded">
        <div class="layout">
            <?php include_once "includes/heading.php"; ?>
            <?php include_once "includes/sidemenu.php"; ?>
            <div class="page-container">
                <div class="main-content">
                    <div class="row flex-nowrap overflow-auto">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header bg-warning">
                                    <h3 class="pt-2"><span class="icon-holder"><i class="anticon anticon-calendar"></i></span> Other Activities History</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="activitiesTable" class="table table-hover table-bordered text-center">
                                            <thead class="thead-purple text-center">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Student Name</th>
                                                    <th>Activity</th>
                                                    <th>Coach</th>
                                                    <th>Sessions</th>
                                                    <th>Payment</th>
                                                    <th>Attend</th>
                                                    <th>Processed By</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Prepare the SQL query
                                                try {
                                                    $getactivities = $DB_con->prepare("SELECT 
                                                        a.id, 
                                                        a.s_name, 
                                                        a.payment_status,
                                                        a.attend,
                                                        a.as_name, 
                                                        b.coach AS coach, 
                                                        b.max AS sessions, 
                                                        a.process_by 
                                                    FROM 
                                                        afterschool_records a 
                                                    LEFT JOIN 
                                                        afterschool_activities b 
                                                    ON 
                                                        a.as_name = b.activity
                                                ");
                                                    $getactivities->execute();
                                                    $result = $getactivities->fetchAll();
                                                } catch (PDOException $e) {
                                                    echo "Error: " . $e->getMessage();
                                                }

                                                // Loop through the results
                                                foreach ($result as $row) {
                                                    // Format the Attend date
                                                    $attendDate = !empty($row["attend"]) ? date("F j, Y", strtotime($row["attend"])) : "N/A";
                                                ?>
                                                    <tr>
                                                        <td><?= $row["id"]; ?></td>
                                                        <td><?= $row["s_name"]; ?></td>
                                                        <td><?= $row["as_name"]; ?></td>
                                                        <td><?= $row["coach"]; ?></td>
                                                        <td><?= $row["sessions"]; ?></td>
                                                        <td><?= $row["payment_status"]; ?></td>
                                                        <td><?= $attendDate; ?></td>
                                                        <td><?= $row["process_by"]; ?></td>
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
                </div>
                <?php include_once "includes/footer.php"; ?>
            </div>
        </div>
    </div>

    <!-- DataTables and Buttons JS -->
    <?php include_once "includes/scripts.php"; ?>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
    var table = $('#activitiesTable').DataTable({
        "pageLength": 50,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        dom: '<"top"if>rt<"bottom"lp><"clear"B>',
        buttons: [
            {
                extend: 'copy',
                className: 'btn btn-secondary'
            },
            {
                extend: 'excel',
                title: 'Other Activities History',
                filename: function() {
                    var d = new Date();
                    return 'Activities_Report-' + d.getFullYear() + '-' + 
                           ('0' + (d.getMonth() + 1)).slice(-2) + '-' + 
                           ('0' + d.getDate()).slice(-2);
                },
                className: 'btn btn-secondary'
            },
            {
                extend: 'pdf',
                title: 'Other Activities History',
                filename: function() {
                    var d = new Date();
                    return 'Activities_Report-' + d.getFullYear() + '-' + 
                           ('0' + (d.getMonth() + 1)).slice(-2) + '-' + 
                           ('0' + d.getDate()).slice(-2);
                },
                className: 'btn btn-secondary'
            },
            {
                extend: 'csv',
                title: 'Other Activities History',
                filename: function() {
                    var d = new Date();
                    return 'Activities_Report-' + d.getFullYear() + '-' + 
                           ('0' + (d.getMonth() + 1)).slice(-2) + '-' + 
                           ('0' + d.getDate()).slice(-2);
                },
                className: 'btn btn-secondary'
            },
            {
                extend: 'print',
                className: 'btn btn-secondary'
            }
        ]
    });
});
    </script>
</body>

</html>
</body>

</html>
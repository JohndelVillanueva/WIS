<!DOCTYPE html>
<html>
<head>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/bootstrap.min.js"></script>
         <title>Dashboard</title>
</head>
<body>
<?php
    require("includes.php");
?>

<div class="container-fluid vh-100 align-items-center justify-content-center "
     style="background-image: url('assets/images/background.jpg'); background-size: cover ; background-position: center" >
    <div class="row">

        <div class="container-fluid d-flex card mt-3 col-lg-9">
            <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <img src="assets/images/logo.png" style="width: 100px; text-align: left">
                            </div>
                            <div class="col-6 pt-3">
                                <a href="add.php" class="btn btn-lg btn-success float-end">Add</a>
                            </div>
                        </div>
            </div>

                <div class="card-body bg-white text-center text-white p-4">

                 <table class="table table-bordered table-hover">
            <thead>
            <tr>
            <th scope="col">ID</th>
            <th scope="col">NAME</th>
            <th scope="col">ADDRESS</th>
            <th scope="col">EMAIL</th>
            <th scope="col">REGION</th>
            <th scope="col">COUNTRY</th>
            <th scope="col">ACTION</th>
        </tr>
        </thead>
        <tbody>

            <?php
                $getdetails = $DB_con->prepare("SELECT * FROM ojt");
                $getdetails->execute();
                $data = $getdetails->fetchAll();

                foreach($data as $row) {
                    echo "<tr><td>".$row["id"]."</td>";
                    echo "<td>".$row["name"]."</td>";
                    echo "<td>".$row["address"]."</td>";
                    echo "<td>".$row["email"]."</td>";
                    echo "<td>".$row["region"]."</td>";
                    echo "<td>".$row["country"]."</td>";
                    echo "<td>
                            <a href='edit.php?id=".$row["id"]."' class='btn btn-primary'>Edit</a>
                            <a href='delete.php?id=".$row["id"]."' class='btn btn-danger'>Delete</a>
                        </td></tr>";
                }
            ?>

        </tbody>

    </table>
</div>
</div>
    </div>
</div>


</body>
</html>
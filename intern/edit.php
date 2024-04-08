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
    $getdetails = $DB_con->prepare("SELECT * FROM ojt WHERE id = :id");
    $getdetails->execute(array(":id"=>$_GET["id"]));
    $data = $getdetails->fetchAll();
foreach($data as $row) {
?>

<div class="container-fluid vh-100 align-items-center justify-content-center "
     style="background-image: url('pexels-ivo-rainha-1290141.jpg'); background-size: cover ; background-position: center" >
    <div class="row">

        <div class="container-fluid d-flex card mt-3 col-lg-9">
            <div class="card-header d-flex justify-content-end mt-2">
                <h3>Edit Record</h3>
            </div>

           <div class="card-body bg-white text-center text-white p-4">
                <form action="edit-process.php" method="post">
                    <input type="hidden" value="<?php echo $row["id"]; ?>" name="id">
                    <div class="row">
                        <div class="col-4"><input class="form-control" type="text" id="name" name="name" placeholder="Name" required value="<?php echo $row["name"]; ?>"></div>
                        <div class="col-4"><input class="form-control" type="text" id="address" name="address" placeholder="Address" required value="<?php echo $row["address"]; ?>"></div>
                        <div class="col-4"><input class="form-control" type="text" id="region" name="region" placeholder="Region" required value="<?php echo $row["region"]; ?>"></div>
                    </div>
                    <div class="row py-2">
                        <div class="col-3"><input class="form-control" type="text" id="country" name="country" placeholder="Country" required value="<?php echo $row["country"]; ?>"></div>
                        <div class="col-3"><input class="form-control" type="email" id="email" name="email" placeholder="E-Mail" required value="<?php echo $row["email"]; ?>"></div>
                        <div class="col-6"> <input class="form-control btn btn-primary w-100" type="submit" id="submit" name="submit" placeholder="Edit"></div>
                    </div>
                </form>
           </div>
        </div>
    </div>
</div>
<?php
}
?>

</body>
</html>
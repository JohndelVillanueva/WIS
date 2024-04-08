<?php
include 'index.php'
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.js"></script>
    <title>Document</title>
</head>

<body>
<?php
$insertQuery = $pdo->prepare('INSERT INTO ojt (name,)
                values ( :name,:date,:items,:quantity)');
$insertQuery->execute([":name"=>$_POST['name'], ":date"=>$_POST['date']]);
?>
<br><br><br>
<div class="container mx-auto vh-100 bg-light" style="width: 200px;">
    <form method="post">
        <label for="name">Name :</label>
        <input type="text" id="name" name="name"><br><br>
        <label for="date">Date :</label>
        <input type="date" id="date" name="date"><br><br>
        <label for="date">items :</label>
        <input type="text" id="items" name="items"><br><br>
        <label for="quantity">quantity :</label>
        <input type="number" id="quantity" name="quantity"><br><br>
        <button type="submit">
            create data
        </button>
        <button onclick="window.location.href='http://localhost/rose/index.php?';" class="GFG">BACK</button>
    </form>
</div>


</body>
</html>
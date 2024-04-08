<table border="1">
    <thead>
    <tr>
        <th>Name</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Postal Code</th>
        <th>Region</th>
        <th>Email</th>
    </tr>
    </thead>
    <tbody>
<?php

include "includes.php";

$stmt = $pdo->query('SELECT * FROM people');
while ($row = $stmt->fetch())
{
    ?>

            <tr>
                <td><?php echo $row['name'] ;?></td>
                <td><?php echo $row['phone'] ;?></td>
                <td><?php echo $row['address'] ;?></td>
                <td><?php echo $row['postalZip'] ;?></td>
                <td><?php echo $row['region'] ;?></td>
                <td><?php echo $row['email'] ;?></td>
            </tr>

    <?php
}
?>
    </tbody>
</table>

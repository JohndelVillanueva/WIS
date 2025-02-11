<?php
require_once("config/config.php");
session_start();

if (!isset($_SESSION['username'])) {
    header("location: index.php");
    exit;
}

$id = $_SESSION['username'];

if (isset($_GET['password_changed']) && $_GET['password_changed'] === 'success') {
    echo "<div id='successMessage' style='color: green; padding: 10px; border: 1px solid green; margin: 10px 0;'>
            Password changed successfully!
          </div>";
}

if (isset($_SESSION['success_message'])) {
    echo "<div id='successMessage' style='color: green; padding: 10px; border: 1px solid green; margin: 10px 0;'>
            " . $_SESSION['success_message'] . "
          </div>";
    unset($_SESSION['success_message']);
}

include_once("headers.php");

?>


<body>
<div class="wrapper">
<?php include_once ("sidemenu.php");?>
    <div class="main">
        <?php include_once ("topbar.php");?>
<!-- CONTENT STARTS HERE !-->
        <main class="content">
            <div class="container-fluid p-0">

                <h1 class="h3 mb-3 wisfontorange">Dashboard</h1>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">Real Time Transaction</div>
                            <div class="card-body">
                                <table class="display table table-striped" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Reference Code</th>
                                        <th>Price & Product</th>
                                        <th>Quantity</th>
                                        <th>Credit</th>
                                        <th>Debit</th>
                                        <th>Transaction Date</th>
                                        <th>Processed By</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        // Prepare the SQL query with aliases for better readability
                                        $sql = "
                                            SELECT 
                                                w.*, 
                                                u.fname AS fname, 
                                                u.lname AS lname 
                                            FROM 
                                                wispay w
                                            INNER JOIN 
                                                user u 
                                            ON 
                                                w.rfid = u.rfid  
                                            ORDER BY 
                                                w.id DESC 
                                            LIMIT 50
                                        ";

                                        $pdo_statement = $DB_con->prepare($sql);
                                        $pdo_statement->execute();
                                        $result = $pdo_statement->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($result as $row) {
                                            // Format the date using a ternary operator
                                            $mysqldate = ($row['transdate'] != "0000-00-00 00:00:00") 
                                                ? date('M d, Y H:i:s A', strtotime($row['transdate'])) 
                                                : "Carry Over from 2022-2023";
                                            ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row['fname'] . " " . $row['lname'] . " (" . $row['rfid'] . ")"); ?></td>
                                                <td><?php echo htmlspecialchars($row['refcode']); ?></td>
                                                <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                                <td><span class="text-success"><?php echo $row['credit'] == 0 ? "" : htmlspecialchars($row['credit']); ?></span></td>
                                                <td><span class="text-danger"><?php echo $row['debit'] == 0 ? "" : htmlspecialchars($row['debit']); ?></span></td>
                                                <td><?php echo htmlspecialchars($mysqldate); ?></td>
                                                <td><?php echo htmlspecialchars($row['processedby']); ?></td>
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
        </main>
<!-- CONTENT ENDS HERE !-->
        <?php include_once ("footer.php");?>
    </div>
</div>
<script>
    // Function to get query parameters from the URL
    function getQueryParam(param) {
        try {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        } catch (error) {
            console.error('Error retrieving query parameter:', error);
            return null;
        }
    }

    // Function to display a message to the user
    function displayMessage(message) {
        if (message) {
            alert(decodeURIComponent(message));

            // Optionally, remove the query parameter from the URL to prevent the message from being shown again on reload
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    }

    // Function to hide an element after a specified delay
    function hideElementAfterDelay(elementId, delay) {
        const element = document.getElementById(elementId);
        if (element) {
            setTimeout(() => {
                element.style.display = 'none';
            }, delay);
        }
    }

    // Main function to handle the logic when the DOM is fully loaded
    document.addEventListener("DOMContentLoaded", function() {
        const message = getQueryParam('message');
        displayMessage(message);

        // Hide success message after 5 seconds
        hideElementAfterDelay('successMessage', 5000); // 5000 milliseconds = 5 seconds
    });
</script>

<?php include_once ("scripts.php");?>
</body>

</html>
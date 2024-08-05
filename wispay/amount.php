<?php
require_once("config/config.php");
session_start();

if (!isset($_SESSION["username"])) {
    header("location: index.php");
}

if (empty($_POST['rfid'])) {
    header("location: pay.php?error=1");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WISPay - Pay</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/custom.css">
    <style>
        .add-button,
        .remove-button {
            display: inline-block;
            margin-top: 10px;
            padding: 10px;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
            line-height: 18px;
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
        }

        .add-button {
            background-color: #4CAF50;
        }

        .remove-button {
            background-color: #f44336;
        }

        .add-button:hover,
        .remove-button:hover {
            opacity: 0.8;
        }

        .input-group {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .input-group input {
            margin-right: 10px;
            flex: 1;
        }

        .icon {
            font-size: 16px;
        }
    </style>
</head>

<body class="login">

    <div class="main">

        <form action="processpay.php" method="post">
            <section class="sign-in">
                <div class="container">
                    <div class="signin-content">
                        <div class="signin-image">
                            <figure><img src="images/pay-logo.png" alt="sign up image"></figure>
                        </div>

                        <div class="signin-form">
                            <h2 class="form-title wisfont">Enter Amount</h2>
                            <form method="POST" class="register-form" id="login-form">
                                <h3 class="form-title wisfont">Scanned RFID :
                                    <span style="color:red">
                                        <?php
                                        $pdo_statement = $DB_con->prepare("SELECT * FROM user WHERE rfid=?");
                                        $pdo_statement->execute([$_POST['rfid']]);
                                        $result = $pdo_statement->fetch();
                                        echo $result['fname'] . " " . $result['lname'] . " ";
                                        $balanceQuery = $DB_con->prepare("SELECT sum(credit)-sum(debit) as ctot FROM wispay WHERE rfid = :rfid");
                                        $balanceQuery->execute([':rfid' => $_POST['rfid']]);
                                        $remainingBalance = $balanceQuery->fetch(PDO::FETCH_ASSOC);
                                        // var_dump($remainingBalance);
                                        // die();
                                        ?>
                                    </span>
                                </h3>
                                <div class="form-group" id="dynamic-inputs">
                                    <div class="input-group">
                                        <?php 
                                            $getProductsQuery = $DB_con->prepare("SELECT * FROM type_of_products");
                                            $getProductsQuery->execute();
                                            $products = $getProductsQuery->fetchAll(PDO::FETCH_OBJ);
                                        ?>
                                        <select class="wisfont" name="product[]" id="product" required>
                                            <option value="" disabled selected>Select a product</option>
                                            <?php foreach($products as $product): ?>
                                                <option value="<?= $product->id ?>"><?= $product->name ?></option>
                                            <?php endforeach; ?>
                                            <!-- Add more options as needed -->
                                        </select>
                                        <input class="wisfont" type="text" name="amount[]" id="amount" placeholder="Amount" required />
                                        <button type="button" class="remove-button"><i class="fas fa-minus icon"></i></button>
                                    </div>
                                </div>

                                <button type="button" class="add-button"><i class="fas fa-plus icon"></i></button>
                                <input class="wisfont" type="hidden" name="rfid" id="rfid" placeholder="RFID" value="<?php echo $_POST['rfid']; ?>" />
                                <div class="form-group">
                                    <label for="total-amount">Total Amount: </label><br>
                                    <span id="total-amount">0</span>
                                </div>
                                <div class="form-group form-button">
                                    <input type="submit" name="submit" id="submit" class="form-submit wisfont" value="Pay" />
                                </div>
                            </form>
                            <?php
                            if (isset($_GET['error'])) {
                                switch ($_GET['error']) {
                                    case 1:
                                        echo "
                                            <h1 class=\"alert alert-warning\">Empty Amount!</h1>
                                        ";
                                        break;
                                }
                            }

                            ?>
                            <div class="social-login">
                                <a class="social-label"><a href="dashboard.php"><i class="align-middle" data-feather="trello"></i> DASHBOARD</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </div>

    <!-- JS -->
    <script src="vendor/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        function updateTotalAmount() {
            let total = 0;
            $('input[name="amount[]"]').each(function() {
                let amount = parseFloat($(this).val());
                if (!isNaN(amount)) {
                    total += amount;
                }
            });
            $('#total-amount').text(total.toFixed(2));
        }

        $(document).ready(function() {
            $(document).on('click', '.add-button', function() {
                var html = '';
                html += '<div class="input-group">';
                html += '<input class="wisfont" type="text" name="product[]" id="product" placeholder="Product" autofocus required/>';
                html += '<input class="wisfont" type="text" name="amount[]" id="amount" placeholder="Amount" required/>';
                html += '<button type="button" class="remove-button"><i class="fas fa-minus icon"></i></button>';
                html += '</div>';
                $('#dynamic-inputs').append(html);
            });

            $(document).on('click', '.remove-button', function() {
                $(this).closest('.input-group').remove();
                updateTotalAmount();
            });

            $(document).on('input', 'input[name="amount[]"]', function() {
                updateTotalAmount();
            });

            updateTotalAmount(); // Initial call to set total amount when the page loads
        });
    </script>
</body>

</html>
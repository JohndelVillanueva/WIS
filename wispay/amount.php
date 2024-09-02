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
        .add-button {
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

        .input-group select,
        .input-group input {
            margin-right: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .input-group select:focus,
        .input-group input:focus {
            outline: none;
            border-color: #4CAF50;
        }

        .icon {
            font-size: 16px;
        }

        .form-title {
            margin-bottom: 20px;
        }

        #total-amount {
            font-weight: bold;
            font-size: 20px;
        }

        .input-group select[name="type[]"] {
            width: 150px;
        }

        .input-group select[name="product[]"] {
            width: 130px;
        }

        .input-group input[name="qty[]"] {
            width: 50px;
        }
        .add-button {
        background-color: purple; /* Background color of the button */
        border: none; /* Remove border */
        padding: 10px; /* Adjust padding as needed */
        border-radius: 5px; /* Optional: rounded corners */
        float: right;
        }

        .add-button .icon {
        color: black; /* Color of the plus sign */
        font-size: 16px; /* Adjust the size of the icon */
        }
        .form-title {
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Adjust shadow properties as needed */
        }
    </style>
</head>

<body class="login">

    <div class="main">

        <form action="processpay.php" method="post">
            <section class="sign-in">
                <div class="container">
                    <div class="signin-content">
                        <div class="signin-image" style="border:slategrey">
                            <figure><img src="images/pay-logo.png" alt="sign up image" style="margin-left: -80px; padding-top: 100px;"></figure>
                        </div>
                        
                        <div class="signin-form" style="margin-left: -20px;">
                            <h2 class="form-title wisfont">Enter Amount</h2>
                            <form method="POST" class="register-form" id="login-form">
                                <h3 class="form-title wisfont">Scanned RFID :
                                    <span style="color:red">
                                        <?php
                                            $pdo_statement = $DB_con->prepare("SELECT * FROM user WHERE rfid=?");
                                            $pdo_statement->execute([$_POST['rfid']]);
                                            $result = $pdo_statement->fetch();

                                            if ($result) {
                                                echo $result['fname'] . " " . $result['lname'] . " ";

                                                $balanceQuery = $DB_con->prepare("SELECT sum(credit)-sum(debit) as ctot FROM wispay WHERE rfid = :rfid");
                                                $balanceQuery->execute([':rfid' => $_POST['rfid']]);
                                                $remainingBalance = $balanceQuery->fetch(PDO::FETCH_ASSOC);

                                                echo "<p style='color:black;'>Remaining Balance: <span style='color: red;'>" . ($remainingBalance['ctot'] !== null ? htmlspecialchars($remainingBalance['ctot']) : '0') . "</span></p>";
                                            } else {
                                                echo "No user found.";
                                            }
                                        ?>
                                    </span><button type="button" class="add-button"><i class=" fa-plus "></i></button><br><br>
                                </h3>
                                <div class="form-group" id="dynamic-inputs">
                                    <div class="input-group">
                                        <?php
                                        $getTypesQuery = $DB_con->prepare("SELECT DISTINCT(type_of_product) as type FROM products");
                                        $getTypesQuery->execute();
                                        $types = $getTypesQuery->fetchAll(PDO::FETCH_OBJ);
                                        ?>
                                        <select class="wisfont" name="type[]" id="type" required>
                                            <option value="" disabled selected>Type</option>
                                            <?php foreach ($types as $type) : ?>
                                                <option value="<?= htmlspecialchars($type->type) ?>"><?= htmlspecialchars($type->type) ?></option>
                                            <?php endforeach; ?>
                                        </select>

                                        <select class="wisfont" name="product[]" id="product" required>
                                            <option value="" disabled selected>Products</option>
                                        </select>

                                        <input class="wisfont" type="hidden" name="amount[]" id="amount" placeholder="Amount" required />
                                        <input class="wisfont" type="number" name="qty[]" id="qty" placeholder="qty" required />
                                    </div>
                                </div>

                                <input class="wisfont" type="hidden" name="rfid" id="rfid" placeholder="RFID" value="<?php echo $_POST['rfid']; ?>" />
                                <div class="form-group">
                                    <label for="total-amount">Total Amount: </label><br><br>
                                    <span id="total-amount">0</span>
                                </div>
                                <div class="form-group form-button">
                                    <input type="submit" name="submit" id="submit" class="form-submit wisfont" onclick="return confirm('Check the product and the quantity. Do you want to proceed?')" value="Pay"  />
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
        $('.input-group').each(function() {
            let price = parseFloat($(this).find('select[name="product[]"]').val()) || 0;
            let qty = parseInt($(this).find('input[name="qty[]"]').val()) || 0;
            let amount = price * qty;
            $(this).find('input[name="amount[]"]').val(amount.toFixed(2));
            total += amount;
        });
        $('#total-amount').text(total.toFixed(2));
    }

    $(document).ready(function() {
        $(document).on('click', '.add-button', function() {
            var typeOptions = $('#type').html();
            var html = '<div class="input-group">' +
                '<select class="wisfont" name="type[]" required>' + typeOptions + '</select>' +
                '<select class="wisfont" name="product[]" required>' +
                '<option value="" disabled selected>Products</option>' +
                '</select>' +
                '<input class="wisfont" type="hidden" name="amount[]" placeholder="Amount" required />' +
                '<input class="wisfont" type="number" name="qty[]" placeholder="qty" required />' +
                '</div>';
            $('#dynamic-inputs').append(html);
        });

        $(document).on('change', 'select[name="type[]"]', function() {
            var selectType = this.value;
            var productSelect = $(this).closest('.input-group').find('select[name="product[]"]');

            // Clear previous products
            productSelect.html('<option value="" disabled selected>Products</option>');

            fetch('productProcess/fetch_product.php?type=' + encodeURIComponent(selectType))
                .then(response => response.json())
                .then(products => {
                    products.forEach(product => {
                        var option = $('<option></option>');
                        option.val(product.price_of_product + " - " + product.name_of_product);
                        option.text(product.name_of_product);
                        productSelect.append(option);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });

        $(document).on('change', 'select[name="product[]"], input[name="qty[]"]', function() {
            updateTotalAmount();
        });

        updateTotalAmount(); // Initial call to set total amount when the page loads
    });
</script>
</body>

</html>

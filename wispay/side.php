<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Css -->
    <link rel="stylesheet" href="css/side.css">
    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Document</title>
</head>
<body>
    <!-- Sidebar -->
     <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="images/wispay-logo.png" alt="">
                </span>

                <div class="text header-text">
                    <span class="name">Westfields</span>
                    <span class="profession">International School</span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                    <li class="search-box">
                        <i class='bx bx-search icon' ></i>
                        <input type="search" placeholder="Search...">
                    </li>
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="index.php">
                            <i class='bx bx-home-alt icon'></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="pay.php">
                            <i class='bx bx-dollar icon'></i>
                            <span class="text nav-text">Payment</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="product_list.php">
                            <i class='bx bx-food-menu icon'></i>
                            <span class="text nav-text">Products</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="report.php">
                            <i class='bx bx-memory-card icon'></i>
                            <span class="text nav-text">Reports</span>
                        </a>
                    </li>
                    <?php 
                    if ($_SESSION['level'] == 3 or $_SESSION['level'] == 9) {
                        ?>
                            <li class="nav-link">
                                <a href="users.php">
                                    <i class='bx bx-user icon'></i>
                                    <span class="text nav-text">Students</span>
                                </a>
                            </li>
                            
                            <li class="nav-link">
                                <a href="employees.php">
                                    <i class='bx bx-user-check icon'></i>
                                    <span class="text nav-text">Employees</span>
                                </a>
                            </li>
                        <?php 
                        }
                    ?>
                </ul>
            </div>
            <div class="bottom-content">
                <li class="nav-link">
                    <a href="logout.php">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>
                <li class="mode">
                    <div class="moon-sun">
                        <i class='bx bx-moon icon moon'></i>
                        <i class='bx bx-sun icon sun'></i>
                    </div>
                    <span class="mode-text text">Dark Mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
            </div>
        </div>
     </nav>

     <!-- <section class="home">
        <div class="text">
            Dashboard
        </div>
     </section> -->

     <script src="js/side.js"></script>
</body>
</html>

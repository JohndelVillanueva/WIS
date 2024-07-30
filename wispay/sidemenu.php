
<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.php">
            <img src="images/avatar.png" style="max-width: 60px !important;margin-top: -10px;" alt="WIS Logo"> <span class="align-middle wisfont">WISPay</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Modules
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="index.php">
                    <i class="align-middle" data-feather="trello"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="pay.php">
                    <i class="align-middle" data-feather="dollar-sign"></i> <span class="align-middle">WISPay</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="report.php">
                    <i class="align-middle" data-feather="table"></i> <span class="align-middle">Reports</span>
                </a>
            </li>
            <?php 
            if ($_SESSION['level'] == 3 or $_SESSION['level'] == 9) {
                ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="users.php">
                            <i class="align-middle" data-feather="user"></i> <span class="align-middle">Students</span>
                        </a>
                    </li>
                    
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="employees.php">
                            <i class="align-middle" data-feather="users"></i> <span class="align-middle">Employees</span>
                        </a>
                    </li>
                <?php 
                }
            ?>
            <li class="sidebar-item">
                <a class="sidebar-link" href="logout.php">
                    <i class="align-middle" data-feather="log-out"></i> <span class="align-middle">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
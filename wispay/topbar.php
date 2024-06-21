<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>

                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <img src="images/people/<?php echo $_SESSION['photo']; ?>" class="avatar img-fluid rounded me-1" alt="<?php echo $_SESSION['fname']." ".$_SESSION['lname']; ?>" /> <span class="text-dark"><?php echo $_SESSION['fname']." ".$_SESSION['lname']; ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="logout.php"><i class="align-middle" data-feather="log-out"></i> Log out</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
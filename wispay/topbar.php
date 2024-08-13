<style>
  .circle-img {
    width: 60px; /* Adjust the size as needed */
    height: 60px; /* Adjust the size as needed */
    border-radius: 50%;
    object-fit: cover; /* Ensures the image covers the area while maintaining aspect ratio */
  }
</style>

<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>
    <div>
        <b><h3>WESTFIELDS INTERNATIONAL SCHOOL</h3></b>
    </div>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>

                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                <img src="images/people/<?php echo $_SESSION['photo']; ?>.jpg" class="circle-img me-1" alt="<?php echo $_SESSION['fname'] . ' ' . $_SESSION['lname']; ?>" />

                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="logout.php"><i class="align-middle" data-feather="log-out"></i> Log out</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
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
            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                <i class="align-middle" data-feather="key"></i> Change Password
            </a>
            <a class="dropdown-item" href="logout.php"><i class="align-middle" data-feather="log-out"></i> Log out</a>
            </div>
        </li>
    </ul>
</div>
</nav>
<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm" action="change_password.php" method="POST">
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

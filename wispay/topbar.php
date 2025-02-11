<!-- Change Password Modal -->
<?php 
    include_once './modal/changePassword.php';
?>
<style>
  .circle-img {
    width: 60px; /* Adjust the size as needed */
    height: 60px; /* Adjust the size as needed */
    border-radius: 50%;
    object-fit: cover; /* Ensures the image covers the area while maintaining aspect ratio */
  }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


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


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePasswordButtons = document.querySelectorAll('.toggle-password');
        const saveChangesButton = document.getElementById('saveChanges');
        const currentPasswordError = document.getElementById('currentPasswordError');

        // Toggle password visibility
        togglePasswordButtons.forEach(button => {
            button.addEventListener('click', function () {
                const input = this.previousElementSibling;
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye-slash');a
                    icon.classList.add('bi-eye');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                }
            });
        }); // <-- This parenthesis was missing
    });
</script>

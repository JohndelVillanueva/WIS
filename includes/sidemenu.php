<div class="side-nav">
    <div class="side-nav-inner">
        <ul class="side-nav-menu scrollable">
            <?php
            if ($_SESSION['level'] == 1 or $_SESSION['level'] == 2) {
            ?>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="teacher.php">
                        <span class="icon-holder">
                            <i class="anticon anticon-dashboard"></i>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
            <?php }
            if ($_SESSION['level'] >= 2 AND $_SESSION["level"] != 8) {
            ?>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="dashboard.php">
                        <span class="icon-holder">
                            <i class="anticon anticon-dashboard"></i>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="application.php">
                        <span class="icon-holder">
                            <i class="anticon anticon-contacts"></i>
                        </span>
                        <span class="title">Application</span>
                    </a>
                </li>
            <?php
            }
            if ($_SESSION['level'] == 4 or $_SESSION['level'] == 9) {
            ?>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="registrardocs.php">
                        <span class="icon-holder">
                            <i class="anticon anticon-container"></i>
                        </span>
                        <span class="title">Verification</span>
                    </a>
                </li>
            <?php
            }
            if ($_SESSION['level'] == 3 or $_SESSION['level'] == 9) {
                ?>
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="cashier.php">
                            <span class="icon-holder">
                                <i class="anticon anticon-exception"></i>
                            </span>
                            <span class="title">Application Fee</span>
                        </a>
                    </li>
                <?php
                }



            if ($_SESSION['level'] == 5 or $_SESSION['level'] == 9) {
            ?>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="admissions.php">
                        <span class="icon-holder">
                            <i class="anticon anticon-bank"></i>
                        </span>
                        <span class="title">Guidance</span>
                    </a>
                </li>
            <?php
            }

            if ($_SESSION['level'] == 5 or $_SESSION['level'] == 9 or $_SESSION['level'] == 2) {
            ?>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="guidance.php">
                        <span class="icon-holder">
                            <i class="anticon anticon-reconciliation"></i>
                        </span>
                        <span class="title">Examination</span>
                    </a>
                </li>
            <?php
            }

            if ($_SESSION['level'] == 6 or $_SESSION['level'] == 9 or $_SESSION['level'] == 2) {
            ?>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="interview.php">
                        <span class="icon-holder">
                            <i class="anticon anticon-wechat"></i>
                        </span>
                        <span class="title">Interview</span>
                    </a>
                </li>
            <?php
            }

            if ($_SESSION['level'] == 4 or $_SESSION['level'] == 9) {
            ?>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="registrar.php">
                        <span class="icon-holder">
                            <i class="anticon anticon-profile"></i>
                        </span>
                        <span class="title">Registrar</span>
                    </a>
                </li>
            <?php
            }
            if ($_SESSION['level'] == 3 or $_SESSION['level'] == 9) {
            ?>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="payment.php">
                        <span class="icon-holder">
                            <i class="anticon anticon-dollar "></i>
                        </span>
                        <span class="title">Cashier</span>
                    </a>
                </li>
            <?php
            }
            if ($_SESSION['level'] == 4 or $_SESSION['level'] == 9) {
                ?>
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="registrar2.php">
                            <span class="icon-holder">
                                <i class="bi bi-file-person-fill"></i>
                            </span>
                            <span class="title">Completion</span>
                        </a>
                    </li>
                <?php
                }
            
            ?>
                <?php
            if ($_SESSION['level'] == 0) {
            ?>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="student.php">
                        <span class="icon-holder">
                            <i class="anticon anticon-dashboard"></i>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
            <?php
            }

            if ($_SESSION['level'] == 9) {
            ?>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="inventory.php">
                        <span class="icon-holder">
                            <i class="anticon anticon-unordered-list"></i>
                        </span>
                        <span class="title">Inventory</span>
                    </a>
                </li>
            <?php
            }

            if ($_SESSION['level'] == 3 or $_SESSION['level'] == 9) {
                ?>

                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="show-uniform-inventory.php">
                    <span class="icon-holder">
                        <i class="anticon anticon-tags"></i>
                    </span>
                        <span class="title">Uniforms</span>
                    </a>
                </li>
                <?php
            }
            if ($_SESSION['level'] == 8 OR $_SESSION['level'] == 9) {
                ?>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="clinic.php">
                        <span class="icon-holder">
                            <i class="anticon anticon-plus-square"></i>
                        </span>
                        <span class="title">Clinic</span>
                    </a>
                </li>
                <?php
            }
            ?>
            <?php
            if ($_SESSION['level'] == 8 OR $_SESSION['level'] == 9) {
                ?>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="student_health.php">
                        <span class="icon-holder">
                            <i class="anticon anticon-plus-square"></i>
                        </span>
                        <span class="title">Health</span>
                    </a>
                </li>
                <?php
            }
            ?>
            <?php
            if ($_SESSION['level'] == 5 OR $_SESSION['level'] == 9) {
                ?>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="houses.php">
                        <span class="icon-holder">
                        <i class="bi bi-house-gear"></i>
                        </span>
                        <span class="title">Houses</span>
                    </a>
                </li>
                <?php
            }
            ?>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder">
                        <i class="anticon anticon-star"></i>
                    </span>
                    <span class="title">Recommendations</span>
                    <span class="arrow">
                        <i class="arrow-icon"></i>
                    </span>
                </a>
                <ul class="dropdown-menu" style="display: none;">
                    <li>
                        <a href="star-program.php">Star Program</a>
                    </li>
                    <li>
                        <a href="esl-program.php">ESL Program</a>
                    </li>
                    <li>
                        <a href="completion.php">Completion</a>
                    </li>

                </ul>
            </li>
            <?php
            if ($_SESSION['level'] == 4 or $_SESSION['level'] == 9) {
            ?>
            <li class="nav-item dropdown ">
                <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder">
                        <i class="bi bi-person-fill"></i>
                    </span>
                    <span class="title">Students</span>
                    <span class="arrow">
                        <i class="arrow-icon"></i>
                    </span>
                </a>
                <ul class="dropdown-menu" style="display: none;">
                    <li>
                        <a href="student_verification.php">Grades</a>
                    </li>
                    <li>
                        <a href="completed.php">Enrolled</a>
                    </li>

                </ul>
            </li>
            <?php 
            }
            ?>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder">
                        <i class="anticon anticon-form"></i>
                    </span>
                    <span class="title">Other</span>
                    <span class="arrow">
                        <i class="arrow-icon"></i>
                    </span>
                </a>
                <ul class="dropdown-menu" style="display: none;">
                    <li>
                        <a href="assignsubj.php">Subjects</a>
                    </li>
                    <li>
                        <a href="classes.php">Grade Levels</a>
                    </li>
                    <li>
                        <a href="update-rfid.php">Update Rfid</a>
                    </li>
                    <li>
                        <a href="changePassword.php">Change Password </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="logs.php">
                    <span class="icon-holder">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <span class="title">Logs</span>
                </a>
            </li>
            <?php
            if ($_SESSION['level'] == 3 or $_SESSION['level'] == 9) {
            ?>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="other-activities.php">
                    <span class="icon-holder">
                        <i class="anticon anticon-calendar"></i>
                    </span>
                    <span class="title">Other Activities</span>
                </a>
            </li>
            <?php
            }
            ?>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="logout.php">
                    <span class="icon-holder">
                        <i class="anticon anticon-logout"></i>
                    </span>
                    <span class="title">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>
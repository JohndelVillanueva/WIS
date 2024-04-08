<div class="side-nav">
    <div class="side-nav-inner">
        <ul class="side-nav-menu scrollable">
			<?php
			if($_SESSION['level']>=1) {
			?>
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
			if($_SESSION['level']==4 OR $_SESSION['level']==9) {
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
			
			if($_SESSION['level']==3 OR $_SESSION['level']==9) {
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
			
			if($_SESSION['level']==2 OR $_SESSION['level']==9) {
			?>
			<li class="nav-item dropdown">
                <a class="dropdown-toggle" href="admissions.php">
                   <span class="icon-holder">
                    <i class="anticon anticon-bank"></i>
                    </span>
                    <span class="title">Admissions</span>
                </a>
            </li>
			<?php		
			}
			
			if($_SESSION['level']==5 OR $_SESSION['level']==9) {
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
			
			if($_SESSION['level']==6 OR $_SESSION['level']==9) {
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
			
			if($_SESSION['level']==4 OR $_SESSION['level']==9) {
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
			if($_SESSION['level']==3 OR $_SESSION['level']==9) {
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
			} if($_SESSION['level']>=1) {
			?>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="completed.php">
                   <span class="icon-holder">
                    <i class="anticon anticon-database"></i>
                    </span>
                    <span class="title">Enrolled</span>
                </a>
            </li>
			<?php
			} if($_SESSION['level']==0) {
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
			?>
            <?php
		    if($_SESSION['level']!=0) {
			?>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="gradingsystem.php">
                   <span class="icon-holder">
                    <i class="anticon anticon-dashboard"></i>
                    </span>
                    <span class="title">Grade</span>
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
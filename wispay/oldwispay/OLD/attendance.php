<?php
    include_once 'classes/dbclass.php';
    include_once 'header.php';
?>
    <div class="container py-3">
        <header>
            <div class="container">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">

                        <!-- Brand/logo -->
                        <div class="navbar-header">
                            <a class="navbar-brand" href="/">Westfields International School - Attendance System</a>
                        </div>

                        <!-- Collapsible Navbar -->
                        <div class="collapse navbar-collapse">
                            <ul class="nav navbar-nav nav-pills navbar-right">
                                <li class="text-primary"><a href="add-data.php"><span class="glyphicon glyphicon-plus"></span> Add Record</a></li>
                            </ul>
                        </div>

                    </div>
                </nav>
            </div>

            <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
                <h1 class="display-5 fw-normal">Employee Masterlist</h1>
                <table class='table table-bordered table-responsive table-striped'>
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Position</th>
                        <th scope="col">DOB</th>
                        <th scope="col">Email</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Vacc</th>
                        <th colspan="2" class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $query = "SELECT * FROM user WHERE NOT position='Student' ORDER BY lname ASC";
                    $records_per_page=15;
                    $newquery = $crud->paging($query,$records_per_page);
                    $crud->dataview($newquery);
                    ?>
                    </tbody>
                    <tr>
                        <td colspan="8">
                            <div class="pagination-wrap text-sm-center">
                                <?php $crud->paginglink($query,$records_per_page); ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </header>
    </div>
<?php include_once 'footer.php'; ?>
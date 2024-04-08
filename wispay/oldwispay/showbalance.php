<?php
include_once 'classes/dbclass.php';
include_once 'header.php';

?>
<body>
<div class="container py-3">
    <header>
        <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
            <h1 class="display-5 fw-normal">Masterlist</h1>
            <table class='table table-bordered table-responsive table-striped'>
                <thead>
                <tr>
                    <th scope="col">RFID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Position</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT * FROM user ORDER BY lname ASC";
                $records_per_page=50;
                $newquery = $crud->paging($query,$records_per_page);
                $crud->dataview2($newquery);
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
</body>
<?php
    include_once 'footer.php';
?>
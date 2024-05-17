<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="assets/js/data.js"></script>
<script src="assets/js/vendors.min.js"></script>
<script src="assets/vendors/chartjs/Chart.min.js"></script>
<script src="assets/js/pages/dashboard-default.js"></script>
<script src="assets/js/app.min.js"></script>
<script src="assets/js/grade.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
<script src="assets/fontawesome/js/all.min.js"></script>

<script>
    $(document).on('show.bs.modal', '.modal', function() {
        $(".modal-backdrop").not(':first').remove();

    });
    $(document).ready(function() {
        $('#wwOption').hide();
        $('#ptOption').hide();
    });
    $('#actype').change(function() {
        if ($(this).val() == 'Written') {
            $('#PTtype').removeAttr('name');
            $('#wwType').attr('name', 'type');
            $('#wwOption').show();
            $('#ptOption').hide();
        }
        if ($(this).val() == 'Performance') {
            $('#wwType').removeAttr('name');
            $('#PTtype').attr('name', 'type');
            $('#ptOption').show();
            $('#wwOption').hide();
        }
        if ($(this).val() == 'Quarterly') {

            $('#wwOption').hide();
            $('#ptOption').hide();
            $('#PTtype').removeAttr('name');
            $('#wwType').removeAttr('name');
        }

    });

    // dropdown-toggle
    function drpFunction() {
        document.getElementById("dropdown-list").classList.toggle("showdrpdwn");
    }
    // dropdown-function
    window.onclick = function(event) {
        if (!event.target.matches('.dropdown-btn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }


    function adaptColor() {
        // Change Color 
        if (document.getElementById("reg").checked) {
            document.querySelector('.modal-header').style.background = '#007bff'; // Bootstrap primary color
            document.querySelector('.modal-footer').style.background = '#007bff';
            document.querySelector('#modal-header-body').style.background = '#007bff';
            document.querySelectorAll('.modal-body input[type="number"]').forEach(input => {
                input.style.background = '#fff'; // Change input background color
                input.style.color = '#000'; // Change input text color
            })
        }
        // Change Color 
        if (document.getElementById("phyedu").checked) {
            document.querySelector('.modal-header').style.background = '#30C6CC';
            document.querySelector('.modal-footer').style.background = '#30C6CC';
            document.querySelector('#modal-header-body').style.background = '#30C6CC';
            document.querySelectorAll('.modal-body input[type="number"]').forEach(input => {
                input.style.background = '#fff';
                input.style.color = '#000';
            })
        }
        // Change Color 
        if (document.getElementById("afterschool").checked) {
            document.querySelector('.modal-header').style.background = '#866CE8';
            document.querySelector('.modal-footer').style.background = '#866CE8';
            document.querySelector('#modal-header-body').style.background = '#866CE8';
            document.querySelectorAll('.modal-body input[type="number"]').forEach(input => {
                input.style.background = '#fff';
                input.style.color = '#000';
            })
        }

        //Reset to Default Color
        document.getElementById("reset").addEventListener("click", function() {
            document.querySelector('.modal-header').style.background = '#ffc107'; // Bootstrap warning color
            document.querySelector('.modal-footer').style.background = '#ffc107';
            document.querySelector('#modal-header-body').style.background = '#ffc107';
            document.querySelectorAll('.modal-body input[type="number"]').forEach(input => {
                input.style.background = '#fff'; // Reset input background color
                input.style.color = '#000'; // Reset input text color
            });
        });
    }


    //Auto Incremential ID elements
    var i = 0;
    $('.inventorylist').each(function() {
        i++;
        var newID = 'list' + i;
        $(this).attr('id', newID);
        $(this).val(i);

        new DataTable('#'+newID, {
        pageLength: 5,
        lengthChange: false,
        searching: false,
        ordering: false
    });
    });
</script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="assets/js/data.js"></script>
<script src="assets/js/vendors.min.js"></script>
<script src="assets/vendors/chartjs/Chart.min.js"></script>
<script src="assets/js/pages/dashboard-default.js"></script>
<script src="assets/js/app.min.js"></script>
<script src="assets/js/grade.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $(document).on('show.bs.modal', '.modal', function () {
        $(".modal-backdrop").not(':first').remove();
        
    });
    $(document).ready(function(){
        $('#wwOption').hide();
        $('#ptOption').hide();
    });
    $('#actype').change(function(){
        if($(this).val() == 'Written'){ 
            $('#PTtype').removeAttr('name');    
            $('#wwType').attr('name','type');   
            $('#wwOption').show();
            $('#ptOption').hide();
        }
        if($(this).val() == 'Performance'){ 
            $('#wwType').removeAttr('name');    
            $('#PTtype').attr('name','type');  
            $('#ptOption').show();
            $('#wwOption').hide();
        }
        if($(this).val()=='Quarterly'){
            
            $('#wwOption').hide();
            $('#ptOption').hide();
            $('#PTtype').removeAttr('name');
            $('#wwType').removeAttr('name');
        }
      
    });
</script>
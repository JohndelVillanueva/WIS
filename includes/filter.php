<script>
$('#GLevel').change(function(){
    var gLevel =  $('#GLevel option:selected').text();
    $('#subs').removeClass('d-none');
    $('#nosubs').addClass('d-none');
    if(gLevel=="Nursery"){
        $( "#gradeRow").find('.1').addClass('d-none');
        $( "#gradeRow").find('.Toddler').addClass('d-none');
        $( "#gradeRow").find('.Preschool').addClass('d-none');
        $( "#gradeRow").find('.Kinder').addClass('d-none');
        $( "#gradeRow").find('.2').addClass('d-none');
        $( "#gradeRow").find('.3').addClass('d-none');
        $( "#gradeRow").find('.4').addClass('d-none');
        $( "#gradeRow").find('.5').addClass('d-none');
        $( "#gradeRow").find('.6').addClass('d-none');
        $( "#gradeRow").find('.7').addClass('d-none');
        $( "#gradeRow").find('.8').addClass('d-none');
        $( "#gradeRow").find('.9').addClass('d-none');
        $( "#gradeRow").find('.10').addClass('d-none');
        $( "#gradeRow").find('.11').addClass('d-none');
        $( "#gradeRow").find('.12').addClass('d-none');
        $( "#gradeRow").find('.CAIE').addClass('d-none');
        $( "#gradeRow").find('.Nursery').removeClass('d-none');
    } if(gLevel == "Toddler"){
        $( "#gradeRow").find('.Nursery').addClass('d-none');
        $( "#gradeRow").find('.1').addClass('d-none');
        $( "#gradeRow").find('.Preschool').addClass('d-none');
        $( "#gradeRow").find('.Kinder').addClass('d-none');
        $( "#gradeRow").find('.2').addClass('d-none');
        $( "#gradeRow").find('.3').addClass('d-none');
        $( "#gradeRow").find('.4').addClass('d-none');
        $( "#gradeRow").find('.5').addClass('d-none');
        $( "#gradeRow").find('.6').addClass('d-none');
        $( "#gradeRow").find('.7').addClass('d-none');
        $( "#gradeRow").find('.8').addClass('d-none');
        $( "#gradeRow").find('.9').addClass('d-none');
        $( "#gradeRow").find('.10').addClass('d-none');
        $( "#gradeRow").find('.11').addClass('d-none');
        $( "#gradeRow").find('.12').addClass('d-none');
        $( "#gradeRow").find('.CAIE').addClass('d-none');
        ( "#gradeRow").find('.Toddler').removeClass('d-none');
    }if(gLevel == "Preschool"){
        $( "#gradeRow").find('.Nursery').addClass('d-none');
        $( "#gradeRow").find('.Toddler').addClass('d-none');
        $( "#gradeRow").find('.1').addClass('d-none');
        $( "#gradeRow").find('.Kinder').addClass('d-none');
        $( "#gradeRow").find('.2').addClass('d-none');
        $( "#gradeRow").find('.3').addClass('d-none');
        $( "#gradeRow").find('.4').addClass('d-none');
        $( "#gradeRow").find('.5').addClass('d-none');
        $( "#gradeRow").find('.6').addClass('d-none');
        $( "#gradeRow").find('.7').addClass('d-none');
        $( "#gradeRow").find('.8').addClass('d-none');
        $( "#gradeRow").find('.9').addClass('d-none');
        $( "#gradeRow").find('.10').addClass('d-none');
        $( "#gradeRow").find('.11').addClass('d-none');
        $( "#gradeRow").find('.12').addClass('d-none');
        $( "#gradeRow").find('.CAIE').addClass('d-none');
        ( "#gradeRow").find('Preschool').removeClass('d-none');
    }
    if(gLevel == "Kinder"){
        $( "#gradeRow").find('.Nursery').addClass('d-none');
        $( "#gradeRow").find('.Toddler').addClass('d-none');
        $( "#gradeRow").find('.Preschool').addClass('d-none');
        $( "#gradeRow").find('.1').addClass('d-none');
        $( "#gradeRow").find('.2').addClass('d-none');
        $( "#gradeRow").find('.3').addClass('d-none');
        $( "#gradeRow").find('.4').addClass('d-none');
        $( "#gradeRow").find('.5').addClass('d-none');
        $( "#gradeRow").find('.6').addClass('d-none');
        $( "#gradeRow").find('.7').addClass('d-none');
        $( "#gradeRow").find('.8').addClass('d-none');
        $( "#gradeRow").find('.9').addClass('d-none');
        $( "#gradeRow").find('.10').addClass('d-none');
        $( "#gradeRow").find('.11').addClass('d-none');
        $( "#gradeRow").find('.12').addClass('d-none');
        $( "#gradeRow").find('.CAIE').addClass('d-none');
        ( "#gradeRow").find('.Kinder').removeClass('d-none');
    }
    if(gLevel == "Grade 1"){
        $( "#gradeRow").find('.Nursery').addClass('d-none');
        $( "#gradeRow").find('.Toddler').addClass('d-none');
        $( "#gradeRow").find('.Preschool').addClass('d-none');
        $( "#gradeRow").find('.Kinder').addClass('d-none');
        $( "#gradeRow").find('.2').addClass('d-none');
        $( "#gradeRow").find('.3').addClass('d-none');
        $( "#gradeRow").find('.4').addClass('d-none');
        $( "#gradeRow").find('.5').addClass('d-none');
        $( "#gradeRow").find('.6').addClass('d-none');
        $( "#gradeRow").find('.7').addClass('d-none');
        $( "#gradeRow").find('.8').addClass('d-none');
        $( "#gradeRow").find('.9').addClass('d-none');
        $( "#gradeRow").find('.10').addClass('d-none');
        $( "#gradeRow").find('.11').addClass('d-none');
        $( "#gradeRow").find('.12').addClass('d-none');
        $( "#gradeRow").find('.CAIE').addClass('d-none');
        $( "#gradeRow").find('.1').removeClass('d-none');
    }
    if(gLevel == "Grade 2"){
        $( "#gradeRow").find('.Nursery').addClass('d-none');
        $( "#gradeRow").find('.Toddler').addClass('d-none');
        $( "#gradeRow").find('.Preschool').addClass('d-none');
        $( "#gradeRow").find('.Kinder').addClass('d-none');
        $( "#gradeRow").find('.1').addClass('d-none');
        $( "#gradeRow").find('.3').addClass('d-none');
        $( "#gradeRow").find('.4').addClass('d-none');
        $( "#gradeRow").find('.5').addClass('d-none');
        $( "#gradeRow").find('.6').addClass('d-none');
        $( "#gradeRow").find('.7').addClass('d-none');
        $( "#gradeRow").find('.8').addClass('d-none');
        $( "#gradeRow").find('.9').addClass('d-none');
        $( "#gradeRow").find('.10').addClass('d-none');
        $( "#gradeRow").find('.11').addClass('d-none');
        $( "#gradeRow").find('.12').addClass('d-none');
        $( "#gradeRow").find('.CAIE').addClass('d-none');
        $( "#gradeRow").find('.2').removeClass('d-none');
    }
    if(gLevel == "Grade 3"){
        $( "#gradeRow").find('.Nursery').addClass('d-none');
        $( "#gradeRow").find('.Toddler').addClass('d-none');
        $( "#gradeRow").find('.Preschool').addClass('d-none');
        $( "#gradeRow").find('.Kinder').addClass('d-none');
        $( "#gradeRow").find('.2').addClass('d-none');
        $( "#gradeRow").find('.1').addClass('d-none');
        $( "#gradeRow").find('.4').addClass('d-none');
        $( "#gradeRow").find('.5').addClass('d-none');
        $( "#gradeRow").find('.6').addClass('d-none');
        $( "#gradeRow").find('.7').addClass('d-none');
        $( "#gradeRow").find('.8').addClass('d-none');
        $( "#gradeRow").find('.9').addClass('d-none');
        $( "#gradeRow").find('.10').addClass('d-none');
        $( "#gradeRow").find('.11').addClass('d-none');
        $( "#gradeRow").find('.12').addClass('d-none');
        $( "#gradeRow").find('.CAIE').addClass('d-none');
        $( "#gradeRow").find('.3').removeClass('d-none');
    }
    if(gLevel == "Grade 4"){
        $( "#gradeRow").find('.Nursery').addClass('d-none');
        $( "#gradeRow").find('.Toddler').addClass('d-none');
        $( "#gradeRow").find('.Preschool').addClass('d-none');
        $( "#gradeRow").find('.Kinder').addClass('d-none');
        $( "#gradeRow").find('.2').addClass('d-none');
        $( "#gradeRow").find('.3').addClass('d-none');
        $( "#gradeRow").find('.1').addClass('d-none');
        $( "#gradeRow").find('.5').addClass('d-none');
        $( "#gradeRow").find('.6').addClass('d-none');
        $( "#gradeRow").find('.7').addClass('d-none');
        $( "#gradeRow").find('.8').addClass('d-none');
        $( "#gradeRow").find('.9').addClass('d-none');
        $( "#gradeRow").find('.10').addClass('d-none');
        $( "#gradeRow").find('.11').addClass('d-none');
        $( "#gradeRow").find('.12').addClass('d-none');
        $( "#gradeRow").find('.CAIE').addClass('d-none');
        $( "#gradeRow").find('.4').removeClass('d-none');
    }
    if(gLevel == "Grade 5"){
        $( "#gradeRow").find('.Nursery').addClass('d-none');
        $( "#gradeRow").find('.Toddler').addClass('d-none');
        $( "#gradeRow").find('.Preschool').addClass('d-none');
        $( "#gradeRow").find('.Kinder').addClass('d-none');
        $( "#gradeRow").find('.2').addClass('d-none');
        $( "#gradeRow").find('.3').addClass('d-none');
        $( "#gradeRow").find('.4').addClass('d-none');
        $( "#gradeRow").find('.1').addClass('d-none');
        $( "#gradeRow").find('.6').addClass('d-none');
        $( "#gradeRow").find('.7').addClass('d-none');
        $( "#gradeRow").find('.8').addClass('d-none');
        $( "#gradeRow").find('.9').addClass('d-none');
        $( "#gradeRow").find('.10').addClass('d-none');
        $( "#gradeRow").find('.11').addClass('d-none');
        $( "#gradeRow").find('.12').addClass('d-none');
        $( "#gradeRow").find('.CAIE').addClass('d-none');
        $( "#gradeRow").find('.5').removeClass('d-none');
    }
    if(gLevel == "Grade 6"){
        $( "#gradeRow").find('.Nursery').addClass('d-none');
        $( "#gradeRow").find('.Toddler').addClass('d-none');
        $( "#gradeRow").find('.Preschool').addClass('d-none');
        $( "#gradeRow").find('.Kinder').addClass('d-none');
        $( "#gradeRow").find('.2').addClass('d-none');
        $( "#gradeRow").find('.3').addClass('d-none');
        $( "#gradeRow").find('.4').addClass('d-none');
        $( "#gradeRow").find('.5').addClass('d-none');
        $( "#gradeRow").find('.1').addClass('d-none');
        $( "#gradeRow").find('.7').addClass('d-none');
        $( "#gradeRow").find('.8').addClass('d-none');
        $( "#gradeRow").find('.9').addClass('d-none');
        $( "#gradeRow").find('.10').addClass('d-none');
        $( "#gradeRow").find('.11').addClass('d-none');
        $( "#gradeRow").find('.12').addClass('d-none');
        $( "#gradeRow").find('.CAIE').addClass('d-none');
        $( "#gradeRow").find('.6').removeClass('d-none');
    }
    if(gLevel == "Grade 7"){
        $( "#gradeRow").find('.Nursery').addClass('d-none');
        $( "#gradeRow").find('.Toddler').addClass('d-none');
        $( "#gradeRow").find('.Preschool').addClass('d-none');
        $( "#gradeRow").find('.Kinder').addClass('d-none');
        $( "#gradeRow").find('.2').addClass('d-none');
        $( "#gradeRow").find('.3').addClass('d-none');
        $( "#gradeRow").find('.4').addClass('d-none');
        $( "#gradeRow").find('.5').addClass('d-none');
        $( "#gradeRow").find('.6').addClass('d-none');
        $( "#gradeRow").find('.1').addClass('d-none');
        $( "#gradeRow").find('.8').addClass('d-none');
        $( "#gradeRow").find('.9').addClass('d-none');
        $( "#gradeRow").find('.10').addClass('d-none');
        $( "#gradeRow").find('.11').addClass('d-none');
        $( "#gradeRow").find('.12').addClass('d-none');
        $( "#gradeRow").find('.CAIE').addClass('d-none');
        $( "#gradeRow").find('.7').removeClass('d-none');
    }
    if(gLevel == "Grade 8"){
        $( "#gradeRow").find('.Nursery').addClass('d-none');
        $( "#gradeRow").find('.Toddler').addClass('d-none');
        $( "#gradeRow").find('.Preschool').addClass('d-none');
        $( "#gradeRow").find('.Kinder').addClass('d-none');
        $( "#gradeRow").find('.2').addClass('d-none');
        $( "#gradeRow").find('.3').addClass('d-none');
        $( "#gradeRow").find('.4').addClass('d-none');
        $( "#gradeRow").find('.5').addClass('d-none');
        $( "#gradeRow").find('.6').addClass('d-none');
        $( "#gradeRow").find('.7').addClass('d-none');
        $( "#gradeRow").find('.1').addClass('d-none');
        $( "#gradeRow").find('.9').addClass('d-none');
        $( "#gradeRow").find('.10').addClass('d-none');
        $( "#gradeRow").find('.11').addClass('d-none');
        $( "#gradeRow").find('.12').addClass('d-none');
        $( "#gradeRow").find('.CAIE').addClass('d-none');
        $( "#gradeRow").find('.8').removeClass('d-none');
    }
    if(gLevel == "Grade 9"){
        $( "#gradeRow").find('.Nursery').addClass('d-none');
        $( "#gradeRow").find('.Toddler').addClass('d-none');
        $( "#gradeRow").find('.Preschool').addClass('d-none');
        $( "#gradeRow").find('.Kinder').addClass('d-none');
        $( "#gradeRow").find('.2').addClass('d-none');
        $( "#gradeRow").find('.3').addClass('d-none');
        $( "#gradeRow").find('.4').addClass('d-none');
        $( "#gradeRow").find('.5').addClass('d-none');
        $( "#gradeRow").find('.6').addClass('d-none');
        $( "#gradeRow").find('.7').addClass('d-none');
        $( "#gradeRow").find('.8').addClass('d-none');
        $( "#gradeRow").find('.1').addClass('d-none');
        $( "#gradeRow").find('.10').addClass('d-none');
        $( "#gradeRow").find('.11').addClass('d-none');
        $( "#gradeRow").find('.12').addClass('d-none');
        $( "#gradeRow").find('.CAIE').addClass('d-none');
        $( "#gradeRow").find('.9').removeClass('d-none');
    }
    if(gLevel == "Grade 10"){
         $( "#gradeRow").find('.Nursery').addClass('d-none');
        $( "#gradeRow").find('.Toddler').addClass('d-none');
        $( "#gradeRow").find('.Preschool').addClass('d-none');
        $( "#gradeRow").find('.Kinder').addClass('d-none');
        $( "#gradeRow").find('.2').addClass('d-none');
        $( "#gradeRow").find('.3').addClass('d-none');
        $( "#gradeRow").find('.4').addClass('d-none');
        $( "#gradeRow").find('.5').addClass('d-none');
        $( "#gradeRow").find('.6').addClass('d-none');
        $( "#gradeRow").find('.7').addClass('d-none');
        $( "#gradeRow").find('.8').addClass('d-none');
        $( "#gradeRow").find('.9').addClass('d-none');
        $( "#gradeRow").find('.1').addClass('d-none');
        $( "#gradeRow").find('.11').addClass('d-none');
        $( "#gradeRow").find('.12').addClass('d-none');
        $( "#gradeRow").find('.CAIE').addClass('d-none');
          $( "#gradeRow").find('.10').removeClass('d-none');
    }
    if(gLevel == "Grade 11"){
         $( "#gradeRow").find('.Nursery').addClass('d-none');
        $( "#gradeRow").find('.Toddler').addClass('d-none');
        $( "#gradeRow").find('.Preschool').addClass('d-none');
        $( "#gradeRow").find('.Kinder').addClass('d-none');
        $( "#gradeRow").find('.2').addClass('d-none');
        $( "#gradeRow").find('.3').addClass('d-none');
        $( "#gradeRow").find('.4').addClass('d-none');
        $( "#gradeRow").find('.5').addClass('d-none');
        $( "#gradeRow").find('.6').addClass('d-none');
        $( "#gradeRow").find('.7').addClass('d-none');
        $( "#gradeRow").find('.8').addClass('d-none');
        $( "#gradeRow").find('.9').addClass('d-none');
        $( "#gradeRow").find('.10').addClass('d-none');
        $( "#gradeRow").find('.1').addClass('d-none');
        $( "#gradeRow").find('.12').addClass('d-none');
        $( "#gradeRow").find('.CAIE').addClass('d-none');
          $( "#gradeRow").find('.11').removeClass('d-none');
    }
    if(gLevel == "Grade 12"){
         $( "#gradeRow").find('.Nursery').addClass('d-none');
        $( "#gradeRow").find('.Toddler').addClass('d-none');
        $( "#gradeRow").find('.Preschool').addClass('d-none');
        $( "#gradeRow").find('.Kinder').addClass('d-none');
        $( "#gradeRow").find('.2').addClass('d-none');
        $( "#gradeRow").find('.3').addClass('d-none');
        $( "#gradeRow").find('.4').addClass('d-none');
        $( "#gradeRow").find('.5').addClass('d-none');
        $( "#gradeRow").find('.6').addClass('d-none');
        $( "#gradeRow").find('.7').addClass('d-none');
        $( "#gradeRow").find('.8').addClass('d-none');
        $( "#gradeRow").find('.9').addClass('d-none');
        $( "#gradeRow").find('.10').addClass('d-none');
        $( "#gradeRow").find('.11').addClass('d-none');
        $( "#gradeRow").find('.1').addClass('d-none');
        $( "#gradeRow").find('.CAIE').addClass('d-none');
          $( "#gradeRow").find('.12').removeClass('d-none');
    }
    if(gLevel == "CAIE"){
        $( "#gradeRow").find('.Nursery').addClass('d-none');
        $( "#gradeRow").find('.Toddler').addClass('d-none');
        $( "#gradeRow").find('.Preschool').addClass('d-none');
        $( "#gradeRow").find('.Kinder').addClass('d-none');
        $( "#gradeRow").find('.2').addClass('d-none');
        $( "#gradeRow").find('.3').addClass('d-none');
        $( "#gradeRow").find('.4').addClass('d-none');
        $( "#gradeRow").find('.5').addClass('d-none');
        $( "#gradeRow").find('.6').addClass('d-none');
        $( "#gradeRow").find('.7').addClass('d-none');
        $( "#gradeRow").find('.8').addClass('d-none');
        $( "#gradeRow").find('.9').addClass('d-none');
        $( "#gradeRow").find('.10').addClass('d-none');
        $( "#gradeRow").find('.11').addClass('d-none');
        $( "#gradeRow").find('.12').addClass('d-none');
        $( "#gradeRow").find('.1').addClass('d-none');
        $( "#gradeRow").find('.CAIE').removeClass('d-none');
    }
});


</script>

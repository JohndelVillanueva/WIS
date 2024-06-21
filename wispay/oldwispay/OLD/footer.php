<!-- jQuery -->
<script src="js/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script>
    $('#sandbox-container .input-group.date').datepicker({
        format: "yyyy-mm-dd"
    });
</script>
<script>
    function currentTime() {
        let date = new Date();
        let hh = date.getHours();
        let mm = date.getMinutes();
        let ss = date.getSeconds();
        let session = "AM";

        if(hh == 0){
            hh = 12;
        }
        if(hh > 12){
            hh = hh - 12;
            session = "PM";
        }

        hh = (hh < 10) ? "0" + hh : hh;
        mm = (mm < 10) ? "0" + mm : mm;
        ss = (ss < 10) ? "0" + ss : ss;

        let time = hh + ":" + mm + ":" + ss + " " + session;

        document.getElementById("clock").innerText = time;
        let t = setTimeout(function(){ currentTime() }, 1000);
    }
    currentTime();
</script>
</body>
</html>

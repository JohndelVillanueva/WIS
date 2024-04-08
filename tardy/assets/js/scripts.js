function fnCalculateAge(){
    var userDateinput = document.getElementById("dob").value;
    var birthDate = new Date(userDateinput);
    var difference=Date.now() - birthDate.getTime();
    var ageDate = new Date(difference);
    var calculatedAge=   Math.abs(ageDate.getUTCFullYear() - 1970);
    document.getElementById('age').value = new Number(calculatedAge);
}

function fnStrand(){
    if(document.getElementById("gradelevel").value == "grade11"){
        document.getElementById("row12").style.display = "none";
        document.getElementById("row11").style.display = null;
        document.getElementById("row11").style.display = "block";
    } else if(document.getElementById("gradelevel").value == "grade12"){
        document.getElementById("row11").style.display = "none";
        document.getElementById("row12").style.display = null;
        document.getElementById("row12").style.display = "block";
    }
}

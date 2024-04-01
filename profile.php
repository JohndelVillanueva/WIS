<?php include_once "includes/config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include_once "includes/css.php"; ?>

<body>
    <div class="app">
        <div class="layout">
            <?php include_once "includes/heading.php"; ?>
            <?php include_once "includes/sidemenu.php"; ?>
            <?php
            $pdo_statement = $DB_con->prepare("SELECT * FROM users24 WHERE id = :id");
            $pdo_statement->execute(array(":id" => $_GET['id']));
            $result = $pdo_statement->fetchAll();
            foreach ($result as $row) {
            ?>
                <div class="page-container">
                    <div class="main-content">
                        <!-- form starts !-->
                        <form action="newstudent.php" method="post">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header bg-warning rounded-top pt-2">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h4><span class="icon-holder"><i class="anticon anticon-idcard"></i></span> Student Profile</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-2"><img class="rounded" style="max-width: 128px!important;" src="assets/images/avatars/
                                                    <?php
                                                    if (!empty($row["photo"])) {
                                                        echo "avatar.jpg";
                                                    } else {
                                                        echo $row["photo"];
                                                    }
                                                    ?>">
                                                </div>
                                                <div class="col-lg-8">
                                                    <h1><?php echo $row["lname"] . ", " . $row["fname"] . " " . $row["mname"] ?></h1>
                                                    <hr>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="float-right">
                                                        <a href="print.php?id=<?php echo $_GET["id"]; ?>" class="btn btn-success"><span class="icon-holder"><i class="anticon anticon-printer"></i></span></a>
                                                        <a href="javascript:history.back()" class="btn btn-primary"><span class="icon-holder"><i class="anticon anticon-backward"></i></span></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row py-3">
                                                <div class="col-lg-1">
                                                    <label for="sy">SY</label>
                                                    <input type="text" class="form-control" id="sy" name="sy" value="2023-24" required disabled>
                                                </div>
                                                <div class="col-lg-1">
                                                    <label for="dob">DOB</label>
                                                    <input type="text" class="form-control" id="dob" name="dob" disabled required value="<?php echo date("m/d/Y", strtotime($row["dob"])); ?>">
                                                </div>
                                                <div class="col-lg-1">
                                                    <?php
                                                    function getAge($date)
                                                    {
                                                        return intval(date('Y', time() - strtotime($date))) - 1970;
                                                    }

                                                    ?>
                                                    <label for="age">Age</label>
                                                    <input type="text" class="form-control" id="age" name="age" disabled required value="<?php echo getAge($row["dob"]); ?>">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label for="lrn">LRN</label>
                                                    <input type="text" class="form-control" id="lrn" name="lrn" value="<?php echo $row["lrn"]; ?>" disabled>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label for="oldschool">Previous School</label>
                                                    <input type="text" class="form-control" id="oldschool" name="oldschool" value="<?php echo $row["prevsch"]; ?>" disabled>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label for="prevschcountry">Country</label>
                                                    <input type="text" class="form-control" id="prevschcountry" name="prevschcountry" value="<?php echo $row["prevschcountry"]; ?>" disabled>
                                                </div>
                                                <div class="col-lg-1">
                                                    <label for="nationality">Nationality</label>
                                                    <input type="text" class="form-control" id="nationality" name="nationality" value="<?php echo ucfirst($row["nationality"]); ?>" disabled>
                                                </div>
                                                <div class="col-lg-1">
                                                    <label for="grade">Grade</label>
                                                    <input type="text" class="form-control" id="grade" name="grade" value="<?php echo ucfirst($row["grade"]); ?>" disabled>
                                                </div>
                                                <div class="col-lg-1">
                                                    <label for="section">Section</label>
                                                    <input type="text" class="form-control" id="grade" name="grade" value="<?php echo ucfirst($row["section"]); ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <label for="guardian">Guardian</label>
                                                    <input type="text" class="form-control" id="guardian" name="guardian" placeholder="Guardian's Name" required value="<?php echo $row["guardianname"]; ?>" disabled>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label for="guardianemail">Guardian's Email</label>
                                                    <input type="text" class="form-control" id="guardianemail" name="guardianemail" placeholder="Guardian's Email" required value="<?php echo $row["guardianemail"]; ?>" disabled>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label for="guardianphone">Guardian's #</label>
                                                    <input type="text" class="form-control" id="guardianphone" name="guardianphone" placeholder="Guardian's Phone Number" required value="<?php echo $row["guardianphone"]; ?>" disabled>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label for="referral">Referral</label>
                                                    <select class="custom-select" id="referral" class="form-select" name="referral" disabled>
                                                        <option value="<?php echo $row["referral"]; ?>""><?php echo ucfirst($row["referral"]); ?></option>
                                                <option value="">-- select one --</option>
                                                <option value=" Website">Website</option>
                                                        <option value="Brochure">Brochure</option>
                                                        <option value="Poster">Poster</option>
                                                        <option value="Social Media">Social Media</option>
                                                        <option value="Search Engine">Search Engine</option>
                                                        <option value="Friends/Relatives">Friends/Relatives</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 mt-5 text-center">
                                                    <p class="h2">Additional Details</p>
                                                    <hr>
                                                </div>
                                            </div>
                                            <?php
                                            $info_statement = $DB_con->prepare("SELECT * FROM studentdetails WHERE uniqid = :uniqid");
                                            $info_statement->execute(array(":uniqid" => $row['uniqid']));
                                            $iresult = $info_statement->fetchAll();
                                            foreach ($iresult as $irow) {
                                            ?>
                                                <div class="row my-3">
                                                    <div class="col-lg-3">
                                                        <label for="street">Number and Street</label>
                                                        <input type="text" class="form-control" id="street" name="street" placeholder="Number and Street" required value="<?php if (!empty($irow['street'])) {
                                                                                                                                                                                echo $irow['street'];
                                                                                                                                                                            } ?>">
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label for="barangay">Barangay / Subdivision</label>
                                                        <input type="text" class="form-control" id="barangay" name="barangay" placeholder="Mother's Email" required value="<?php if (!empty($irow['barangay'])) {
                                                                                                                                                                                echo $irow['barangay'];
                                                                                                                                                                            } ?>">
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label for="city">City</label>
                                                        <input type="text" class="form-control" id="city" name="city" placeholder="City" required value="<?php if (!empty($irow['city'])) {
                                                                                                                                                                echo $irow['city'];
                                                                                                                                                            } ?>">
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label for="postal">Postal Code</label>
                                                        <input type="text" class="form-control" id="postal" name="postal" placeholder="Postal Code" required value="<?php if (!empty($irow['postal'])) {
                                                                                                                                                                        echo $irow['postal'];
                                                                                                                                                                    } ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <label for="father">Father's Name</label>
                                                        <input type="text" class="form-control" id="father" name="father" placeholder="Father's Name" required value="<?php if (!empty($irow['street'])) {
                                                                                                                                                                            echo $irow['street'];
                                                                                                                                                                        } ?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="fathermail">Father's Email</label>
                                                        <input type="text" class="form-control" id="fathermail" name="fathermail" placeholder="Father's Email" required value="<?php if (!empty($irow['fathermail'])) {
                                                                                                                                                                                    echo $irow['fathermail'];
                                                                                                                                                                                } ?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="fatherphone">Father's Phone Number</label>
                                                        <input type="text" class="form-control" id="fatherphone" name="fatherphone" placeholder="Father's Phone Number" required value="<?php if (!empty($irow['fathernumber'])) {
                                                                                                                                                                                            echo $irow['fathernumber'];
                                                                                                                                                                                        } ?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="fatherwork">Father's Occupation</label>
                                                        <input type="text" class="form-control" id="fatherwork" name="fatherwork" placeholder="Father's Occupation" required value="<?php if (!empty($irow['fatherwork'])) {
                                                                                                                                                                                        echo $irow['fatherwork'];
                                                                                                                                                                                    } ?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="fathercompany">Father's Company</label>
                                                        <input type="text" class="form-control" id="fathercompany" name="fathercompany" placeholder="Father's Company" required value="<?php if (!empty($irow['fatherwork'])) {
                                                                                                                                                                                            echo $irow['fatherwork'];
                                                                                                                                                                                        } ?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="fsalaryrange">Average Monthly Salary</label>
                                                        <select class="custom-select" id="fsalaryrange" class="form-select" name="fsalaryrange">
                                                            <option value="<?php if (!empty($irow['fsalary'])) {
                                                                                echo $irow['fsalary'];
                                                                            } ?>" selected><?php if (!empty($irow['fsalary'])) {
                                                                                                                                                            echo $irow['fsalary'];
                                                                                                                                                        } ?></option>
                                                            <option value="">-- select one --</option>
                                                            <option value="P 0 - P 50 000">P 0 - P 50 000</option>
                                                            <option value="P 50 001 - P 100 000">P 50 001 - P 100 000</option>
                                                            <option value="P 100 001 - P 200 000">P 100 001 - P 200 000</option>
                                                            <option value="P 200 001 - P 500 000">P 200 001 - P 500 000</option>
                                                            <option value="P 500 001 - UP">P 500 001 - UP</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row my-3">
                                                    <div class="col-lg-2">
                                                        <label for="mother">Mother's Name</label>
                                                        <input type="text" class="form-control" id="mother" name="mother" placeholder="Mother's Name" required value="<?php if (!empty($irow['mother'])) {
                                                                                                                                                                            echo $irow['mother'];
                                                                                                                                                                        } ?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="mothermail">Mother's Email</label>
                                                        <input type="text" class="form-control" id="mothermail" name="mothermail" placeholder="Mother's Email" required value="<?php if (!empty($irow['mothermail'])) {
                                                                                                                                                                                    echo $irow['mothermail'];
                                                                                                                                                                                } ?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="motherphone">Mothers's Phone Number</label>
                                                        <input type="text" class="form-control" id="motherphone" name="motherphone" placeholder="Mothers's Phone Number" required value="<?php if (!empty($irow['mothernumber'])) {
                                                                                                                                                                                                echo $irow['mothernumber'];
                                                                                                                                                                                            } ?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="motherwork">Mother's Occupation</label>
                                                        <input type="text" class="form-control" id="motherwork" name="motherwork" placeholder="Mother's Occupation" required value="<?php if (!empty($irow['motherwork'])) {
                                                                                                                                                                                        echo $irow['motherwork'];
                                                                                                                                                                                    } ?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="mothercompany">Mother's Company</label>
                                                        <input type="text" class="form-control" id="mothercompany" name="mothercompany" placeholder="Mother's Company" required value="<?php if (!empty($irow['mcompany'])) {
                                                                                                                                                                                            echo $irow['mcompany'];
                                                                                                                                                                                        } ?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="msalaryrange">Average Monthly Salary</label>
                                                        <select class="custom-select" id="msalaryrange" class="form-select" name="msalaryrange">
                                                            <option value="<?php if (!empty($irow['msalary'])) {
                                                                                echo $irow['msalary'];
                                                                            } ?>" selected><?php if (!empty($irow['msalary'])) {
                                                                                                                                                            echo $irow['msalary'];
                                                                                                                                                        } ?></option>
                                                            <option value="">-- select one --</option>
                                                            <option value="P 0 - P 50 000">P 0 - P 50 000</option>
                                                            <option value="P 50 001 - P 100 000">P 50 001 - P 100 000</option>
                                                            <option value="P 100 001 - P 200 000">P 100 001 - P 200 000</option>
                                                            <option value="P 200 001 - P 500 000">P 200 001 - P 500 000</option>
                                                            <option value="P 500 001 - UP">P 500 001 - UP</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row my-3">
                                                    <div class="col-lg-2">
                                                        <label for="english1">English Reading and Writing</label>
                                                        <select class="custom-select" id="english1" class="form-select" name="english1" required>
                                                            <option value="<?php if (!empty($irow['englishrw'])) {
                                                                                echo $irow['englishrw'];
                                                                            } ?>" selected><?php if (!empty($irow['englishrw'])) {
                                                                                                                                                                echo $irow['englishrw'];
                                                                                                                                                            } ?></option>
                                                            <option value="" disabled>-- select one --</option>
                                                            <option value="Good">Good</option>
                                                            <option value="Fair">Fair</option>
                                                            <option value="Limited">Limited</option>
                                                            <option value="None">None</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="english2">English Verbal Proficiency</label>
                                                        <select class="custom-select" id="english2" class="form-select" name="english2" required>
                                                            <option value="<?php if (!empty($irow['englishv'])) {
                                                                                echo $irow['englishv'];
                                                                            } ?>" selected><?php if (!empty($irow['englishv'])) {
                                                                                                                                                            echo $irow['englishv'];
                                                                                                                                                        } ?></option>
                                                            <option value="" disabled>-- select one --</option>
                                                            <option value="Good">Good</option>
                                                            <option value="Fair">Fair</option>
                                                            <option value="Limited">Limited</option>
                                                            <option value="None">None</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="lang">Major Languages at home</label>
                                                        <input type="text" class="form-control" id="lang" name="lang" placeholder="Major Languages at home" required value="<?php if (!empty($irow['languages'])) {
                                                                                                                                                                                echo $irow['languages'];
                                                                                                                                                                            } ?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="alc">ALC</label>
                                                        <input type="text" class="form-control" id="alc" name="alc" placeholder="ALC" required value="<?php if (!empty($irow['advclasses'])) {
                                                                                                                                                            echo $irow['advclasses'];
                                                                                                                                                        } ?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="remedial">Remedial School</label>
                                                        <input type="text" class="form-control" id="remedial" name="remedial" placeholder="Remedial School" required value="<?php if (!empty($irow['remedial'])) {
                                                                                                                                                                                echo $irow['remedial'];
                                                                                                                                                                            } ?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="skill">Special Skill</label>
                                                        <input type="text" class="form-control" id="skill" name="skill" placeholder="Special Skill" required value="<?php if (!empty($irow['skill'])) {
                                                                                                                                                                        echo $irow['skill'];
                                                                                                                                                                    } ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 mt-5 text-center">
                                                        <p class="h2">Medical Information and Health History</p>
                                                        <hr>
                                                    </div>
                                                </div>
                                                <div class="row my-3">
                                                    <div class="col-lg-1 ">
                                                        <label for="asthma">Asthma</label>
                                                        <select class="custom-select" id="asthma" class="form-select" name="asthma" required>
                                                            <option value="<?php if (!empty($irow['ashtma'])) {
                                                                                echo $irow['ashtma'];
                                                                            } ?>" selected><?php if (!empty($irow['ashtma'])) {
                                                                                                                                                        echo $irow['ashtma'];
                                                                                                                                                    } ?></option>
                                                            <option value="">-- select one --</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="asthmadets">Asthma Remarks</label>
                                                        <input type="text" class="form-control" id="asthmadets" name="asthmadets" placeholder="Asthma Remarks" required value="<?php if (!empty($irow['ashtmar'])) {
                                                                                                                                                                                    echo $irow['ashtmar'];
                                                                                                                                                                                } ?>">
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <label for="allergies">Allergy</label>
                                                        <select class="custom-select" id="allergies" class="form-select" name="allergies" required>
                                                            <option value="<?php if (!empty($irow['allergy'])) {
                                                                                echo $irow['allergy'];
                                                                            } ?>" selected><?php if (!empty($irow['allergy'])) {
                                                                                                                                                            echo $irow['allergy'];
                                                                                                                                                        } ?></option>
                                                            <option value="">-- select one --</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="allergiesdets">Allergy Remarks</label>
                                                        <input type="text" class="form-control" id="allergiesdets" name="allergiesdets" placeholder="Allergy Remarks" required value="<?php if (!empty($irow['allergyr'])) {
                                                                                                                                                                                            echo $irow['allergyr'];
                                                                                                                                                                                        } ?>">
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <label for="dallergies">Drug Allergy</label>
                                                        <select class="custom-select" id="dallergies" class="form-select" name="dallergies" required>
                                                            <option value="<?php if (!empty($irow['allergyr'])) {
                                                                                echo $irow['allergyr'];
                                                                            } ?>" selected><?php if (!empty($irow['allergyr'])) {
                                                                                                                                                            echo $irow['allergyr'];
                                                                                                                                                        } ?></option>allergyr
                                                            <option value="">-- select one --</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="dallergiesdets">Drug Allergy Remarks</label>
                                                        <input type="text" class="form-control" id="dallergiesdets" name="dallergiesdets" placeholder="Drug Allergy Remarks" required value="<?php if (!empty($irow['drugr'])) {
                                                                                                                                                                                                    echo $irow['drugr'];
                                                                                                                                                                                                } ?>">
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <label for="speech">Speech</label>
                                                        <select class="custom-select" id="speech" class="form-select" name="speech" required>
                                                            <option value="<?php if (!empty($irow['speech'])) {
                                                                                echo $irow['speech'];
                                                                            } ?>" selected><?php if (!empty($irow['speech'])) {
                                                                                                                                                        echo $irow['speech'];
                                                                                                                                                    } ?></option>
                                                            <option value="">-- select one --</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="speechdets">Speech Remarks</label>
                                                        <input type="text" class="form-control" id="speechdets" name="speechdets" placeholder="Speech Remarks" required value="<?php if (!empty($irow['speechr'])) {
                                                                                                                                                                                    echo $irow['speechr'];
                                                                                                                                                                                } ?>">
                                                    </div>
                                                </div>
                                                <div class="row my-3">
                                                    <div class="col-lg-1 ">
                                                        <label for="vision">Vision</label>
                                                        <select class="custom-select" id="vision" class="form-select" name="vision" required>
                                                            <option value="<?php if (!empty($irow['vision'])) {
                                                                                echo $irow['vision'];
                                                                            } ?>" selected><?php if (!empty($irow['vision'])) {
                                                                                                                                                        echo $irow['vision'];
                                                                                                                                                    } ?></option>
                                                            <option value="">-- select one --</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label for="visiondets">Vision Remarks</label>
                                                        <input type="text" class="form-control" id="visiondets" name="visiondets" placeholder="Vision Remarks" required value="<?php if (!empty($irow['visionr'])) {
                                                                                                                                                                                    echo $irow['visionr'];
                                                                                                                                                                                } ?>">
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <label for="hearing">Hearing Problems</label>
                                                        <select class="custom-select" id="hearing" class="form-select" name="hearing" required>
                                                            <option value="<?php if (!empty($irow['hearing'])) {
                                                                                echo $irow['hearing'];
                                                                            } ?>" selected><?php if (!empty($irow['hearing'])) {
                                                                                                                                                            echo $irow['hearing'];
                                                                                                                                                        } ?></option>
                                                            <option value="">-- select one --</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label for="hearingdets">Hearing Remarks</label>
                                                        <input type="text" class="form-control" id="hearingdets" name="hearingdets" placeholder="Hearing Remarks" required value="<?php if (!empty($irow['hearingr'])) {
                                                                                                                                                                                        echo $irow['hearingr'];
                                                                                                                                                                                    } ?>">
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <label for="adhd">ADHD</label>
                                                        <select class="custom-select" id="adhd" class="form-select" name="adhd" required>
                                                            <option value="<?php if (!empty($irow['adhd'])) {
                                                                                echo $irow['adhd'];
                                                                            } ?>" selected><?php if (!empty($irow['adhd'])) {
                                                                                                                                                    echo $irow['adhd'];
                                                                                                                                                } ?></option>
                                                            <option value="">-- select one --</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label for="adhddets">ADHD Remarks</label>
                                                        <input type="text" class="form-control" id="adhddets" name="adhddets" placeholder="ADHD Remarks" required value="<?php if (!empty($irow['adhdr'])) {
                                                                                                                                                                                echo $irow['adhdr'];
                                                                                                                                                                            } ?>">
                                                    </div>
                                                </div>
                                                <div class="row my-3">
                                                    <div class="col-lg-6">
                                                        <label for="healthcond">Any other health condition that te school should be aware of?</label>
                                                        <input type="text" class="form-control" id="healthcond" name="healthcond" placeholder="Other Conditions" required value="<?php if (!empty($irow['healthcond'])) {
                                                                                                                                                                                        echo $irow['healthcond'];
                                                                                                                                                                                    } ?>">
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label for="hospitalization">Has your child recently been hospitalized?</label>
                                                        <input type="text" class="form-control" id="hospitalization" name="hospitalization" placeholder="Hospitalization" required value="<?php if (!empty($irow['hospitalization'])) {
                                                                                                                                                                                                echo $irow['hospitalization'];
                                                                                                                                                                                            } ?>">
                                                    </div>
                                                </div>
                                                <div class="row my-3">
                                                    <div class="col-lg-6">
                                                        <label for="injuries">Has your child recently had any serious injuries? Why?</label>
                                                        <input type="text" class="form-control" id="injuries" name="injuries" placeholder="Injuries" required value="<?php if (!empty($irow['injuries'])) {
                                                                                                                                                                            echo $irow['injuries'];
                                                                                                                                                                        } ?>">
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label for="medication">Is your child on regular medication?</label>
                                                        <input type="text" class="form-control" id="medication" name="medication" placeholder="State name of Medication and Frequency" required value="<?php if (!empty($irow['medication'])) {
                                                                                                                                                                                                            echo $irow['medication'];
                                                                                                                                                                                                        } ?>">
                                                    </div>
                                                </div>
                                                <div class="row my-3">
                                                    <div class="col-lg-2">
                                                        <label for="general">General Health</label>
                                                        <select class="custom-select" id="general" class="form-select" name="general" required>
                                                            <option value="<?php if (!empty($irow['general'])) {
                                                                                echo $irow['general'];
                                                                            } ?>" selected><?php if (!empty($irow['general'])) {
                                                                                                                                                            echo $irow['general'];
                                                                                                                                                        } ?></option>
                                                            <option value="">-- select one --</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label for="generaldets">HG Remarks</label>
                                                        <input type="text" class="form-control" id="generaldets" name="generaldets" placeholder="HG Remarks" required value="<?php if (!empty($irow['generaldets'])) {
                                                                                                                                                                                    echo $irow['generaldets'];
                                                                                                                                                                                } ?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="psych">Psychological</label>
                                                        <select class="custom-select" id="psych" class="form-select" name="psych" required>
                                                            <option value="<?php if (!empty($irow['psych'])) {
                                                                                echo $irow['psych'];
                                                                            } ?>" selected><?php if (!empty($irow['psych'])) {
                                                                                                                                                        echo $irow['psych'];
                                                                                                                                                    } ?></option>
                                                            <option value="">-- select one --</option>
                                                            <option value="Psychiatrist">Psychiatrist</option>
                                                            <option value="Psychologist">Psychologist</option>
                                                            <option value="Counselor">Counselor</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label for="psychdets">Psychological Remarks</label>
                                                        <input type="text" class="form-control" id="psychdets" name="psychdets" placeholder="Psychological Remarks" required value="<?php if (!empty($irow['psychdets'])) {
                                                                                                                                                                                        echo $irow['psychdets'];
                                                                                                                                                                                    } ?>">
                                                    </div>
                                                </div>
                                                <div class="row my-3">
                                                    <div class="col-lg-3">
                                                        <label for="minor">Consent</label>
                                                        <select class="custom-select" id="minor" class="form-select" name="minor" required>
                                                            <option value="<?php if (!empty($irow['minor'])) {
                                                                                echo $irow['minor'];
                                                                            } ?>" selected><?php if (!empty($irow['minor'])) {
                                                                                                                                                        echo $irow['minor'];
                                                                                                                                                    } ?></option>
                                                            <option value="" disabled>Minor First Aid</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label for="emergency">Emergency Care</label>
                                                        <select class="custom-select" id="emergency" class="form-select" name="emergency" required>
                                                            <option value="<?php if (!empty($irow['emergency'])) {
                                                                                echo $irow['emergency'];
                                                                            } ?>" selected><?php if (!empty($irow['emergency'])) {
                                                                                                                                                                echo $irow['emergency'];
                                                                                                                                                            } ?></option>
                                                            <option value="" disabled>Emergency Care</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label for="hospital">Emergency Care at Hospital</label>
                                                        <select class="custom-select" id="hospital" class="form-select" name="hospital" required>
                                                            <option value="<?php if (!empty($irow['hospital'])) {
                                                                                echo $irow['hospital'];
                                                                            } ?>" selected><?php if (!empty($irow['hospital'])) {
                                                                                                                                                            echo $irow['hospital'];
                                                                                                                                                        } ?></option>
                                                            <option value="" disabled>Emergency Care at Hospital</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label for="otc">Oral OTC Medication</label>
                                                        <select class="custom-select" id="otc" class="form-select" name="otc" required>
                                                            <option value="<?php if (!empty($irow['otc'])) {
                                                                                echo $irow['otc'];
                                                                            } ?>" selected><?php if (!empty($irow['otc'])) {
                                                                                                                                                    echo $irow['otc'];
                                                                                                                                                } ?></option>
                                                            <option value="" disabled>Oral OTC Medication</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                        </select>
                                                    </div>
                                                <?php } ?>
                                                </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                    </div>

                    </form>
                    <!-- form ends !-->
                </div>
            <?php
            } ?>
            <?php include_once "includes/footer.php"; ?>
        </div>
        <?php include_once "includes/scripts.php"; ?>
    </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        // alert('LOAD');
        $('input').attr("disabled", true);
        $('select').attr("disabled", true);
    });
</script>

</html>
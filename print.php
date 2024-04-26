<?php include_once "includes/config.php"; ?>
<!DOCTYPE html>
<html lang="en">

<?php include_once "includes/css.php"; ?>

<body onload="window.print();">
    <?php
    $pdo_statement = $DB_con->prepare("SELECT * FROM users24 WHERE id = :id ");
    $pdo_statement->execute(array(":id" => $_GET['id']));
    $result = $pdo_statement->fetchAll();
    foreach ($result as $row) {
    ?>
        <form action="newstudent.php" method="post">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body py-2 my-0">
                            <div class="row ml-2">
                                <div class="col-sm-2"><img class="rounded" style="width: 150px" src="assets/images/avatars/<?php
                                                                                                                            if (empty($row["photo"])) {
                                                                                                                                echo "avatar.jpg";
                                                                                                                            } else {
                                                                                                                                echo $row["photo"];
                                                                                                                            } ?>">
                                </div>
                                <div class="col-sm-10">
                                    <h1 class="display-4"><?php echo $row["lname"] . ", " . $row["fname"] . " " . $row["mname"] ?></h1>
                                </div>
                            </div>
                            <hr class="mb-0">
                            <div class="row mx-auto pt-3">
                                <div class="col-sm-2">
                                    <label for="sy">SY</label>
                                    <input type="text" class="form-control px-0" id="sy" name="sy" value="2023-24" required disabled>
                                </div>
                                <div class="col-sm-2">
                                    <label for="dob">Date of Birth:</label>
                                    <input class="form-control px-0" id="dob" name="dob" disabled required value="<?php echo date("m/d/Y", strtotime($row["dob"])); ?>">
                                </div>
                                <div style="width:4.1%">
                                    <?php
                                    function getAge($date)
                                    {
                                        return intval(date('Y', time() - strtotime($date))) - 1970;
                                    }
                                    ?>
                                    <label for="age">Age:</label>
                                    <input class="form-control px-0" type="text" id="age" name="age" disabled required value="<?php echo getAge($row["dob"]); ?>">
                                </div>
                                <div class="col-sm-2">
                                    <label for="lrn">Learner's Reference Number:</label>
                                    <input class="form-control px-0" type="text" id="lrn" name="lrn" value="<?php echo $row["lrn"]; ?>" disabled>
                                </div>
                                <div class="col-sm-2">
                                    <label for="grade">Grade</label>
                                    <input class="form-control px-0" type="text" id="grade" name="grade" value="<?php echo ucfirst($row["grade"]); ?>" disabled>
                                </div>
                                <div style="width:4.1%">
                                    <label for="section">Section</label>
                                    <input class="form-control px-0" type="text" id="grade" name="grade" value="<?php echo ucfirst($row["section"]); ?>" disabled>
                                </div>
                                <div class="col-sm-3">
                                    <label for="oldschool">Previous School</label>
                                    <input class="form-control px-0" type="text" id="oldschool" name="oldschool" value="<?php echo $row["prevsch"]; ?>" disabled>
                                </div>
                            </div>
                            <div class="row mx-auto px-0 py-0 pt-2">
                                <div class="col-sm-6 mx-auto">
                                    <label for="prevschcountry">Country</label>
                                    <input type="text" class="form-control" id="prevschcountry" name="prevschcountry" value="<?php echo $row["prevschcountry"]; ?>" disabled>
                                </div>
                                <div class="col-sm-6 mx-auto">
                                    <label for="nationality">Nationality</label>
                                    <input type="text" class="form-control" id="nationality" name="nationality" value="<?php echo ucfirst($row["nationality"]); ?>" disabled>
                                </div>
                            </div>
                            <div class="row pt-3 mx-auto">
                                <div class="col-sm-3">
                                    <label for="guardian">Guardian's Name</label>
                                    <input type="text" class="form-control" id="guardian" name="guardian" placeholder="Guardian's Name" required value="<?php echo $row["guardianname"]; ?>" disabled>
                                </div>
                                <div class="col-sm-3">
                                    <label for="guardianemail">Guardian's Email</label>
                                    <input type="text" class="form-control" id="guardianemail" name="guardianemail" placeholder="Guardian's Email" required value="<?php echo $row["guardianemail"]; ?>" disabled>
                                </div>
                                <div class="col-sm-3">
                                    <label for="guardianphone">Guardian's Phone Number</label>
                                    <input type="text" class="form-control px-0" id="guardianphone" name="guardianphone" placeholder="Guardian's Phone Number" required value="<?php echo $row["guardianphone"]; ?>" disabled>
                                </div>
                                <div class="col-sm-3">
                                    <label for="referral" class="nowrap">How did you learn about WIS?</label>
                                    <select class="custom-select text-center" id="referral" class="form-select" name="referral" disabled>
                                        <option value="<?php echo $row["referral"]; ?>"><?php echo ucfirst($row["referral"]); ?></option>
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

                            <hr class="mt-3 mb-2 p-0">
                            <!-- Seperator -->
                            <div class="row p-0 mx-auto">
                                <div class="col-lg-12 text-center">
                                    <p class="h2">Additional Details</p>
                                    <hr class="py-0 my-0">
                                </div>
                            </div>

                            <?php
                            $info_statement = $DB_con->prepare("SELECT * FROM studentdetails WHERE uniqid = :uniqid");
                            $info_statement->execute(array(":uniqid" => $row['uniqid']));
                            $iresult = $info_statement->fetchAll();
                            foreach ($iresult as $irow) {
                            ?>

                                <div class="row mx-auto px-0 py-0 pt-2">
                                    <div class="col-sm-4">
                                        <label for="street">Number and Street</label>
                                        <input type="text" class="form-control" id="street" name="street" placeholder="Number and Street" required value="<?php if (!empty($irow['street'])) {
                                                                                                                                                                echo $irow['street'];
                                                                                                                                                            } ?>">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="barangay">Barangay / Subdivision</label>
                                        <input type="text" class="form-control" id="barangay" name="barangay" placeholder="Barangay/Subdivision" required value="<?php if (!empty($irow['barangay'])) {
                                                                                                                                                                        echo $irow['barangay'];
                                                                                                                                                                    } ?>">
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="city">City</label>
                                        <input type="text" class="form-control" id="city" name="city" placeholder="City" required value="<?php if (!empty($irow['city'])) {
                                                                                                                                                echo $irow['city'];
                                                                                                                                            } ?>">
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="postal">Postal Code</label>
                                        <input type="text" class="form-control" id="postal" name="postal" placeholder="Postal Code" required value="<?php if (!empty($irow['postal'])) {
                                                                                                                                                        echo $irow['postal'];
                                                                                                                                                    } ?>">
                                    </div>
                                </div>

                                <div class="row mx-auto px-0 py-0 pt-2">
                                    <div style="width:33.33%" class="col">
                                        <label for="father">Father's Name</label>
                                        <input type="text" class="form-control px-0" id="father" name="father" placeholder="Father's Name" required value="<?php if (!empty($irow['street'])) {
                                                                                                                                                                echo $irow['street'];
                                                                                                                                                            } ?>">
                                    </div>
                                    <div style="width:33.33%">
                                        <label for="fathermail">Father's Email</label>
                                        <input type="text" class="form-control px-0" id="fathermail" name="fathermail" placeholder="Father's Email" required value="<?php if (!empty($irow['fathermail'])) {
                                                                                                                                                                        echo $irow['fathermail'];
                                                                                                                                                                    } ?>">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="fatherphone">Father's Phone Number</label>
                                        <input type="text" class="form-control px-0" id="fatherphone" name="fatherphone" placeholder="Father's Phone Number" required value="<?php if (!empty($irow['fathernumber'])) {
                                                                                                                                                                                    echo $irow['fathernumber'];
                                                                                                                                                                                } ?>">
                                    </div>
                                </div>


                                <div class="row mx-auto px-0 py-0 pt-2">
                                    <div style="width:33.33%" class="col">
                                        <label for="fatherwork">Father's Occupation</label>
                                        <input type="text" class="form-control px-0" id="fatherwork" name="fatherwork" placeholder="Father's Occupation" required value="<?php if (!empty($irow['fatherwork'])) {
                                                                                                                                                                                echo $irow['fatherwork'];
                                                                                                                                                                            } ?>">
                                    </div>
                                    <div style="width:33.33%">
                                        <label for="fathercompany">Father's Company</label>
                                        <input type="text" class="form-control px-0" id="fathercompany" name="fathercompany" placeholder="Father's Company" required value="<?php if (!empty($irow['fatherwork'])) {
                                                                                                                                                                                echo $irow['fatherwork'];
                                                                                                                                                                            } ?>">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="fsalaryrange">Average Monthly Salary</label>
                                        <select class="custom-select text-center" id="fsalaryrange" class="form-select" name="fsalaryrange">
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

                                <div class="row mx-auto px-0 py-0 pt-2">
                                    <div style="width:33.33%" class="col">
                                        <label for="mother">Mother's Name</label>
                                        <input type="text" class="form-control px-0" id="mother" name="mother" placeholder="Mother's Name" required value="<?php if (!empty($irow['mother'])) {
                                                                                                                                                                echo $irow['mother'];
                                                                                                                                                            } ?>">
                                    </div>
                                    <div style="width:33.33%">
                                        <label for="mothermail">Mother's Email</label>
                                        <input type="text" class="form-control px-0" id="mothermail" name="mothermail" placeholder="Mother's Email" required value="<?php if (!empty($irow['mothermail'])) {
                                                                                                                                                                        echo $irow['mothermail'];
                                                                                                                                                                    } ?>">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="motherphone">Mothers's Phone Number</label>
                                        <input type="text" class="form-control px-0" id="motherphone" name="motherphone" placeholder="Mothers's Phone Number" required value="<?php if (!empty($irow['mothernumber'])) {
                                                                                                                                                                                    echo $irow['mothernumber'];
                                                                                                                                                                                } ?>">
                                    </div>
                                </div>

                                <div class="row mx-auto px-0 py-0 pt-2">
                                    <div style="width:33.33%" class="col">
                                        <label for="motherwork">Mother's Occupation</label>
                                        <input type="text" class="form-control px-0" id="motherwork" name="motherwork" placeholder="Mother's Occupation" required value="<?php if (!empty($irow['motherwork'])) {
                                                                                                                                                                                echo $irow['motherwork'];
                                                                                                                                                                            } ?>">
                                    </div>
                                    <div style="width:33.33%">
                                        <label for="mothercompany">Mother's Company</label>
                                        <input type="text" class="form-control px-0" id="mothercompany" name="mothercompany" placeholder="Mother's Company" required value="<?php if (!empty($irow['mcompany'])) {
                                                                                                                                                                                echo $irow['mcompany'];
                                                                                                                                                                            } ?>">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="msalaryrange">Average Monthly Salary</label>
                                        <select class="custom-select text-center" id="msalaryrange" class="form-select" name="msalaryrange">
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

                                <hr class="mt-3 mb-2 p-0">

                                <div class="row mx-auto">
                                    <div class="col-sm-3">
                                        <label for="english1">English Reading and Writing</label>
                                        <select class="custom-select text-center" id="english1" class="form-select" name="english1" required>
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
                                    <div class="col-sm-3">
                                        <label for="english2">English Verbal Proficiency</label>
                                        <select class="custom-select text-center" id="english2" class="form-select" name="english2" required>
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
                                    <div class="col-sm-6">
                                        <label for="lang">Major Languages at home</label>
                                        <input type="text" class="form-control px-0" id="lang" name="lang" placeholder="Major Languages at home" required value="<?php if (!empty($irow['languages'])) {
                                                                                                                                                                        echo $irow['languages'];
                                                                                                                                                                    } ?>">
                                    </div>
                                </div>

                                <div class="row mx-auto">
                                    <div class="col-sm-3">
                                        <label for="alc">ALC</label>
                                        <input type="text" class="form-control px-0" id="alc" name="alc" placeholder="ALC" required value="<?php if (!empty($irow['advclasses'])) {
                                                                                                                                                echo $irow['advclasses'];
                                                                                                                                            } ?>">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="skill">Special Skill</label>
                                        <input type="text" class="form-control px-0" id="skill" name="skill" placeholder="Special Skill" required value="<?php if (!empty($irow['skill'])) {
                                                                                                                                                                echo $irow['skill'];
                                                                                                                                                            } ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="remedial">Remedial School</label>
                                        <input type="text" class="form-control px-0" id="remedial" name="remedial" placeholder="Remedial School" required value="<?php if (!empty($irow['remedial'])) {
                                                                                                                                                                        echo $irow['remedial'];
                                                                                                                                                                    } ?>">
                                    </div>
                                </div>

                                <hr class="mt-3 mb-2 p-0">
                                <!-- Seperator -->
                                <div class="row p-0 mx-auto">
                                    <div class="col-lg-12 text-center">
                                        <p class="h2">Medical Information and Health History</p>
                                        <hr class="py-0 my-0">
                                    </div>
                                </div>

                                <div class="row mx-auto pt-2">
                                    <div class="col-sm-1">
                                        <label for="asthma">Asthma</label>
                                        <select class="custom-select text-center px-0" id="asthma" class="form-select" name="asthma" required>
                                            <option value="
                                                <?php if (!empty($irow['ashtma'])) {
                                                    echo $irow['ashtma'];
                                                } ?>" selected>
                                                <?php if (!empty($irow['ashtma'])) {
                                                    echo $irow['ashtma'];
                                                } ?></option>
                                            <option value="">-- select one --</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                    <div style="width:12.495%" class="col">
                                        <label for="asthmadets">Asthma Remarks</label>
                                        <input type="text" class="form-control" id="asthmadets" name="asthmadets" placeholder="Asthma Remarks" required value="<?php if (!empty($irow['ashtmar'])) {
                                                                                                                                                                    echo $irow['ashtmar'];
                                                                                                                                                                } ?>">
                                    </div>
                                    <div class="col-sm-1">
                                        <label for="allergies">Allergy</label>
                                        <select class="custom-select text-center px-0" id="allergies" class="form-select" name="allergies" required>
                                            <option value="
                                                <?php if (!empty($irow['allergy'])) {
                                                    echo $irow['allergy'];
                                                } ?>" selected>
                                                <?php if (!empty($irow['allergy'])) {
                                                    echo $irow['allergy'];
                                                } ?></option>
                                            <option value="">-- select one --</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                    <div style="width:12.495%" class="col">
                                        <label for="allergiesdets">Allergy Remarks</label>
                                        <input type="text" class="form-control" id="allergiesdets" name="allergiesdets" placeholder="Allergy Remarks" required value="<?php if (!empty($irow['allergyr'])) {
                                                                                                                                                                            echo $irow['allergyr'];
                                                                                                                                                                        } ?>">
                                    </div>
                                    <div class="col-sm-1">
                                        <label for="dallergies">Drug Allergy</label>
                                        <select class="custom-select text-center px-0" id="dallergies" class="form-select" name="dallergies" required>
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
                                    <div style="width:12.495%" class="col">
                                        <label for="dallergiesdets">Drug Allergy Remarks</label>
                                        <input type="text" class="form-control" id="dallergiesdets" name="dallergiesdets" placeholder="Drug Allergy Remarks" required value="<?php if (!empty($irow['drugr'])) {
                                                                                                                                                                                    echo $irow['drugr'];
                                                                                                                                                                                } ?>">
                                    </div>
                                    <div class="col-sm-1">
                                        <label for="speech">Speech</label>
                                        <select class="custom-select text-center px-0" id="speech" class="form-select" name="speech" required>
                                            <option value="<?php if (!empty($irow['speech'])) {
                                                                echo $irow['speech'];
                                                            } ?>" selected>
                                                <?php if (!empty($irow['speech'])) {
                                                    echo $irow['speech'];
                                                } ?></option>
                                            <option value="">-- select one --</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                    <div style="width:12.495%" class="col">
                                        <label for="speechdets">Speech Remarks</label>
                                        <input type="text" class="form-control" id="speechdets" name="speechdets" placeholder="Speech Remarks" required value="<?php if (!empty($irow['speechr'])) {
                                                                                                                                                                    echo $irow['speechr'];
                                                                                                                                                                } ?>">
                                    </div>
                                </div>
                                <div class="row mx-auto px-0 py-0 pt-2">
                                    <div style="width: 12.495%" class="col">
                                        <label for="vision">Vision</label>
                                        <select class="custom-select px-0 text-center" id="vision" class="form-select" name="vision" required>
                                            <option value="<?php if (!empty($irow['vision'])) {
                                                                echo $irow['vision'];
                                                            } ?>" selected>
                                                <?php if (!empty($irow['vision'])) {
                                                    echo $irow['vision'];
                                                } ?></option>
                                            <option value="">-- select one --</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="visiondets">Vision Remarks</label>
                                        <input type="text" class="form-control" id="visiondets" name="visiondets" placeholder="Vision Remarks" required value="<?php if (!empty($irow['visionr'])) {
                                                                                                                                                                    echo $irow['visionr'];
                                                                                                                                                                } ?>">
                                    </div>
                                    <div style="width: 12.495%" class="col">
                                        <label for="hearing">Hearing Problems</label>
                                        <select class="custom-select px-0 text-center" id="hearing" class="form-select" name="hearing" required>
                                            <option value="<?php if (!empty($irow['hearing'])) {
                                                                echo $irow['hearing'];
                                                            } ?>" selected>
                                                <?php if (!empty($irow['hearing'])) {
                                                    echo $irow['hearing'];
                                                } ?></option>
                                            <option value="">-- select one --</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="hearingdets">Hearing Remarks</label>
                                        <input type="text" class="form-control" id="hearingdets" name="hearingdets" placeholder="Hearing Remarks" required value="<?php if (!empty($irow['hearingr'])) {
                                                                                                                                                                        echo $irow['hearingr'];
                                                                                                                                                                    } ?>">
                                    </div>
                                    <div style="width: 12.495%" class="col">
                                        <label for="adhd">ADHD</label>
                                        <select class="custom-select px-0 text-center" id="adhd" class="form-select" name="adhd" required>
                                            <option value="<?php if (!empty($irow['adhd'])) {
                                                                echo $irow['adhd'];
                                                            } ?>" selected>
                                                <?php if (!empty($irow['adhd'])) {
                                                    echo $irow['adhd'];
                                                } ?></option>
                                            <option value="">-- select one --</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="adhddets">ADHD Remarks</label>
                                        <input type="text" class="form-control" id="adhddets" name="adhddets" placeholder="ADHD Remarks" required value="<?php if (!empty($irow['adhdr'])) {
                                                                                                                                                                echo $irow['adhdr'];
                                                                                                                                                            } ?>">
                                    </div>
                                </div>
                                <div class="row mx-auto px-0 py-0 pt-2">
                                    <div class="col-sm-6">
                                        <label for="healthcond">Any other health condition that the school should be aware of?</label>
                                        <input type="text" class="form-control px-0" id="healthcond" name="healthcond" placeholder="Other Conditions" required value="<?php if (!empty($irow['healthcond'])) {
                                                                                                                                                                            echo $irow['healthcond'];
                                                                                                                                                                        } ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="hospitalization">Has your child recently been hospitalized?</label>
                                        <input type="text" class="form-control px-0" id="hospitalization" name="hospitalization" placeholder="Hospitalization" required value="<?php if (!empty($irow['hospitalization'])) {
                                                                                                                                                                                    echo $irow['hospitalization'];
                                                                                                                                                                                } ?>">
                                    </div>
                                </div>
                                <div class="row mx-auto px-0 py-0 pt-2">
                                    <div class="col-sm-6">
                                        <label for="injuries">Has your child recently had any serious injuries? Why?</label>
                                        <input type="text" class="form-control px-0" id="injuries" name="injuries" placeholder="Injuries" required value="<?php if (!empty($irow['injuries'])) {
                                                                                                                                                                echo $irow['injuries'];
                                                                                                                                                            } ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="medication">Is your child on regular medication?</label>
                                        <input type="text" class="form-control px-0" id="medication" name="medication" placeholder="State name of Medication and Frequency" required value="<?php if (!empty($irow['medication'])) {
                                                                                                                                                                                                echo $irow['medication'];
                                                                                                                                                                                            } ?>">
                                    </div>
                                </div>
                                <div class="row mx-auto px-0 py-0 pt-2">
                                    <div class="col-sm-3">
                                        <label for="general">General Health</label>
                                        <select class="custom-select text-center" id="general" class="form-select" name="general" required>
                                            <option value="
                                                <?php if (!empty($irow['general'])) {
                                                    echo $irow['general'];
                                                } ?>" selected>
                                                <?php if (!empty($irow['general'])) {
                                                    echo $irow['general'];
                                                } ?></option>
                                            <option value="">-- select one --</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="generaldets">HG Remarks</label>
                                        <input type="text" class="form-control" id="generaldets" name="generaldets" placeholder="HG Remarks" required value="<?php if (!empty($irow['generaldets'])) {
                                                                                                                                                                    echo $irow['generaldets'];
                                                                                                                                                                } ?>">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="psych">Psychological</label>
                                        <select class="custom-select text-center" id="psych" class="form-select" name="psych" required>
                                            <option value="<?php if (!empty($irow['psych'])) {
                                                                echo $irow['psych'];
                                                            } ?>" selected>
                                                <?php if (!empty($irow['psych'])) {
                                                    echo $irow['psych'];
                                                } ?></option>
                                            <option value="">-- select one --</option>
                                            <option value="Psychiatrist">Psychiatrist</option>
                                            <option value="Psychologist">Psychologist</option>
                                            <option value="Counselor">Counselor</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="psychdets">Psychological Remarks</label>
                                        <input type="text" class="form-control" id="psychdets" name="psychdets" placeholder="Psychological Remarks" required value="<?php if (!empty($irow['psychdets'])) {
                                                                                                                                                                        echo $irow['psychdets'];
                                                                                                                                                                    } ?>">
                                    </div>
                                </div>
                                <div class="row mx-auto px-0 py-0 pt-2">
                                    <div class="col-sm-3">
                                        <label for="minor">Consent</label>
                                        <select class="custom-select text-center" id="minor" class="form-select" name="minor" required>
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
                                    <div class="col-sm-3">
                                        <label for="emergency">Emergency Care</label>
                                        <select class="custom-select text-center" id="emergency" class="form-select" name="emergency" required>
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
                                    <div class="col-sm-3">
                                        <label for="hospital">Emergency Care at Hospital</label>
                                        <select class="custom-select text-center" id="hospital" class="form-select" name="hospital" required>
                                            <option value="
                                            <?php
                                            if (!empty($irow['hospital'])) {
                                            echo $irow['hospital'];
                                            } ?>" selected><?php if (!empty($irow['hospital'])) {
                                                                                echo $irow['hospital'];
                                                                            } ?></option>
                                            <option value="" disabled>Emergency Care at Hospital</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="otc">Oral OTC Medication</label>
                                        <select class="custom-select text-center" id="otc" class="form-select" name="otc" required>
                                            <option value="
                                        <?php if (!empty($irow['otc'])) {
                                            echo $irow['otc'];
                                        } ?>" selected>
                                                <?php if (!empty($irow['otc'])) {
                                                    echo $irow['otc'];
                                                } ?></option>
                                            <option value="" disabled>Oral OTC Medication</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row pt-2">
                                    <div class="col-lg-12 text-center">
                                    <label for="conforme">Conforme:</label>
                                        <input type="text" class="form-control form-control-lg" id="conforme" name="conforme">
                                    </div>
                                </div>

        </form>
<?php
                            }
                        } ?>
<script>
    function pageRedirect() {
        var delay = 3000;
        setTimeout(function() {
            window.location = "completed.php";
        }, delay);
    }
    pageRedirect();
</script>
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
<?php
include_once "includes/config.php";
session_start();
// $_SESSION['data'] = $_POST['data'];
// $_SESSION['data_another'] = $_POST['data_another'];
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
            <div class="page-container">
                <div class="main-content">
                    <!-- form starts !-->
                    <form id="myForm" action="newstudent.php" method="post">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header bg-warning rounded-top pt-2">
                                        <h4>
                                            <span class="icon-holder">
                                                <i class="anticon anticon-idcard"></i>
                                            </span>
                                            New Student Application Form
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-1">
                                                <label for="applicationtype">Status</label>
                                                <select class="custom-select" id="applicationtype" name="applicationtype" required autofocus>
                                                    <option value="Regular">New Applicant</option>
                                                    <option value="Early Bird">Early Bird</option>
                                                    <!-- <option value="Old Student">Old Student</option> -->
                                                    <option value="visiting">Visiting Student</option>
                                                    <option value="non-credit">Non-credit</option>
                                                    <option value="alp">ALP</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-1">
                                                <label for="syear">SY</label>
                                                <select class="form-control" id="syear" name="syear" required>
                                                    <option value="2024-25" selected>2024-25</option>
                                                    <option value="2025-26">2025-26</option>
                                                    <option value="2026-27">2026-27</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-1">
                                                <label for="type">Type</label>
                                                <select class="custom-select" id="type" name="type" required autofocus>
                                                    <option value="New Student">New Student</option>
                                                    <option value="Old Student">Old Student</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="lastname">Last Name</label>
                                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" required>
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="firstname">First Name</label>
                                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" required>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="middlename">Middle Name</label>
                                                <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Middle Name">
                                            </div>
                                            <div class="col-lg-1">
                                                <label for="gender">Gender</label>
                                                <select class="custom-select" id="gender" name="gender">
                                                    <option value="M">Male</option>
                                                    <option value="F">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row py-3">
                                            <div class="col-lg-2">
                                                <label for="dob">Birthdate</label>
                                                <input type="date" class="form-control" id="dob" name="dob" placeholder="Date of Birth" onchange="fnCalculateAge()" required>
                                            </div>
                                            <div class="col-lg-1">
                                                <label for="age">Age</label>
                                                <input type="text" class="form-control" id="age" name="age" disabled required>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="lrn">LRN</label>
                                                <input type="text" class="form-control" id="lrn" name="lrn">
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="oldschool">Previous School</label>
                                                <input type="text" class="form-control" id="oldschool" name="oldschool">
                                            </div>

                                            <?php

                                            $countryQuery = $DB_con->prepare("SELECT * FROM countries");
                                            $countryQuery->execute();
                                            $countries = $countryQuery->fetchAll(PDO::FETCH_OBJ);


                                            ?>
                                            <div class="col-lg-1">
                                                <label for="oldschoolctry">Country</label>
                                                <select id="countryName" name="countryName" class="form-control">
                                                    <option value="">-- select one --</option>
                                                    <?php
                                                    foreach ($countries as $country) {
                                                    ?>
                                                        <option value="<?= $country->countryName ?>"><?= $country->countryName ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <?php
                                            $nationalityQuery = $DB_con->prepare("SELECT * FROM nationalities");
                                            $nationalityQuery->execute();
                                            $nationalities = $nationalityQuery->fetchAll(PDO::FETCH_OBJ);
                                            ?>

                                            <div class="col-lg-1">
                                                <label for="nationality">Nationality 1</label>
                                                <select class="custom-select" id="nationalityName" name="nationalityName">

                                                    <option value="">-- select one --</option>
                                                    <?php
                                                    foreach ($nationalities as $nationality) {
                                                    ?>
                                                        <option value="<?= $nationality->nationalityName ?>"><?= $nationality->nationalityName ?></option>
                                                    <?php
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                            <div class="col-lg-1">
                                                <label for="nationality">Nationality 2</label>
                                                <select class="custom-select" id="nationalityName2" name="nationalityName2">

                                                    <option value="">-- select one --</option>
                                                    <?php
                                                    foreach ($nationalities as $nationality) {
                                                    ?>
                                                        <option value="<?= $nationality->nationalityName ?>"><?= $nationality->nationalityName ?></option>
                                                    <?php
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                            <div class="col-lg-1">
                                                <label for="gradelevel">Grade</label>
                                                <select class="custom-select" id="gradelevel" class="form-select" name="gradelevel" required>
                                                    <option value="">-- select one --</option>
                                                    <option value="Nursery">Toddler</option>
                                                    <option value="Toddler">Nursery</option>
                                                    <option value="Preschool">Pre-Kinder</option>
                                                    <option value="Kinder">Kinder</option>
                                                    <option value="Grade 1">Grade 1</option>
                                                    <option value="Grade 2">Grade 2</option>
                                                    <option value="Grade 3">Grade 3</option>
                                                    <option value="Grade 4">Grade 4</option>
                                                    <option value="Grade 5">Grade 5</option>
                                                    <option value="Grade 6">Grade 6</option>
                                                    <option value="Grade 7">Grade 7</option>
                                                    <option value="Grade 8">Grade 8</option>
                                                    <option value="Grade 9">Grade 9</option>
                                                    <option value="Grade 10">Grade 10</option>
                                                    <option value="Grade 11">Grade 11</option>
                                                    <option value="Grade 12">Grade 12</option>
                                                    <option value="CAIE-AS">CAIE - AS level</option>
                                                    <option value="CAIE-A">CAIE - A level</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-1" id="row12">
                                                <label for="strand" id="strandlbl">Strand:</label>
                                                <select class="custom-select" id="strand" class="form-select" name="strand">
                                                    <option value="">-- select one --</option>
                                                    <option value="GAS">GAS</option>
                                                    <option value="ABM">ABM</option>
                                                    <option value="HUMMS">HUMMS</option>
                                                    <option value="STEM">STEM</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <label for="guardian">Guardian's Name</label>
                                                <input type="text" class="form-control" id="guardian" name="guardian" placeholder="Guardian's Name" required>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="guardianemail">Guardian's Email</label>
                                                <input type="text" class="form-control" id="guardianemail" name="guardianemail" placeholder="Guardian's Email" required>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="guardianphone">Guardian's Phone Number</label>
                                                <input type="text" class="form-control" id="guardianphone" name="guardianphone" placeholder="Guardian's Phone Number" required>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="referral">How did you learn about WIS?</label>
                                                <select class="custom-select" id="referral" class="form-select" name="referral">
                                                    <option value="">-- select one --</option>
                                                    <option value="Website">Website</option>
                                                    <option value="Brochure">Brochure</option>
                                                    <option value="Poster">Poster</option>
                                                    <option value="Social Media">Social Media</option>
                                                    <option value="Search Engine">Search Engine</option>
                                                    <option value="Friends/Relatives">Friends/Relatives</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-1">
                                                <label for="religion">Religion</label>
                                                <input type="text" class="form-control" id="religion" name="religion" placeholder="Christianity" required>
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="visa" id="visalbl">Visa Status</label>
                                                <select class="custom-select" id="visa" class="form-select" name="visa">
                                                    <option value="NA">-- select one --</option>
                                                    <option value="Temporary Visitor's Visa">Temporary Visitor's Visa</option>
                                                    <option value="Special Non-Immigrant Visa">Special Non-Immigrant Visa</option>
                                                    <option value="Non-Quota Immigrant Visa">Non-Quota Immigrant Visa</option>
                                                    <option value="Quota Visa">Quota Visa</option>
                                                    <option value="Student Visa">Student Visa</option>
                                                    <option value="SRRV">Special Resident Retireee Visa</option>
                                                    <option value="SIRV">Special Investor's Resident Visa</option>
                                                    <option value="Treaty Trader Visa">Treaty Trader Visa</option>
                                                    <option value="Employee Visa">Employee Visa</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row py-3">
                                            <div class="col-lg-12">
                                                <h3 class="text-center">Need to Pay</h3>
                                            </div>
                                        </div>
                                            <style>
                                                .form-check {
                                                    display: flex;
                                                    align-items: center;
                                                }
                                                .form-check-input {
                                                    margin-right: 10px;
                                                }
                                            </style>
                                        <div class="row py-1">
                                            <div class="col-lg-5"></div>
                                            <div class="col-lg-1 text-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="assessmentFee" id="assessmentFee">
                                                    <label class="form-check-label" for="assessmentFee">Assessment Fee</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="afTuitionFee" id="afTuitionFee">
                                                    <label class="form-check-label" for="afTuitionFee">Tuition Fee</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="afTfOtherFees" id="afTfOtherFees">
                                                    <label class="form-check-label" for="afTfOtherFees">Other Fees</label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="applicationFee" id="applicationFee">
                                                    <label class="form-check-label" for="applicationFee">Reservation Fee</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="pta" id="pta">
                                                    <label class="form-check-label" for="pta">PTA</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 text-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="registrationFee" id="registrationFee">
                                                    <label class="form-check-label" for="registrationFee">Registration Fee</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="specialPermit" id="specialPermit">
                                                    <label class="form-check-label" for="specialPermit">SSP special study permit</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="internationalFeeOld" id="internationalFee">
                                                    <label class="form-check-label" for="internationalFeeOld">int'l student fee OLD</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="internationalFeeNew" id="internationalFee">
                                                    <label class="form-check-label" for="internationalFeeNew">int'l student fee NEW</label>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row py-3">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-8 text-center">
                                                <input type="text" class="form-control" name="notes" id="" placeholder="Notes here..">
                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div> 

                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row pt-5">
                                            <div class="col-lg-12">
                                                <h3 class="text-center">Terms and Conditions of Application</h3>
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div id="main">
                                                    <div class="container">
                                                        <div class="accordion" id="faq">
                                                            <div class="card">
                                                                <div class="card-header" id="faqhead1">
                                                                    <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq1" aria-expanded="true" aria-controls="faq1">Terms and Conditions of Enrollment</a>
                                                                </div>

                                                                <div id="faq1" class="collapse" aria-labelledby="faqhead1" data-parent="#faq">
                                                                    <div class="card-body">
                                                                        <div class="card-body text-justify">
                                                                            <ul>
                                                                                <li>Enrolled students and their parents agree to conform to the procedures and to comply with all of the rules established by WIS. The student Handbook explains fully the major school rules. The school reserves the right to suspend and/or permanently drop from the rolls any student whose conduct is contrary to the best interest of the school.</li>
                                                                                <li>The school is authorized to search the locker and/or possessions of any student when an illegal act has been committed and/or when the school administration has reasonable cause to suspect that the student was involved in an illegal act or violation of any school policy.</li>
                                                                                <li>Do what is legally permissible to complete my child’s required documents.</li>
                                                                                <li>Submit the required enrollment requirements for my child on or before the start of the school year.</li>
                                                                                <li>I agree that the official record from this school shall only be released until the submission of school credentials from the previous school.</li>
                                                                                <li>I understand that the school cannot release any report card or school records of my child until I submit the required document.</li>
                                                                                <li>
                                                                                    Without the transfer credentials of my child, I fully understand that:
                                                                                    <ul>
                                                                                        <li>My child is only temporarily enrolled.</li>
                                                                                        <li>My child cannot be officially promoted to a higher year level.</li>
                                                                                    </ul>
                                                                                </li>
                                                                            </ul>
                                                                            <div class="float-right">
                                                                                <label class="c-input c-checkbox">
                                                                                    <input type="checkbox" name="tos" value="1" required>
                                                                                    <span class="c-indicator"></span>
                                                                                    <b>I fully understand and accept the Terms and Conditions of Enrollment as outlined above.</b>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card">
                                                                <div class="card-header" id="faqhead2">
                                                                    <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq2" aria-expanded="true" aria-controls="faq2">Agreement for Early Enrollment</a>
                                                                </div>

                                                                <div id="faq2" class="collapse" aria-labelledby="faqhead2" data-parent="#faq">
                                                                    <div class="card-body">
                                                                        <ul>
                                                                            <li>I understand that I was allowed to enroll him/her for the school year <b class="gen_nxtSY" id="nxtSY1">2023-2024</b> on the condition that s/he on the condition that s/he will be accepted in grade <b id="gen_grade">________</b> for the school year <b class="gen_nxtSY" id="nxtSY2">2023-2024</b> only if I will submit his/her complete requirements and/or complete school records from the previous school year, <b class="gen_prvSY" id="prvSY1">2022-2023</b>, indicating that s/he is eligible for promotion to the level s/he is being enrolled.</li>
                                                                            <li>I believe that this condition is being provided for the total academic development of my child.</li>
                                                                            <li>Furthermore, I hold Westfields International School free from any legal responsibilities on account of our failure to comply with the conditions and requirements for enrollment.</li>
                                                                        </ul>
                                                                        <div class="float-right">
                                                                            <label class="c-input c-checkbox">
                                                                                <input type="checkbox" name="earlybird" value="1" required>
                                                                                <span class="c-indicator"></span> <b>I fully understand and accept the Agreement for Early Enrollment as outlined above.</b>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card">
                                                                <div class="card-header" id="faqhead3">
                                                                    <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq3" aria-expanded="true" aria-controls="faq3">Model Release</a>
                                                                </div>

                                                                <div id="faq3" class="collapse" aria-labelledby="faqhead3" data-parent="#faq">
                                                                    <div class="card-body">
                                                                        <ul>
                                                                            <li>Westfields International School has the right to take photographs/video footage of my child/children in connection with any all activities related to the school.</li>
                                                                            <li>Westfields International School is authorized to copyright, use, and publish the same in print and/or electronically.</li>
                                                                            <li>Westfields International School may use such photographs and/or video footage of my child ith or without his or her name and for any lawful purpose, including such purposes as publicity, illustration, advertising, and Web content.</li>
                                                                            <li>This agreement shall remain in effect until the end of the school year <b class="gen_nxtSY" id="nxtSY3">2023-2024</b>.</li>
                                                                        </ul>
                                                                        <div class="form-group fw-bold d-flex justify-content-end">
                                                                            <div class="c-inputs-stacked d-flex flex-column justify-content-end">
                                                                                <label class="c-input c-radio">
                                                                                    <input id="#" name="modelrelease" type="radio" value="1" required="">
                                                                                    <span class="c-indicator"></span>I agree to the terms of this photo/video release outline above.
                                                                                </label>
                                                                                <label class="c-input c-radio">
                                                                                    <input id="#" name="modelrelease" type="radio" value="0">
                                                                                    <span class="c-indicator"></span>I do not agree to the terms of this photo/video release outline above.
                                                                                </label>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card">
                                                                <div class="card-header" id="faqhead4">
                                                                    <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq4" aria-expanded="true" aria-controls="faq4">Policy on Student Fees</a>
                                                                </div>

                                                                <div id="faq4" class="collapse" aria-labelledby="faqhead4" data-parent="#faq">
                                                                    <div class="card-body">
                                                                        <ul>
                                                                            <li>It is understood that a student normally enrolls for the entire school year. All fees for the entire year are due and payable upon enrollment unless other arrangements are made upon enrollment and agreed into writing by parent/guardian Head Master. “The foregoing tuition fee schedule is based on the premise that a student who enrolls in a school year stays enrolled for the entire school year semester, regardless of his/her subsequent transfer or withdrawal”. (Based on Sec. 66, P.258 of Manual of Regulations for Private Schools).</li>
                                                                            <li>Fees will not be prorated to a part of the semester quarter regardless of the number of days attended.</li>
                                                                            <li>Other School Fees are required to be paid in full upon enrollment.</li>
                                                                            <li>Reservation Fee, Tuition, matriculation, and all Other Fees are generally non-refundable (see Policies on Refund).</li>
                                                                            <li>A one-Time sibling discount is given upon enrollment for those who have 2 or more children enrolled in the school.</li>
                                                                            <li>Installment payment for tuition fees is only for accommodation purposes and is only given to our local residents.</li>
                                                                            <li>Due dates for tuition fee paid in installments varies and depends on the plan you choose.</li>
                                                                            <li>Charge for late payments: A penalty of 2.5% per month (cumulative) will be billed on fees not paid on due dates.</li>
                                                                            <li>REFUND POLICY: All school fees are transferable and shall not be prorated for partial attendance during a quarter/trimester. If a student withdraws during the semester, no refund will be granted. A student who is paying his/her school fees on an installment basis has to complete his/her fees for the whole school year before he/she will be allowed to leave. (Based on Sec.26, P.258-59 of Manual of Regulations for Private Schools).</li>
                                                                            <li>NOTICE OF DEPARTURE: Students who withdraw need to notify the Office of the School Head in writing and fill out a withdrawal slip. A withdrawal clearance slip will be issued at the time. After the different offices and departments sign the Clearance Slip, it will be brought to the business office for the final clearance. When the final clearance is completed, students may pick up the transcript/records from the Head Master’s Office. No school records will be released unless all school fees for the whole school year have been fully paid.</li>
                                                                        </ul>
                                                                        <div class="float-right">
                                                                            <label class="c-input c-checkbox">
                                                                                <input type="checkbox" name="feepolicy" value="1" required>
                                                                                <span class="c-indicator"></span> <b>I fully understand and accept the Policies of Student Fees as outlined above.</b>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card">
                                                                <div class="card-header" id="faqhead5">
                                                                    <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq5" aria-expanded="true" aria-controls="faq5">Policy on Refunds</a>
                                                                </div>

                                                                <div id="faq5" class="collapse" aria-labelledby="faqhead5" data-parent="#faq">
                                                                    <div class="card-body">
                                                                        <div>
                                                                            <b>A student who wishes to withdraw should notify the Office of the School Head in Writing</b><br>
                                                                            The following policies on REFUND OF TUITION, MISCELLANEOUS and OTHER FEES shall be enforced upon any student, who drops/withdraws from Westfields International School after having been enrolled:
                                                                            <table class="table">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>TIME OF WITHDRAWAL</th>
                                                                                        <th>REFUND</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>1.1 Before the official start of classes</td>
                                                                                        <td>Total amount paid less service charge of ₱ 35,000.00</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>1.2 Within the first (1<sup>st</sup>) week of classes</td>
                                                                                        <td>Total amount paid less 20% of the total amount paid and a service charge of ₱ 35,000.00</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>1.3 Within the second (2<sup>nd</sup>) week of classes</td>
                                                                                        <td>Total amount paid less 30% of the total amount paid and a service charge pf ₱ 35,000.00</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>1.4 Beyond two weeks from the start of classes</td>
                                                                                        <td>NO refund and will be required to pay in full</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>RESERVATION FEE</td>
                                                                                        <td>NON-REFUNDABLE</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <b>Only students who officially drop/withdraw within two weeks from the start of classes or earlier shall be entitled to refund as follows:</b>
                                                                            <ul>
                                                                                <li>Students who will drop/withdraw whether officially or unofficially, beyond two weeks from the start of classes shall be required to pay in full, the total tuition, miscellaneous, and other fees for the entire school year.</li>
                                                                                <li>Uniforms cannot be refunded.</li>
                                                                                <li>The refund will be given at the end of the school year and will be given in a form of a cheque named to the parent or the guardian upon enrollment.</li>
                                                                                <li>Unless otherwise provided by law, all provisions of this agreement remain effective. This includes all cases of force majeure events (including but not limited to, acts of government, national public health emergencies, and natural disasters).</li>
                                                                                <li>For early bird promo excess payment due to change in the mode of class set-up (from face to face to online), there will strictly be no cash refund. Instead, the amount will be credited to your child's account and may be used for services as STAR Program, After School Activities, etc...</li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="float-right">
                                                                            <label class="c-input c-checkbox">
                                                                                <input type="checkbox" name="refundpolicy" value="1" required>
                                                                                <span class="c-indicator"></span> <b>I fully understand and accept the Policies on Refund as outlined above.</b>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="card-footer bg-light text-center">
                                    <button class="btn btn-primary btn-lg" onclick="return confirmSubmission()">Submit Application</button>
                                </div>
                            </div>
                        </div>
                </div>
                </form>
                <!-- form ends !-->
            </div>
            <?php include_once "includes/footer.php"; ?>
        </div>
        <?php include_once "includes/scripts.php"; ?>
        <script>
            function confirmSubmission(){
                if(confirm("Are you sure you want to submit?")){
                    console.log("Are you sure you want to submit?");
                    return true;
                }else{
                    return false
                }
            }

            function fnCalculateAge() {
                var userDateinput = document.getElementById("dob").value;
                var birthDate = new Date(userDateinput);
                var difference = Date.now() - birthDate.getTime();
                var ageDate = new Date(difference);
                var calculatedAge = Math.abs(ageDate.getUTCFullYear() - 1970);
                document.getElementById('age').value = new Number(calculatedAge);
            }

            function fnStrand() {
                if (document.getElementById("gradelevel").value == "grade11") {
                    document.getElementById("row11").style.display = "none";
                    document.getElementById("row11").style.display = null;
                    document.getElementById("row11").style.display = "block";
                }
                if (document.getElementById("gradelevel").value == "grade12") {
                    document.getElementById("row12").style.display = "none";
                    document.getElementById("row12").style.display = null;
                    document.getElementById("row12").style.display = "block";
                }
            }

            $('#nationalityName').change(function(e) {
                if ($(this).val() == "Philippines") {
                    $('#visa').prop('hidden', true);
                    $('#visalbl').prop('hidden', true);
                } else {
                    $('#visa').prop('hidden', false);
                }
            });
            $('#nationalityName2').change(function(e) {
                if ($(this).val() == "Philippines") {
                    $('#visa').prop('hidden', true);
                    $('#visalbl').prop('hidden', true);
                } else {
                    $('#visa').prop('hidden', false);
                }
            });

            $('#gradelevel').change(function(e) {
                if ($(this).val() != "Grade 11" && $(this).val() != "Grade 12") {
                    $('#strand').prop('hidden', true);
                    $('#strandlbl').prop('hidden', true);
                } else {
                    $('#strand').prop('hidden', false);
                    $('#strandlbl').prop('hidden', false);
                }
            });

            // CHECK STUDENT
            $("#applicationtype").change(function(e) {
                if ($(this).val() == "Old Student") {
                    window.location.replace("old-students-enroll.php");
                }
            });
        </script>
    </div>
    </div>
</body>

</html>
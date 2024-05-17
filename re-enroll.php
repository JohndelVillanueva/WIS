<?php include_once "includes/config.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<?php include_once "includes/css.php"; ?>

<div>
    <style>
        .hidden {
            display: none;
        }
    </style>
    <div class="app">
        < class="layout">
            <?php include_once "includes/heading.php"; ?>
            <?php include_once "includes/sidemenu.php"; ?>
            <?php
            $pdo_statement = $DB_con->prepare("SELECT * FROM user WHERE id = :id");
            $pdo_statement->execute(array(":id" => $_GET['id']));
            $result = $pdo_statement->fetchAll();
            foreach ($result as $row) {
            ?>
                <div class="page-container">
                    <div class="main-content">
                        <!-- form starts !-->
                        <form action="re-enroll_process.php" method="post" enctype="multipart/form-data" id="mainForm">
                            <input type="hidden" name="ern" value="<?php echo $row['uniqid'] ?>">
                            <input type="hidden" name="stage" value="<?php echo $row['status'] ?>">
                            <input type="hidden" name="tf" value="<?php echo $row['tf'] ?>">
                            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header bg-warning rounded-top pt-2">
                                            <h4>
                                                <span class="icon-holder">
                                                    <i class="anticon anticon-idcard"></i>
                                                </span>
                                                Student Profile
                                            </h4>
                                        </div>
                                        <section id="personal-information">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <?php
                                                        if (empty($row["photo"])) {
                                                        ?>
                                                            <label for="photo"><img class="rounded" style="max-width: 128px!important;" src="assets/images/avatars/avatar-upload.jpg"></label>
                                                            <input type="file" id="photo" name="photo" hidden>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <img class="rounded" src="assets/images/avatars/<?php echo $row["photo"]; ?>" style="width:128px!important;">
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class=" col-lg-3">
                                                        <label for="lastname">Last Name</label>
                                                        <input type="hidden" id="id" name="id" value="<?php echo $row['id']; ?>">
                                                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" required value="<?php echo $row["lname"]; ?>">
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label for="firstname">First Name</label>
                                                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" required value="<?php echo $row["fname"]; ?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="middlename">Middle Name</label>
                                                        <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Middle Name" value="<?php echo $row["mname"]; ?>">
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <label for="gender">Gender</label>
                                                        <select class="custom-select" id="gender" name="gender">
                                                            <option value="<?php echo $row["gender"]; ?>"><?php echo $row["gender"]; ?></option>
                                                            <option value=" M">Male</option>
                                                            <option value="F">Female</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <label for="house">House</label>
                                                        <select class="custom-select" id="house" name="house">
                                                            <option value="Bulls">Bulls</option>
                                                            <option value="Owls">Owls</option>
                                                            <option value="Wolves">Wolves</option>
                                                            <option value="Orcas">Orcas</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row py-3">

                                                    <div class="col-lg-1">
                                                        <label for="dob">Date of Birth</label>
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
                                                        <label for="lrn">Learner's Reference Number</label>
                                                        <input type="text" class="form-control" id="lrn" name="lrn" value="<?php echo $row["lrn"]; ?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="oldschool">Previous School</label>
                                                        <input type="text" class="form-control" id="oldschool" name="oldschool" value="<?php echo $row["prevsch"]; ?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="oldschoolctry">Country</label>
                                                        <select id="oldschoolctry" name="oldschoolctry" class="form-control">
                                                            <option value="<?php echo $row["prevschcountry"]; ?>"><?php echo $row["prevschcountry"]; ?></option>
                                                            <option value="">-- select one --</option>
                                                            <option value=" Afghanistan">Afghanistan</option>
                                                            <option value="Åland Islands">Åland Islands</option>
                                                            <option value="Albania">Albania</option>
                                                            <option value="Algeria">Algeria</option>
                                                            <option value="American Samoa">American Samoa</option>
                                                            <option value="Andorra">Andorra</option>
                                                            <option value="Angola">Angola</option>
                                                            <option value="Anguilla">Anguilla</option>
                                                            <option value="Antarctica">Antarctica</option>
                                                            <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                            <option value="Argentina">Argentina</option>
                                                            <option value="Armenia">Armenia</option>
                                                            <option value="Aruba">Aruba</option>
                                                            <option value="Australia">Australia</option>
                                                            <option value="Austria">Austria</option>
                                                            <option value="Azerbaijan">Azerbaijan</option>
                                                            <option value="Bahamas">Bahamas</option>
                                                            <option value="Bahrain">Bahrain</option>
                                                            <option value="Bangladesh">Bangladesh</option>
                                                            <option value="Barbados">Barbados</option>
                                                            <option value="Belarus">Belarus</option>
                                                            <option value="Belgium">Belgium</option>
                                                            <option value="Belize">Belize</option>
                                                            <option value="Benin">Benin</option>
                                                            <option value="Bermuda">Bermuda</option>
                                                            <option value="Bhutan">Bhutan</option>
                                                            <option value="Bolivia">Bolivia</option>
                                                            <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                                            <option value="Botswana">Botswana</option>
                                                            <option value="Bouvet Island">Bouvet Island</option>
                                                            <option value="Brazil">Brazil</option>
                                                            <option value="British Indian Ocean Territory">British Indian Ocean Territory
                                                            </option>
                                                            <option value="Brunei Darussalam">Brunei Darussalam</option>
                                                            <option value="Bulgaria">Bulgaria</option>
                                                            <option value="Burkina Faso">Burkina Faso</option>
                                                            <option value="Burundi">Burundi</option>
                                                            <option value="Cambodia">Cambodia</option>
                                                            <option value="Cameroon">Cameroon</option>
                                                            <option value="Canada">Canada</option>
                                                            <option value="Cape Verde">Cape Verde</option>
                                                            <option value="Cayman Islands">Cayman Islands</option>
                                                            <option value="Central African Republic">Central African Republic</option>
                                                            <option value="Chad">Chad</option>
                                                            <option value="Chile">Chile</option>
                                                            <option value="China">China</option>
                                                            <option value="Christmas Island">Christmas Island</option>
                                                            <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                                            <option value="Colombia">Colombia</option>
                                                            <option value="Comoros">Comoros</option>
                                                            <option value="Congo">Congo</option>
                                                            <option value="Congo, The Democratic Republic of The">Congo, The Democratic
                                                                Republic of The
                                                            </option>
                                                            <option value="Cook Islands">Cook Islands</option>
                                                            <option value="Costa Rica">Costa Rica</option>
                                                            <option value="Cote D'ivoire">Cote D'ivoire</option>
                                                            <option value="Croatia">Croatia</option>
                                                            <option value="Cuba">Cuba</option>
                                                            <option value="Cyprus">Cyprus</option>
                                                            <option value="Czech Republic">Czech Republic</option>
                                                            <option value="Denmark">Denmark</option>
                                                            <option value="Djibouti">Djibouti</option>
                                                            <option value="Dominica">Dominica</option>
                                                            <option value="Dominican Republic">Dominican Republic</option>
                                                            <option value="Ecuador">Ecuador</option>
                                                            <option value="Egypt">Egypt</option>
                                                            <option value="El Salvador">El Salvador</option>
                                                            <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                            <option value="Eritrea">Eritrea</option>
                                                            <option value="Estonia">Estonia</option>
                                                            <option value="Ethiopia">Ethiopia</option>
                                                            <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                                                            <option value="Faroe Islands">Faroe Islands</option>
                                                            <option value="Fiji">Fiji</option>
                                                            <option value="Finland">Finland</option>
                                                            <option value="France">France</option>
                                                            <option value="French Guiana">French Guiana</option>
                                                            <option value="French Polynesia">French Polynesia</option>
                                                            <option value="French Southern Territories">French Southern Territories</option>
                                                            <option value="Gabon">Gabon</option>
                                                            <option value="Gambia">Gambia</option>
                                                            <option value="Georgia">Georgia</option>
                                                            <option value="Germany">Germany</option>
                                                            <option value="Ghana">Ghana</option>
                                                            <option value="Gibraltar">Gibraltar</option>
                                                            <option value="Greece">Greece</option>
                                                            <option value="Greenland">Greenland</option>
                                                            <option value="Grenada">Grenada</option>
                                                            <option value="Guadeloupe">Guadeloupe</option>
                                                            <option value="Guam">Guam</option>
                                                            <option value="Guatemala">Guatemala</option>
                                                            <option value="Guernsey">Guernsey</option>
                                                            <option value="Guinea">Guinea</option>
                                                            <option value="Guinea-bissau">Guinea-bissau</option>
                                                            <option value="Guyana">Guyana</option>
                                                            <option value="Haiti">Haiti</option>
                                                            <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald
                                                                Islands
                                                            </option>
                                                            <option value="Holy See (Vatican City State)">Holy See (Vatican City State)
                                                            </option>
                                                            <option value="Honduras">Honduras</option>
                                                            <option value="Hong Kong">Hong Kong</option>
                                                            <option value="Hungary">Hungary</option>
                                                            <option value="Iceland">Iceland</option>
                                                            <option value="India">India</option>
                                                            <option value="Indonesia">Indonesia</option>
                                                            <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                                                            <option value="Iraq">Iraq</option>
                                                            <option value="Ireland">Ireland</option>
                                                            <option value="Isle of Man">Isle of Man</option>
                                                            <option value="Israel">Israel</option>
                                                            <option value="Italy">Italy</option>
                                                            <option value="Jamaica">Jamaica</option>
                                                            <option value="Japan">Japan</option>
                                                            <option value="Jersey">Jersey</option>
                                                            <option value="Jordan">Jordan</option>
                                                            <option value="Kazakhstan">Kazakhstan</option>
                                                            <option value="Kenya">Kenya</option>
                                                            <option value="Kiribati">Kiribati</option>
                                                            <option value="Korea, Democratic People's Republic of">Korea, Democratic
                                                                People's Republic of
                                                            </option>
                                                            <option value="Korea, Republic of">Korea, Republic of</option>
                                                            <option value="Kuwait">Kuwait</option>
                                                            <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                            <option value="Lao People's Democratic Republic">Lao People's Democratic
                                                                Republic
                                                            </option>
                                                            <option value="Latvia">Latvia</option>
                                                            <option value="Lebanon">Lebanon</option>
                                                            <option value="Lesotho">Lesotho</option>
                                                            <option value="Liberia">Liberia</option>
                                                            <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                                            <option value="Liechtenstein">Liechtenstein</option>
                                                            <option value="Lithuania">Lithuania</option>
                                                            <option value="Luxembourg">Luxembourg</option>
                                                            <option value="Macao">Macao</option>
                                                            <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former
                                                                Yugoslav Republic of
                                                            </option>
                                                            <option value="Madagascar">Madagascar</option>
                                                            <option value="Malawi">Malawi</option>
                                                            <option value="Malaysia">Malaysia</option>
                                                            <option value="Maldives">Maldives</option>
                                                            <option value="Mali">Mali</option>
                                                            <option value="Malta">Malta</option>
                                                            <option value="Marshall Islands">Marshall Islands</option>
                                                            <option value="Martinique">Martinique</option>
                                                            <option value="Mauritania">Mauritania</option>
                                                            <option value="Mauritius">Mauritius</option>
                                                            <option value="Mayotte">Mayotte</option>
                                                            <option value="Mexico">Mexico</option>
                                                            <option value="Micronesia, Federated States of">Micronesia, Federated States
                                                                of
                                                            </option>
                                                            <option value="Moldova, Republic of">Moldova, Republic of</option>
                                                            <option value="Monaco">Monaco</option>
                                                            <option value="Mongolia">Mongolia</option>
                                                            <option value="Montenegro">Montenegro</option>
                                                            <option value="Montserrat">Montserrat</option>
                                                            <option value="Morocco">Morocco</option>
                                                            <option value="Mozambique">Mozambique</option>
                                                            <option value="Myanmar">Myanmar</option>
                                                            <option value="Namibia">Namibia</option>
                                                            <option value="Nauru">Nauru</option>
                                                            <option value="Nepal">Nepal</option>
                                                            <option value="Netherlands">Netherlands</option>
                                                            <option value="Netherlands Antilles">Netherlands Antilles</option>
                                                            <option value="New Caledonia">New Caledonia</option>
                                                            <option value="New Zealand">New Zealand</option>
                                                            <option value="Nicaragua">Nicaragua</option>
                                                            <option value="Niger">Niger</option>
                                                            <option value="Nigeria">Nigeria</option>
                                                            <option value="Niue">Niue</option>
                                                            <option value="Norfolk Island">Norfolk Island</option>
                                                            <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                                            <option value="Norway">Norway</option>
                                                            <option value="Oman">Oman</option>
                                                            <option value="Pakistan">Pakistan</option>
                                                            <option value="Palau">Palau</option>
                                                            <option value="Palestinian Territory, Occupied">Palestinian Territory,
                                                                Occupied
                                                            </option>
                                                            <option value="Panama">Panama</option>
                                                            <option value="Papua New Guinea">Papua New Guinea</option>
                                                            <option value="Paraguay">Paraguay</option>
                                                            <option value="Peru">Peru</option>
                                                            <option value="Philippines">Philippines</option>
                                                            <option value="Pitcairn">Pitcairn</option>
                                                            <option value="Poland">Poland</option>
                                                            <option value="Portugal">Portugal</option>
                                                            <option value="Puerto Rico">Puerto Rico</option>
                                                            <option value="Qatar">Qatar</option>
                                                            <option value="Reunion">Reunion</option>
                                                            <option value="Romania">Romania</option>
                                                            <option value="Russian Federation">Russian Federation</option>
                                                            <option value="Rwanda">Rwanda</option>
                                                            <option value="Saint Helena">Saint Helena</option>
                                                            <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                                            <option value="Saint Lucia">Saint Lucia</option>
                                                            <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                                            <option value="Saint Vincent and The Grenadines">Saint Vincent and The
                                                                Grenadines
                                                            </option>
                                                            <option value="Samoa">Samoa</option>
                                                            <option value="San Marino">San Marino</option>
                                                            <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                                            <option value="Saudi Arabia">Saudi Arabia</option>
                                                            <option value="Senegal">Senegal</option>
                                                            <option value="Serbia">Serbia</option>
                                                            <option value="Seychelles">Seychelles</option>
                                                            <option value="Sierra Leone">Sierra Leone</option>
                                                            <option value="Singapore">Singapore</option>
                                                            <option value="Slovakia">Slovakia</option>
                                                            <option value="Slovenia">Slovenia</option>
                                                            <option value="Solomon Islands">Solomon Islands</option>
                                                            <option value="Somalia">Somalia</option>
                                                            <option value="South Africa">South Africa</option>
                                                            <option value="South Georgia and The South Sandwich Islands">South Georgia and
                                                                The South Sandwich Islands
                                                            </option>
                                                            <option value="Spain">Spain</option>
                                                            <option value="Sri Lanka">Sri Lanka</option>
                                                            <option value="Sudan">Sudan</option>
                                                            <option value="Suriname">Suriname</option>
                                                            <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                                            <option value="Swaziland">Swaziland</option>
                                                            <option value="Sweden">Sweden</option>
                                                            <option value="Switzerland">Switzerland</option>
                                                            <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                                            <option value="Taiwan">Taiwan</option>
                                                            <option value="Tajikistan">Tajikistan</option>
                                                            <option value="Tanzania, United Republic of">Tanzania, United Republic of
                                                            </option>
                                                            <option value="Thailand">Thailand</option>
                                                            <option value="Timor-leste">Timor-leste</option>
                                                            <option value="Togo">Togo</option>
                                                            <option value="Tokelau">Tokelau</option>
                                                            <option value="Tonga">Tonga</option>
                                                            <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                            <option value="Tunisia">Tunisia</option>
                                                            <option value="Turkey">Turkey</option>
                                                            <option value="Turkmenistan">Turkmenistan</option>
                                                            <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                                            <option value="Tuvalu">Tuvalu</option>
                                                            <option value="Uganda">Uganda</option>
                                                            <option value="Ukraine">Ukraine</option>
                                                            <option value="United Arab Emirates">United Arab Emirates</option>
                                                            <option value="United Kingdom">United Kingdom</option>
                                                            <option value="United States">United States</option>
                                                            <option value="United States Minor Outlying Islands">United States Minor
                                                                Outlying Islands
                                                            </option>
                                                            <option value="Uruguay">Uruguay</option>
                                                            <option value="Uzbekistan">Uzbekistan</option>
                                                            <option value="Vanuatu">Vanuatu</option>
                                                            <option value="Venezuela">Venezuela</option>
                                                            <option value="Viet Nam">Viet Nam</option>
                                                            <option value="Virgin Islands, British">Virgin Islands, British</option>
                                                            <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                                                            <option value="Wallis and Futuna">Wallis and Futuna</option>
                                                            <option value="Western Sahara">Western Sahara</option>
                                                            <option value="Yemen">Yemen</option>
                                                            <option value="Zambia">Zambia</option>
                                                            <option value="Zimbabwe">Zimbabwe</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <label for="nationality">Nationality</label>
                                                        <select class="custom-select" id="nationality" name="nationality">
                                                            <option value="<?php echo $row["nationality"]; ?>""><?php echo ucfirst($row["nationality"]); ?></option>
                                                        <option value="">-- select one --</option>
                                                        <option value=" afghan">Afghan</option>
                                                            <option value="albanian">Albanian</option>
                                                            <option value="algerian">Algerian</option>
                                                            <option value="american">American</option>
                                                            <option value="andorran">Andorran</option>
                                                            <option value="angolan">Angolan</option>
                                                            <option value="antiguans">Antiguans</option>
                                                            <option value="argentinean">Argentinean</option>
                                                            <option value="armenian">Armenian</option>
                                                            <option value="australian">Australian</option>
                                                            <option value="austrian">Austrian</option>
                                                            <option value="azerbaijani">Azerbaijani</option>
                                                            <option value="bahamian">Bahamian</option>
                                                            <option value="bahraini">Bahraini</option>
                                                            <option value="bangladeshi">Bangladeshi</option>
                                                            <option value="barbadian">Barbadian</option>
                                                            <option value="barbudans">Barbudans</option>
                                                            <option value="batswana">Batswana</option>
                                                            <option value="belarusian">Belarusian</option>
                                                            <option value="belgian">Belgian</option>
                                                            <option value="belizean">Belizean</option>
                                                            <option value="beninese">Beninese</option>
                                                            <option value="bhutanese">Bhutanese</option>
                                                            <option value="bolivian">Bolivian</option>
                                                            <option value="bosnian">Bosnian</option>
                                                            <option value="brazilian">Brazilian</option>
                                                            <option value="british">British</option>
                                                            <option value="bruneian">Bruneian</option>
                                                            <option value="bulgarian">Bulgarian</option>
                                                            <option value="burkinabe">Burkinabe</option>
                                                            <option value="burmese">Burmese</option>
                                                            <option value="burundian">Burundian</option>
                                                            <option value="cambodian">Cambodian</option>
                                                            <option value="cameroonian">Cameroonian</option>
                                                            <option value="canadian">Canadian</option>
                                                            <option value="cape verdean">Cape Verdean</option>
                                                            <option value="central african">Central African</option>
                                                            <option value="chadian">Chadian</option>
                                                            <option value="chilean">Chilean</option>
                                                            <option value="chinese">Chinese</option>
                                                            <option value="colombian">Colombian</option>
                                                            <option value="comoran">Comoran</option>
                                                            <option value="congolese">Congolese</option>
                                                            <option value="costa rican">Costa Rican</option>
                                                            <option value="croatian">Croatian</option>
                                                            <option value="cuban">Cuban</option>
                                                            <option value="cypriot">Cypriot</option>
                                                            <option value="czech">Czech</option>
                                                            <option value="danish">Danish</option>
                                                            <option value="djibouti">Djibouti</option>
                                                            <option value="dominican">Dominican</option>
                                                            <option value="dutch">Dutch</option>
                                                            <option value="east timorese">East Timorese</option>
                                                            <option value="ecuadorean">Ecuadorean</option>
                                                            <option value="egyptian">Egyptian</option>
                                                            <option value="emirian">Emirian</option>
                                                            <option value="equatorial guinean">Equatorial Guinean</option>
                                                            <option value="eritrean">Eritrean</option>
                                                            <option value="estonian">Estonian</option>
                                                            <option value="ethiopian">Ethiopian</option>
                                                            <option value="fijian">Fijian</option>
                                                            <option value="filipino">Filipino</option>
                                                            <option value="finnish">Finnish</option>
                                                            <option value="french">French</option>
                                                            <option value="gabonese">Gabonese</option>
                                                            <option value="gambian">Gambian</option>
                                                            <option value="georgian">Georgian</option>
                                                            <option value="german">German</option>
                                                            <option value="ghanaian">Ghanaian</option>
                                                            <option value="greek">Greek</option>
                                                            <option value="grenadian">Grenadian</option>
                                                            <option value="guatemalan">Guatemalan</option>
                                                            <option value="guinea-bissauan">Guinea-Bissauan</option>
                                                            <option value="guinean">Guinean</option>
                                                            <option value="guyanese">Guyanese</option>
                                                            <option value="haitian">Haitian</option>
                                                            <option value="herzegovinian">Herzegovinian</option>
                                                            <option value="honduran">Honduran</option>
                                                            <option value="hungarian">Hungarian</option>
                                                            <option value="icelander">Icelander</option>
                                                            <option value="indian">Indian</option>
                                                            <option value="indonesian">Indonesian</option>
                                                            <option value="iranian">Iranian</option>
                                                            <option value="iraqi">Iraqi</option>
                                                            <option value="irish">Irish</option>
                                                            <option value="israeli">Israeli</option>
                                                            <option value="italian">Italian</option>
                                                            <option value="ivorian">Ivorian</option>
                                                            <option value="jamaican">Jamaican</option>
                                                            <option value="japanese">Japanese</option>
                                                            <option value="jordanian">Jordanian</option>
                                                            <option value="kazakhstani">Kazakhstani</option>
                                                            <option value="kenyan">Kenyan</option>
                                                            <option value="kittian and nevisian">Kittian and Nevisian</option>
                                                            <option value="kuwaiti">Kuwaiti</option>
                                                            <option value="kyrgyz">Kyrgyz</option>
                                                            <option value="laotian">Laotian</option>
                                                            <option value="latvian">Latvian</option>
                                                            <option value="lebanese">Lebanese</option>
                                                            <option value="liberian">Liberian</option>
                                                            <option value="libyan">Libyan</option>
                                                            <option value="liechtensteiner">Liechtensteiner</option>
                                                            <option value="lithuanian">Lithuanian</option>
                                                            <option value="luxembourger">Luxembourger</option>
                                                            <option value="macedonian">Macedonian</option>
                                                            <option value="malagasy">Malagasy</option>
                                                            <option value="malawian">Malawian</option>
                                                            <option value="malaysian">Malaysian</option>
                                                            <option value="maldivan">Maldivan</option>
                                                            <option value="malian">Malian</option>
                                                            <option value="maltese">Maltese</option>
                                                            <option value="marshallese">Marshallese</option>
                                                            <option value="mauritanian">Mauritanian</option>
                                                            <option value="mauritian">Mauritian</option>
                                                            <option value="mexican">Mexican</option>
                                                            <option value="micronesian">Micronesian</option>
                                                            <option value="moldovan">Moldovan</option>
                                                            <option value="monacan">Monacan</option>
                                                            <option value="mongolian">Mongolian</option>
                                                            <option value="moroccan">Moroccan</option>
                                                            <option value="mosotho">Mosotho</option>
                                                            <option value="motswana">Motswana</option>
                                                            <option value="mozambican">Mozambican</option>
                                                            <option value="namibian">Namibian</option>
                                                            <option value="nauruan">Nauruan</option>
                                                            <option value="nepalese">Nepalese</option>
                                                            <option value="new zealander">New Zealander</option>
                                                            <option value="ni-vanuatu">Ni-Vanuatu</option>
                                                            <option value="nicaraguan">Nicaraguan</option>
                                                            <option value="nigerien">Nigerien</option>
                                                            <option value="north korean">North Korean</option>
                                                            <option value="northern irish">Northern Irish</option>
                                                            <option value="norwegian">Norwegian</option>
                                                            <option value="omani">Omani</option>
                                                            <option value="pakistani">Pakistani</option>
                                                            <option value="palauan">Palauan</option>
                                                            <option value="panamanian">Panamanian</option>
                                                            <option value="papua new guinean">Papua New Guinean</option>
                                                            <option value="paraguayan">Paraguayan</option>
                                                            <option value="peruvian">Peruvian</option>
                                                            <option value="polish">Polish</option>
                                                            <option value="portuguese">Portuguese</option>
                                                            <option value="qatari">Qatari</option>
                                                            <option value="romanian">Romanian</option>
                                                            <option value="russian">Russian</option>
                                                            <option value="rwandan">Rwandan</option>
                                                            <option value="saint lucian">Saint Lucian</option>
                                                            <option value="salvadoran">Salvadoran</option>
                                                            <option value="samoan">Samoan</option>
                                                            <option value="san marinese">San Marinese</option>
                                                            <option value="sao tomean">Sao Tomean</option>
                                                            <option value="saudi">Saudi</option>
                                                            <option value="scottish">Scottish</option>
                                                            <option value="senegalese">Senegalese</option>
                                                            <option value="serbian">Serbian</option>
                                                            <option value="seychellois">Seychellois</option>
                                                            <option value="sierra leonean">Sierra Leonean</option>
                                                            <option value="singaporean">Singaporean</option>
                                                            <option value="slovakian">Slovakian</option>
                                                            <option value="slovenian">Slovenian</option>
                                                            <option value="solomon islander">Solomon Islander</option>
                                                            <option value="somali">Somali</option>
                                                            <option value="south african">South African</option>
                                                            <option value="south korean">South Korean</option>
                                                            <option value="spanish">Spanish</option>
                                                            <option value="sri lankan">Sri Lankan</option>
                                                            <option value="sudanese">Sudanese</option>
                                                            <option value="surinamer">Surinamer</option>
                                                            <option value="swazi">Swazi</option>
                                                            <option value="swedish">Swedish</option>
                                                            <option value="swiss">Swiss</option>
                                                            <option value="syrian">Syrian</option>
                                                            <option value="taiwanese">Taiwanese</option>
                                                            <option value="tajik">Tajik</option>
                                                            <option value="tanzanian">Tanzanian</option>
                                                            <option value="thai">Thai</option>
                                                            <option value="togolese">Togolese</option>
                                                            <option value="tongan">Tongan</option>
                                                            <option value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
                                                            <option value="tunisian">Tunisian</option>
                                                            <option value="turkish">Turkish</option>
                                                            <option value="tuvaluan">Tuvaluan</option>
                                                            <option value="ugandan">Ugandan</option>
                                                            <option value="ukrainian">Ukrainian</option>
                                                            <option value="uruguayan">Uruguayan</option>
                                                            <option value="uzbekistani">Uzbekistani</option>
                                                            <option value="venezuelan">Venezuelan</option>
                                                            <option value="vietnamese">Vietnamese</option>
                                                            <option value="welsh">Welsh</option>
                                                            <option value="yemenite">Yemenite</option>
                                                            <option value="zambian">Zambian</option>
                                                            <option value="zimbabwean">Zimbabwean</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <label for="gradelevel">Level Applied for:</label>
                                                        <select class="custom-select" id="gradelevel" class="form-select" name="gradelevel" required>
                                                            <option value="<?php echo $row["grade"] + 1; ?>""><?php echo ucfirst($row["grade"] + 1); ?></option>
                                                <option value="">-- select one --</option>
                                                <option value=" Nursery">Nursery</option>
                                                            <option value="Toddler">Toddler</option>
                                                            <option value="Preschool">Preschool</option>
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
                                                            <option value="CAIE">CAIE</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="section">Section</label>
                                                        <select class="custom-select" id="section" class="form-select" name="section" required>
                                                            <option value="<?php if (!empty($row['section'])) {
                                                                                echo $row['section'];
                                                                            } ?>" selected><?php if (!empty($row['section'])) {
                                                                                                echo $row['section'];
                                                                                            } ?></option>
                                                            <option value="">-- select one --</option>
                                                            <option value="A">A</option>
                                                            <option value="B">B</option>
                                                            <option value="C">C</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <label for="guardian">Guardian's Name</label>
                                                        <input type="text" class="form-control" id="guardian" name="guardian" placeholder="Guardian's Name" value="<?php echo $row["guardianname"]; ?>">
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label for="guardianemail">Guardian's Email</label>
                                                        <input type="text" class="form-control" id="guardianemail" name="guardianemail" placeholder="Guardian's Email" value="<?php echo $row["guardianemail"]; ?>">
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label for="guardianphone">Guardian's Phone Number</label>
                                                        <input type="text" class="form-control" id="guardianphone" name="guardianphone" placeholder="Guardian's Phone Number" value="<?php echo $row["guardianphone"]; ?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="visa">VISA Status</label>
                                                        <select class="custom-select" id="visa" class="form-select" name="visa">
                                                            <option value="<?php echo $row["visa"]; ?>"><?php echo $row["visa"]; ?></option>
                                                            <option value="">-- select one --</option>
                                                            <option value="Temporary Visitor’s Visa">Temporary Visitor’s Visa</option>
                                                            <option value="Special Non-Immigrant Visa">Special Non-Immigrant Visa</option>
                                                            <option value="Non-Quota Immigrant Visa">Non-Quota Immigrant Visa</option>
                                                            <option value="Student Visa">Student Visa</option>
                                                            <option value="Special Resident Retiree Visa">Special Resident Retiree Visa</option>
                                                            <option value="Special Investor’s Resident Visa">Special Investor’s Resident Visa</option>
                                                            <option value="Treaty Trader Visa">Treaty Trader Visa</option>
                                                            <option value="Employment Visa">Employment Visa</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-lg-12 text-center">
                                                        <button type="button" onclick="showNextSection('additional-details')" class="btn btn-success">Next</button>
                                                    </div>
                                                </div>
                                        </section>
                                        <!-- Additional Details 1  -->
                                        <section id="additional-details" class="hidden">
                                            <div class="card-body">
                                                <div class="col-lg-12 text-center">
                                                    <p class="h2">Additional Details</p>
                                                    <hr>
                                                </div>

                                                <?php
                                                $checkdetails = $DB_con->prepare("SELECT * FROM studentdetails WHERE uniqid = :uniqid");
                                                $checkdetails->execute(array(":uniqid" => $row["uniqid"]));
                                                $deets = $checkdetails->fetchAll();

                                                if (!empty($deets)) {
                                                    foreach ($deets as $irow) {
                                                ?>
                                                        <div class="row my-3">
                                                            <div class="col-lg-3">
                                                                <label for="street">Number and Street</label>
                                                                <input type="text" class="form-control" id="street" name="street" placeholder="Number and Street" value="<?php if (!empty($irow['street'])) {
                                                                                                                                                                                echo $irow['street'];
                                                                                                                                                                            } ?>">
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label for="barangay">Barangay / Subdivision</label>
                                                                <input type="text" class="form-control" id="barangay" name="barangay" placeholder="Barangay" value="<?php if (!empty($irow['barangay'])) {
                                                                                                                                                                        echo $irow['barangay'];
                                                                                                                                                                    } ?>">
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label for="city">City</label>
                                                                <input type="text" class="form-control" id="city" name="city" placeholder="City" value="<?php if (!empty($irow['city'])) {
                                                                                                                                                            echo $irow['city'];
                                                                                                                                                        } ?>">
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label for="postal">Postal Code</label>
                                                                <input type="text" class="form-control" id="postal" name="postal" placeholder="Postal Code" value="<?php if (!empty($irow['postal'])) {
                                                                                                                                                                        echo $irow['postal'];
                                                                                                                                                                    } ?>">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <label for="father">Father's Name</label>
                                                                <input type="text" class="form-control" id="father" name="father" placeholder="Father's Name" value="<?php if (!empty($irow['street'])) {
                                                                                                                                                                            echo $irow['street'];
                                                                                                                                                                        } ?>">
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label for="fathermail">Father's Email</label>
                                                                <input type="text" class="form-control" id="fathermail" name="fathermail" placeholder="Father's Email" value="<?php if (!empty($irow['fathermail'])) {
                                                                                                                                                                                    echo $irow['fathermail'];
                                                                                                                                                                                } ?>">
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label for="fatherphone">Father's Phone Number</label>
                                                                <input type="text" class="form-control" id="fatherphone" name="fatherphone" placeholder="Father's Phone Number" value="<?php if (!empty($irow['fathernumber'])) {
                                                                                                                                                                                            echo $irow['fathernumber'];
                                                                                                                                                                                        } ?>">
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label for="fatherwork">Father's Occupation</label>
                                                                <input type="text" class="form-control" id="fatherwork" name="fatherwork" placeholder="Father's Occupation" value="<?php if (!empty($irow['fatherwork'])) {
                                                                                                                                                                                        echo $irow['fatherwork'];
                                                                                                                                                                                    } ?>">
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label for="fathercompany">Father's Company</label>
                                                                <input type="text" class="form-control" id="fathercompany" name="fathercompany" placeholder="Father's Company" value="<?php if (!empty($irow['fatherwork'])) {
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
                                                                <input type="text" class="form-control" id="mother" name="mother" placeholder="Mother's Name" value="<?php if (!empty($irow['mother'])) {
                                                                                                                                                                            echo $irow['mother'];
                                                                                                                                                                        } ?>">
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label for="mothermail">Mother's Email</label>
                                                                <input type="text" class="form-control" id="mothermail" name="mothermail" placeholder="Mother's Email" value="<?php if (!empty($irow['mothermail'])) {
                                                                                                                                                                                    echo $irow['mothermail'];
                                                                                                                                                                                } ?>">
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label for="motherphone">Mothers's Phone Number</label>
                                                                <input type="text" class="form-control" id="motherphone" name="motherphone" placeholder="Mothers's Phone Number" value="<?php if (!empty($irow['mothernumber'])) {
                                                                                                                                                                                            echo $irow['mothernumber'];
                                                                                                                                                                                        } ?>">
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label for="motherwork">Mother's Occupation</label>
                                                                <input type="text" class="form-control" id="motherwork" name="motherwork" placeholder="Mother's Occupation" value="<?php if (!empty($irow['motherwork'])) {
                                                                                                                                                                                        echo $irow['motherwork'];
                                                                                                                                                                                    } ?>">
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label for="mothercompany">Mother's Company</label>
                                                                <input type="text" class="form-control" id="mothercompany" name="mothercompany" placeholder="Mother's Company" value="<?php if (!empty($irow['mcompany'])) {
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
                                                                <select class="custom-select" id="english1" class="form-select" name="english1">
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
                                                                <select class="custom-select" id="english2" class="form-select" name="english2">
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
                                                                <input type="text" class="form-control" id="lang" name="lang" placeholder="Major Languages at home" value="<?php if (!empty($irow['languages'])) {
                                                                                                                                                                                echo $irow['languages'];
                                                                                                                                                                            } ?>">
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label for="alc">ALC</label>
                                                                <input type="text" class="form-control" id="alc" name="alc" placeholder="ALC" value="<?php if (!empty($irow['advclasses'])) {
                                                                                                                                                            echo $irow['advclasses'];
                                                                                                                                                        } ?>">
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label for="remedial">Remedial School</label>
                                                                <input type="text" class="form-control" id="remedial" name="remedial" placeholder="Remedial School" value="<?php if (!empty($irow['remedial'])) {
                                                                                                                                                                                echo $irow['remedial'];
                                                                                                                                                                            } ?>">
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label for="skill">Special Skill</label>
                                                                <input type="text" class="form-control" id="skill" name="skill" placeholder="Special Skill" value="<?php if (!empty($irow['skill'])) {
                                                                                                                                                                        echo $irow['skill'];
                                                                                                                                                                    } ?>">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12 text-center">
                                                                <button type="button" onclick="showNextSection('medical-info')" class="btn btn-success">Next</button>
                                                            </div>
                                                        </div>
                                        </section>
                                        <!-- Medical Section  2-->
                                        <section id="medical-info" class="hidden">
                                            <div class="card-body">
                                                <div class="col-lg-12 text-center">
                                                    <p class="h2">Medical Information and Health History</p>
                                                    <hr>
                                                </div>
                                            </div>
                                            <div class="row my-3">
                                                <div class="col-lg-1 ">
                                                    <label for="asthma">Asthma</label>
                                                    <select class="custom-select" id="asthma" class="form-select" name="asthma">
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
                                                    <input type="text" class="form-control" id="asthmadets" name="asthmadets" placeholder="Asthma Remarks" value="<?php if (!empty($irow['ashtmar'])) {
                                                                                                                                                                        echo $irow['ashtmar'];
                                                                                                                                                                    } ?>">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label for="allergies">Allergy</label>
                                                    <select class="custom-select" id="allergies" class="form-select" name="allergies">
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
                                                    <input type="text" class="form-control" id="allergiesdets" name="allergiesdets" placeholder="Allergy Remarks" value="<?php if (!empty($irow['allergyr'])) {
                                                                                                                                                                                echo $irow['allergyr'];
                                                                                                                                                                            } ?>">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label for="dallergies">Drug Allergy</label>
                                                    <select class="custom-select" id="dallergies" class="form-select" name="dallergies">
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
                                                    <input type="text" class="form-control" id="dallergiesdets" name="dallergiesdets" placeholder="Drug Allergy Remarks" value="<?php if (!empty($irow['drugr'])) {
                                                                                                                                                                                    echo $irow['drugr'];
                                                                                                                                                                                } ?>">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label for="speech">Speech</label>
                                                    <select class="custom-select" id="speech" class="form-select" name="speech">
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
                                                    <input type="text" class="form-control" id="speechdets" name="speechdets" placeholder="Speech Remarks" value="
                                                    <?php if (!empty($irow['speechr'])) {
                                                            echo $irow['speechr'];
                                                        } ?>">
                                                </div>
                                            </div>
                                            <div class="row my-3">
                                                <div class="col-lg-1 ">
                                                    <label for="vision">Vision</label>
                                                    <select class="custom-select" id="vision" class="form-select" name="vision">
                                                        <option value="
                                                        <?php if (!empty($irow['vision'])) {
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
                                                <div class="col-lg-3">
                                                    <label for="visiondets">Vision Remarks</label>
                                                    <input type="text" class="form-control" id="visiondets" name="visiondets" placeholder="Vision Remarks" value="<?php if (!empty($irow['visionr'])) {
                                                                                                                                                                        echo $irow['visionr'];
                                                                                                                                                                    } ?>">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label for="hearing">Hearing Problems</label>
                                                    <select class="custom-select" id="hearing" class="form-select" name="hearing">
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
                                                    <input type="text" class="form-control" id="hearingdets" name="hearingdets" placeholder="Hearing Remarks" value="<?php if (!empty($irow['hearingr'])) {
                                                                                                                                                                            echo $irow['hearingr'];
                                                                                                                                                                        } ?>">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label for="adhd">ADHD</label>
                                                    <select class="custom-select" id="adhd" class="form-select" name="adhd">
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
                                                    <input type="text" class="form-control" id="adhddets" name="adhddets" placeholder="ADHD Remarks" value="<?php if (!empty($irow['adhdr'])) {
                                                                                                                                                                echo $irow['adhdr'];
                                                                                                                                                            } ?>">
                                                </div>
                                            </div>
                                            <div class="row my-3">
                                                <div class="col-lg-6">
                                                    <label for="healthcond">Any other health condition that te school should be aware of?</label>
                                                    <input type="text" class="form-control" id="healthcond" name="healthcond" placeholder="Other Conditions" value="<?php if (!empty($irow['healthcond'])) {
                                                                                                                                                                        echo $irow['healthcond'];
                                                                                                                                                                    } ?>">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="hospitalization">Has your child recently been hospitalized?</label>
                                                    <input type="text" class="form-control" id="hospitalization" name="hospitalization" placeholder="Hospitalization" value="<?php if (!empty($irow['hospitalization'])) {
                                                                                                                                                                                    echo $irow['hospitalization'];
                                                                                                                                                                                } ?>">
                                                </div>
                                            </div>
                                            <div class="row my-3">
                                                <div class="col-lg-6">
                                                    <label for="injuries">Has your child recently had any serious injuries? Why?</label>
                                                    <input type="text" class="form-control" id="injuries" name="injuries" placeholder="Injuries" value="<?php if (!empty($irow['injuries'])) {
                                                                                                                                                            echo $irow['injuries'];
                                                                                                                                                        } ?>">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="medication">Is your child on regular medication?</label>
                                                    <input type="text" class="form-control" id="medication" name="medication" placeholder="State name of Medication and Frequency" value="<?php if (!empty($irow['medication'])) {
                                                                                                                                                                                                echo $irow['medication'];
                                                                                                                                                                                            } ?>">
                                                </div>
                                            </div>
                                            <div class="row my-3">
                                                <div class="col-lg-2">
                                                    <label for="general">General Health</label>
                                                    <select class="custom-select" id="general" class="form-select" name="general">
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
                                                    <input type="text" class="form-control" id="generaldets" name="generaldets" placeholder="HG Remarks" value="<?php if (!empty($irow['generaldets'])) {
                                                                                                                                                                    echo $irow['generaldets'];
                                                                                                                                                                } ?>">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label for="psych">Psychological</label>
                                                    <select class="custom-select" id="psych" class="form-select" name="psych">
                                                        <option value="<?php if (!empty($irow['psych'])) {
                                                                            echo $irow['psych'];
                                                                        } ?>" selected><?php if (!empty($irow['psych'])) {
                                                                                            echo $irow['psych'];
                                                                                        } ?></option>
                                                        <option value="">-- select one --</option>
                                                        <option value="">None</option>
                                                        <option value="Psychiatrist">Psychiatrist</option>
                                                        <option value="Psychologist">Psychologist</option>
                                                        <option value="Counselor">Counselor</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label for="psychdets">Psychological Remarks</label>
                                                    <input type="text" class="form-control" id="psychdets" name="psychdets" placeholder="Psychological Remarks" value="<?php if (!empty($irow['psychdets'])) {
                                                                                                                                                                            echo $irow['psychdets'];
                                                                                                                                                                        } ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 mt-5 text-center">
                                                    <p class="h2">Medical Consent</p>
                                                    <hr>
                                                </div>
                                            </div>
                                            <div class="row my-3">
                                                <div class="col-lg-3">
                                                    <label for="minor">Minor First Aid</label>
                                                    <select class="custom-select" id="minor" class="form-select" name="minor">
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
                                                    <select class="custom-select" id="emergency" class="form-select" name="emergency">
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
                                                    <select class="custom-select" id="hospital" class="form-select" name="hospital">
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
                                                    <select class="custom-select" id="otc" class="form-select" name="otc">
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


                                                <?php // } 
                                                ?>
                                            </div>
                                            <div class="row py-2">
                                                <div class="col-lg-1 text-center">&nbsp;</div>
                                                <div class="col-lg-10 text-center">
                                                    <label for="conforme">Conforme:</label>
                                                    <input type="text" class="form-control form-control-lg" id="conforme" name="conforme">
                                                </div>
                                                <div class="col-lg-1 text-center">&nbsp;</div>
                                            </div>
                                        </section>
                                        <div class="card-footer bg-light text-center">
                                            <button class="btn btn-primary btn-lg" type="submit" name="Submit">Commit Changes</button>
                                        </div>
                                    </div><!--  Card Ends here  -->
                                </div> <!-- Col ends here -->
                            </div> <!-- row ends here -->
                        </form>
                        <!-- form ends !-->
                    </div>
                <?php
                                                    }
                                                } else {
                ?>
                <!-- Additional Details Section  2-->
                <div class="row my-3">
                    <div class="col-lg-3">
                        <label for="street">Number and Street</label>
                        <input type="text" class="form-control" id="street" name="street" placeholder="Number and Street" value="<?php if (!empty($irow['street'])) {
                                                                                                                                        echo $irow['street'];
                                                                                                                                    } ?>">
                    </div>
                    <div class="col-lg-3">
                        <label for="barangay">Barangay / Subdivision</label>
                        <input type="text" class="form-control" id="barangay" name="barangay" placeholder="Mother's Email" value="<?php if (!empty($irow['barangay'])) {
                                                                                                                                        echo $irow['barangay'];
                                                                                                                                    } ?>">
                    </div>
                    <div class="col-lg-3">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" name="city" placeholder="City" value="<?php if (!empty($irow['city'])) {
                                                                                                                    echo $irow['city'];
                                                                                                                } ?>">
                    </div>
                    <div class="col-lg-3">
                        <label for="postal">Postal Code</label>
                        <input type="text" class="form-control" id="postal" name="postal" placeholder="Postal Code" value="<?php if (!empty($irow['postal'])) {
                                                                                                                                echo $irow['postal'];
                                                                                                                            } ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <label for="father">Father's Name</label>
                        <input type="text" class="form-control" id="father" name="father" placeholder="Father's Name" value="<?php if (!empty($irow['street'])) {
                                                                                                                                    echo $irow['street'];
                                                                                                                                } ?>">
                    </div>
                    <div class="col-lg-2">
                        <label for="fathermail">Father's Email</label>
                        <input type="text" class="form-control" id="fathermail" name="fathermail" placeholder="Father's Email" value="<?php if (!empty($irow['fathermail'])) {
                                                                                                                                            echo $irow['fathermail'];
                                                                                                                                        } ?>">
                    </div>
                    <div class="col-lg-2">
                        <label for="fatherphone">Father's Phone Number</label>
                        <input type="text" class="form-control" id="fatherphone" name="fatherphone" placeholder="Father's Phone Number" value="<?php if (!empty($irow['fathernumber'])) {
                                                                                                                                                    echo $irow['fathernumber'];
                                                                                                                                                } ?>">
                    </div>
                    <div class="col-lg-2">
                        <label for="fatherwork">Father's Occupation</label>
                        <input type="text" class="form-control" id="fatherwork" name="fatherwork" placeholder="Father's Occupation" value="<?php if (!empty($irow['fatherwork'])) {
                                                                                                                                                echo $irow['fatherwork'];
                                                                                                                                            } ?>">
                    </div>
                    <div class="col-lg-2">
                        <label for="fathercompany">Father's Company</label>
                        <input type="text" class="form-control" id="fathercompany" name="fathercompany" placeholder="Father's Company" value="<?php if (!empty($irow['fatherwork'])) {
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
                        <input type="text" class="form-control" id="mother" name="mother" placeholder="Mother's Name" value="<?php if (!empty($irow['mother'])) {
                                                                                                                                    echo $irow['mother'];
                                                                                                                                } ?>">
                    </div>
                    <div class="col-lg-2">
                        <label for="mothermail">Mother's Email</label>
                        <input type="text" class="form-control" id="mothermail" name="mothermail" placeholder="Mother's Email" value="<?php if (!empty($irow['mothermail'])) {
                                                                                                                                            echo $irow['mothermail'];
                                                                                                                                        } ?>">
                    </div>
                    <div class="col-lg-2">
                        <label for="motherphone">Mothers's Phone Number</label>
                        <input type="text" class="form-control" id="motherphone" name="motherphone" placeholder="Mothers's Phone Number" value="<?php if (!empty($irow['mothernumber'])) {
                                                                                                                                                    echo $irow['mothernumber'];
                                                                                                                                                } ?>">
                    </div>
                    <div class="col-lg-2">
                        <label for="motherwork">Mother's Occupation</label>
                        <input type="text" class="form-control" id="motherwork" name="motherwork" placeholder="Mother's Occupation" value="<?php if (!empty($irow['motherwork'])) {
                                                                                                                                                echo $irow['motherwork'];
                                                                                                                                            } ?>">
                    </div>
                    <div class="col-lg-2">
                        <label for="mothercompany">Mother's Company</label>
                        <input type="text" class="form-control" id="mothercompany" name="mothercompany" placeholder="Mother's Company" value="<?php if (!empty($irow['mcompany'])) {
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
                        <select class="custom-select" id="english1" class="form-select" name="english1">
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
                        <select class="custom-select" id="english2" class="form-select" name="english2">
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
                        <input type="text" class="form-control" id="lang" name="lang" placeholder="Major Languages at home" value="<?php if (!empty($irow['languages'])) {
                                                                                                                                        echo $irow['languages'];
                                                                                                                                    } ?>">
                    </div>
                    <div class="col-lg-2">
                        <label for="alc">ALC</label>
                        <input type="text" class="form-control" id="alc" name="alc" placeholder="ALC" value="<?php if (!empty($irow['advclasses'])) {
                                                                                                                    echo $irow['advclasses'];
                                                                                                                } ?>">
                    </div>
                    <div class="col-lg-2">
                        <label for="remedial">Remedial School</label>
                        <input type="text" class="form-control" id="remedial" name="remedial" placeholder="Remedial School" value="<?php if (!empty($irow['remedial'])) {
                                                                                                                                        echo $irow['remedial'];
                                                                                                                                    } ?>">
                    </div>
                    <div class="col-lg-2">
                        <label for="skill">Special Skill</label>
                        <input type="text" class="form-control" id="skill" name="skill" placeholder="Special Skill" value="<?php if (!empty($irow['skill'])) {
                                                                                                                                echo $irow['skill'];
                                                                                                                            } ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <button type="button" onclick="showNextSection('medical-info')" class="btn btn-success">Next</button>
                    </div>
                </div>
                </section>

                <!-- Medical Information Section 2 -->
                <section id="medical-info" class="hidden">
                    <div class="card-body">
                        <div class="col-lg-12 text-center">
                            <p class="h2">Medical Information and Health History</p>
                            <hr>
                        </div>

                        <div class="row my-3">
                            <div class="col-lg-1 ">
                                <label for="asthma">Asthma</label>
                                <select class="custom-select" id="asthma" class="form-select" name="asthma">
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
                                <input type="text" class="form-control" id="asthmadets" name="asthmadets" placeholder="Asthma Remarks" value="<?php if (!empty($irow['ashtmar'])) {
                                                                                                                                                    echo $irow['ashtmar'];
                                                                                                                                                } ?>">
                            </div>
                            <div class="col-lg-1">
                                <label for="allergies">Allergy</label>
                                <select class="custom-select" id="allergies" class="form-select" name="allergies">
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
                                <input type="text" class="form-control" id="allergiesdets" name="allergiesdets" placeholder="Allergy Remarks" value="<?php if (!empty($irow['allergyr'])) {
                                                                                                                                                            echo $irow['allergyr'];
                                                                                                                                                        } ?>">
                            </div>
                            <div class="col-lg-1">
                                <label for="dallergies">Drug Allergy</label>
                                <select class="custom-select" id="dallergies" class="form-select" name="dallergies">
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
                                <input type="text" class="form-control" id="dallergiesdets" name="dallergiesdets" placeholder="Drug Allergy Remarks" value="<?php if (!empty($irow['drugr'])) {
                                                                                                                                                                echo $irow['drugr'];
                                                                                                                                                            } ?>">
                            </div>
                            <div class="col-lg-1">
                                <label for="speech">Speech</label>
                                <select class="custom-select" id="speech" class="form-select" name="speech">
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
                                <input type="text" class="form-control" id="speechdets" name="speechdets" placeholder="Speech Remarks" value="
                                                    <?php if (!empty($irow['speechr'])) {
                                                        echo $irow['speechr'];
                                                    } ?>">
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-lg-1 ">
                                <label for="vision">Vision</label>
                                <select class="custom-select" id="vision" class="form-select" name="vision">
                                    <option value="
                                                        <?php if (!empty($irow['vision'])) {
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
                            <div class="col-lg-3">
                                <label for="visiondets">Vision Remarks</label>
                                <input type="text" class="form-control" id="visiondets" name="visiondets" placeholder="Vision Remarks" value="<?php if (!empty($irow['visionr'])) {
                                                                                                                                                    echo $irow['visionr'];
                                                                                                                                                } ?>">
                            </div>
                            <div class="col-lg-1">
                                <label for="hearing">Hearing Problems</label>
                                <select class="custom-select" id="hearing" class="form-select" name="hearing">
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
                                <input type="text" class="form-control" id="hearingdets" name="hearingdets" placeholder="Hearing Remarks" value="<?php if (!empty($irow['hearingr'])) {
                                                                                                                                                        echo $irow['hearingr'];
                                                                                                                                                    } ?>">
                            </div>
                            <div class="col-lg-1">
                                <label for="adhd">ADHD</label>
                                <select class="custom-select" id="adhd" class="form-select" name="adhd">
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
                                <input type="text" class="form-control" id="adhddets" name="adhddets" placeholder="ADHD Remarks" value="<?php if (!empty($irow['adhdr'])) {
                                                                                                                                            echo $irow['adhdr'];
                                                                                                                                        } ?>">
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-lg-6">
                                <label for="healthcond">Any other health condition that te school should be aware of?</label>
                                <input type="text" class="form-control" id="healthcond" name="healthcond" placeholder="Other Conditions" value="<?php if (!empty($irow['healthcond'])) {
                                                                                                                                                    echo $irow['healthcond'];
                                                                                                                                                } ?>">
                            </div>
                            <div class="col-lg-6">
                                <label for="hospitalization">Has your child recently been hospitalized?</label>
                                <input type="text" class="form-control" id="hospitalization" name="hospitalization" placeholder="Hospitalization" value="<?php if (!empty($irow['hospitalization'])) {
                                                                                                                                                                echo $irow['hospitalization'];
                                                                                                                                                            } ?>">
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-lg-6">
                                <label for="injuries">Has your child recently had any serious injuries? Why?</label>
                                <input type="text" class="form-control" id="injuries" name="injuries" placeholder="Injuries" value="<?php if (!empty($irow['injuries'])) {
                                                                                                                                        echo $irow['injuries'];
                                                                                                                                    } ?>">
                            </div>
                            <div class="col-lg-6">
                                <label for="medication">Is your child on regular medication?</label>
                                <input type="text" class="form-control" id="medication" name="medication" placeholder="State name of Medication and Frequency" value="<?php if (!empty($irow['medication'])) {
                                                                                                                                                                            echo $irow['medication'];
                                                                                                                                                                        } ?>">
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-lg-2">
                                <label for="general">General Health</label>
                                <select class="custom-select" id="general" class="form-select" name="general">
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
                                <input type="text" class="form-control" id="generaldets" name="generaldets" placeholder="HG Remarks" value="<?php if (!empty($irow['generaldets'])) {
                                                                                                                                                echo $irow['generaldets'];
                                                                                                                                            } ?>">
                            </div>
                            <div class="col-lg-2">
                                <label for="psych">Psychological</label>
                                <select class="custom-select" id="psych" class="form-select" name="psych">
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
                                <input type="text" class="form-control" id="psychdets" name="psychdets" placeholder="Psychological Remarks" value="<?php if (!empty($irow['psychdets'])) {
                                                                                                                                                        echo $irow['psychdets'];
                                                                                                                                                    } ?>">
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-lg-3">
                                <label for="minor">Consent</label>
                                <select class="custom-select" id="minor" class="form-select" name="minor">
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
                                <select class="custom-select" id="emergency" class="form-select" name="emergency">
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
                                <select class="custom-select" id="hospital" class="form-select" name="hospital">
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
                                <select class="custom-select" id="otc" class="form-select" name="otc">
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
                        </div>
                    </div>
                </section>
                <div class="card-footer bg-light text-center">
                    <button class="btn btn-primary btn-lg" type="submit" name="Submit">Commit Changes</button>
                </div>
                </div>
    </div>
</div>
</form>
<!-- form ends !-->
</div>
<?php
                                                }
                                            }
                                            include_once "includes/footer.php"; ?>
</div>
<?php include_once "includes/scripts.php"; ?>
</div>
</div>
<script>
    $("#mainForm").submit(function() {
        if (which == "submit") {
            return false;
        }
    });
</script>
<script>
    function showNextSection(nextSectionId) {
        document.getElementById(nextSectionId).classList.remove('hidden');
    }

    function submitForm() {
        document.getElementById('myForm').submit();
    }

    document.addEventListener('DOMContentLoaded', function() {
        showNextSection('personal-info');
    })
</script>
</body>

</html>
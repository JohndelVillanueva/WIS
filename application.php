<?php
include_once "includes/config.php";
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
            <div class="page-container">
                <div class="main-content">
                    <!-- form starts !-->
                    <form action="newstudent.php" method="post">
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
                                                <label for="applicationtype">Type</label>
                                                <select class="custom-select" id="applicationtype" name="applicationtype" required autofocus>
                                                    <option value="new">New Student</option>
                                                    <option value="visiting">Visiting Student</option>
                                                    <option value="non-credit">Non-credit</option>
                                                    <option value="alp">ALP</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-1">
                                                <label for="syear">SY</label>
                                                <input type="text" class="form-control" id="syear" name="syear" value="2023-24" required disabled>
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="lastname">Last Name</label>
                                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" required>
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="firstname">First Name</label>
                                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" required>
                                            </div>
                                            <div class="col-lg-3">
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
                                            <div class="col-lg-2">
                                                <label for="oldschoolctry">Country</label>
                                                <select id="oldschoolctry" name="oldschoolctry" class="form-control">
                                                    <option value="">-- select one --</option>
                                                    <option value="Afghanistan">Afghanistan</option>
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
                                                    <option value="">-- select one --</option>
                                                    <option value="afghan">Afghan</option>
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
                                                <label for="gradelevel">Level</label>
                                                <select class="custom-select" id="gradelevel" class="form-select" name="gradelevel" required>
                                                    <option value="">-- select one --</option>
                                                    <option value="Nursery">Nursery</option>
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
                                            <div class="col-lg-1" id="row12">
                                                <label for="strand">Strand:</label>
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
                                            <div class="col-lg-3">
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
                                            <div class="col-lg-3">
                                                <label for="visa">Visa Status</label>
                                                <select class="custom-select" id="visa" class="form-select" name="visa">
                                                    <option value="">-- select one --</option>
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
                                        <div class="row">
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
                                        </div>
                                        <div class="card-footer bg-light text-center">
                                            <button class="btn btn-primary btn-lg">Submit Application</button>
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
                        document.getElementById("row12").style.display = "none";
                        document.getElementById("row11").style.display = null;
                        document.getElementById("row11").style.display = "block";
                    } else if (document.getElementById("gradelevel").value == "grade12") {
                        document.getElementById("row11").style.display = "none";
                        document.getElementById("row12").style.display = null;
                        document.getElementById("row12").style.display = "block";
                    }
                }
            </script>
        </div>
    </div>
</body>

</html>
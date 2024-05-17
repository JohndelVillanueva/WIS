<?php
include_once "includes/config.php";
session_start();

// $delete = $DB_con->prepare("DELETE FROM studentdetails WHERE uniqid = :uniqid");
// $delete->execute(array(":uniqid"=>$_POST["uniqid"]));

	// $gettingSpecificId = $DB_con->prepare("SELECT * FROM user WHERE uniqid = :id");
	// $gettingSpecificId->execute([":id" => $row[ 'uniqid' ]]);
	// $result = $gettingSpecificId->fetch(PDO::FETCH_OBJ);

// $uniqId = $DB_con->prepare("SELECT * FROM studentdetails WHERE uniqid = :uniq");
// $uniqId->execute([":uniq" => $_POST["uniqid"]]);
// $getUniqID = $uniqId->fetch(PDO::FETCH_OBJ);

$uniqid = uniqid('WNS-');
$studentdetailsQuery =
	"INSERT INTO studentdetails 
		(uniqid,visa,
		street, barangay,
		city, postal,
		father, fathermail,
		fathernumber, fatherwork,
		fcompany, fsalary,
		mother, mothermail,
		mothernumber, motherwork,
		mcompany, msalary,
		englishrw, englishv,
		languages, advclasses,
		remedial, skill,
		ashtma, ashtmar,
		allergy, allergyr,
		drug, drugr,
		speech, speechr,
		vision, visionr,
		hearing, hearingr,
		adhd, adhdr,
		healthcond, hospitalization,
		injuries, medication,
		general, generaldets,
		psych, psychdets,
		minor, emergency,
		hospital, otc) 
		VALUES (:uniqid,:visa,:street,:barangay,
		:city,:postal,
		:father,:fathermail,
		:fatherphone,:fatherwork,
		:fathercompany,:fsalaryrange,
		:mother,:mothermail,
		:motherphone,:motherwork,
		:mothercompany,:msalaryrange,
		:english1,:english2,
		:lang,:alc,
		:remedial,:skill,
		:ashtma,:asthmadets,
		:allergies, :allergiesdets,
		:dallergies, :dallergiesdets,
		:speech,:speechdets,
		:vision,:visiondets,
		:hearing,:hearingdets,
		:adhd,:adhddets,
		:healthcond,:hospitalization,
		:injuries,:medication,
		:general,:generaldets,
		:psych,:psychdets,
		:minor,:emergency,
		:hospital,:otc)";
$process_statement = $DB_con->prepare( $studentdetailsQuery );
$process_statement->execute(
	array(
		':uniqid' => $uniqid,
		':visa' => $_POST[ 'visa' ],
		':street' => $_POST[ 'street' ],
		':barangay' => $_POST[ 'barangay' ],
		':city' => $_POST[ 'city' ],
		':postal' => $_POST[ 'postal' ],
		':father' => $_POST[ 'father' ],
		':fathermail' => $_POST[ 'fathermail' ],
		':fatherphone' => $_POST[ 'fatherphone' ],
		':fatherwork' => $_POST[ 'fatherwork' ],
		':fathercompany' => $_POST[ 'fathercompany' ],
		':fsalaryrange' => $_POST[ 'fsalaryrange' ],
		':mother' => $_POST[ 'mother' ],
		':mothermail' => $_POST[ 'mothermail' ],
		':motherphone' => $_POST[ 'motherphone' ],
		':motherwork' => $_POST[ 'motherwork' ],
		':mothercompany' => $_POST[ 'mothercompany' ],
		':msalaryrange' => $_POST[ 'msalaryrange' ],
		':english1' => $_POST[ 'english1' ],
		':english2' => $_POST[ 'english2' ],
		':lang' => $_POST[ 'lang' ],
		':alc' => $_POST[ 'alc' ],
		':remedial' => $_POST[ 'remedial' ],
		':skill' => $_POST[ 'skill' ],
		':ashtma' => $_POST[ 'asthma' ],
		':asthmadets' => $_POST[ 'asthmadets' ],
		':allergies' => $_POST[ 'allergies' ],
		':allergiesdets' => $_POST[ 'allergiesdets' ],
		':dallergies' => $_POST[ 'dallergies' ],
		':dallergiesdets' => $_POST[ 'dallergiesdets' ],
		':speech' => $_POST[ 'speech' ],
		':speechdets' => $_POST[ 'speechdets' ],
		':vision' => $_POST[ 'vision' ],
		':visiondets' => $_POST[ 'visiondets' ],
		':hearing' => $_POST[ 'hearing' ],
		':hearingdets' => $_POST[ 'hearingdets' ],
		':adhd' => $_POST[ 'adhd' ],
		':adhddets' => $_POST[ 'adhddets' ],
		':healthcond' => $_POST[ 'healthcond' ],
		':hospitalization' => $_POST[ 'hospitalization' ],
		':injuries' => $_POST[ 'injuries' ],
		':medication' => $_POST[ 'medication' ],
		':general' => $_POST[ 'general' ],
		':generaldets' => $_POST[ 'generaldets' ],
		':psych' => $_POST[ 'psych' ],
		':psychdets' => $_POST[ 'psychdets' ],
		':minor' => $_POST[ 'minor' ],
		':emergency' => $_POST[ 'emergency' ],
		':hospital' => $_POST[ 'hospital' ],
		':otc' => $_POST[ 'otc' ]
	));

	if(isset($_POST['Submit'])){
		$newImage = $_FILES['photo']['name'];

		if($newImage != ''){
			$updateFileName = $newImage;
			if(file_exists("assets/images/avatars".$_FILES['photo']['name'])){
				$filename = $_FILES['photo']['name'];
				echo $filename. "Already Exist";
			}
		}
		
	}

    $insertUserQuery = "INSERT INTO users24 
	(photo,position, fname, lname, mname, gender, guardianname, guardianemail, guardianphone, tf, status, lrn, prevsch, prevschcountry, nationality, grade, section, house, uniqid) 
	VALUES 
	(:photo, :position, :fname, :lname, :mname, :gender, :guardian, :guardianemail, :guardianphone, :tf, :status, :lrn, :oldschool, :oldschoolctry, :nationality, :gradelevel, :section, :house, :uniqid)";

    $userprocess_statement = $DB_con->prepare($insertUserQuery);
    $userprocess_statement->execute(array(
        ':photo' => $updateFileName,
		':position' => "Student",
        ':status' => $_POST['stage'],
        ':tf' => $_POST['tf'],
        ':uniqid' =>  $uniqid,
        ':lname' => $_POST['lastname'],
        ':fname' => $_POST['firstname'],
        ':mname' => $_POST['middlename'],
        ':gender' => $_POST['gender'],
        ':lrn' => $_POST['lrn'],
        ':oldschool' => $_POST['oldschool'],
        ':oldschoolctry' => $_POST['oldschoolctry'],
        ':nationality' => $_POST['nationality'],
        ':gradelevel' => $_POST['gradelevel'],
        ':section' => $_POST['section'],
        ':guardian' => $_POST['guardian'],
        ':guardianemail' => $_POST['guardianemail'],
        ':guardianphone' => $_POST['guardianphone'],
        ':house' => $_POST['house']
    ));
	if($userprocess_statement){
		if($_FILES['photo']['name'] !=''){
			move_uploaded_file($_FILES['photo']['tmp_name'],"assets/images/avatars/".$_FILES['photo']['name']);
		}
		echo "Image Successful";
	}else {
		echo "Image Uploading Failed";
	}

header( "Location: old-students-enroll.php"  );
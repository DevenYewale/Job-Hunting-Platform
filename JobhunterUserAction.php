<?php
// Include configuration file
require_once 'config.php';

// Include and initialize Page DB class
require_once 'JobhunterDB.class.php';
$JobhunterDB = new JobhunterDB();

// Set default redirect url
$redirectURL = 'about:blank';


if(isset($_POST['userSubmit'])){
	// Get form fields value
	$Jobhunter_ID = $_POST['Jobhunter_ID'];
	$FirstName = trim(strip_tags($_POST['FirstName']));
    $LastName = trim(strip_tags($_POST['LastName']));
	$City = trim(strip_tags($_POST['City']));
	$State = trim(strip_tags($_POST['State']));	
    $Email = trim(strip_tags($_POST['Email']));
	$Phone_number = trim(strip_tags($_POST['Phone_number']));
	$Status = trim(strip_tags($_POST['Status']));
	$id_str = '';
	if(!empty($Jobhunter_ID)){
		$id_str = '?Jobhunter_ID='.$Jobhunter_ID;
	}
	
	// Fields validation
	$errorMsg = '';
    if(empty($FirstName)){
		$errorMsg .= '<p>Please enter First Name.</p>';
	}elseif(empty($LastName)){
		$errorMsg .= '<p>Please enter Last Name.</p>';
	}elseif(empty($City)){
		$errorMsg .= '<p>Please enter City where Jobhunter located.</p>';
	}elseif(empty($State)){
		$errorMsg .= '<p>Please enter State where Jobhunter located.</p>';
	}elseif(empty($Email)){
		$errorMsg .= '<p>Please enter Email address of Jobhunter.</p>';
	}elseif(empty($Phone_number)){
		$errorMsg .= '<p>Please enter Phone Number of Jobhunter.</p>';
	}elseif(empty($Status)){
		$errorMsg .= '<p>Please enter Status of Jobhunter</p>';
	}
	
	// Submitted form data
	$JobhunterData = array(
        'Email' => $Email,
        'FirstName' => $FirstName,
        'LastName' => $LastName,
		'Phone_number' => $Phone_number,
		'City' => $City,
        'State' => $State,
		'Status' => $Status,
        'modified' => date("Y-m-d H:i:s")
	);
	
	// Store the submitted field values in the session
	$sessData['userData'] = $JobhunterData;
	
	// Process the form data

    if(empty($errorMsg)){

		if(!empty($Jobhunter_ID)){
			// Get previous data
			$cond = array(
				'where' => array(
					'Jobhunter_ID' => $Jobhunter_ID
				),
				'return_type' => 'single'
			);
			$prevPageData = $JobhunterDB->getRows($cond);

			// Update page data
			$cond = array(
				'Jobhunter_ID' => $Jobhunter_ID
			);
			$update = $JobhunterDB->update($JobhunterData, $cond);

			if($update){
				$sessData['status']['type'] = 'success';
				$sessData['status']['msg'] = 'Jobhunter data has been updated successfully.';

				// Remote submitted fields value from session
				unset($sessData['userData']);
			}else{
				$sessData['status']['type'] = 'error';
				$sessData['status']['msg'] = 'Something went wrong, please try again.';

				// Set redirect url
				$redirectURL = 'JobhunterDashboard.php'.$id_str;
			}
		}else{
			// Insert page data
			$insert = $JobhunterDB->insert($JobhunterData);

			if($insert){
				$sessData['status']['type'] = 'success';
				$sessData['status']['msg'] = 'JobhunterDashboard data has been added successfully.';

				$redirectURL = 'Login.php'.$id_str;
				// Remote submitted fields value from session
				unset($sessData['userData']);
			}else{
				$sessData['status']['type'] = 'error';
				$sessData['status']['msg'] = 'Something went wrong, please try again.';

				// Set redirect url
				$redirectURL = 'JobhunterViewEditProfile.php'.$id_str;
			}
		}
    }else{
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = '<p>Please fill all the mandatory fields.</p>'.$errorMsg;

        // Set redirect url
        $redirectURL = 'JobhunterViewEditProfile.php'.$id_str;
    }
	
	// Store status into the session
}elseif(($_REQUEST['action_type'] == 'delete') && !empty($_GET['Jobhunter_ID'])){
    $Jobhunter_ID = $_GET['Jobhunter_ID'];

    // Get page data
    $cond = array(
        'where' => array(
            'Jobhunter_ID' => $Jobhunter_ID
        ),
        'return_type' => 'single'
    );
    $JobhunterData = $JobhunterDB->getRows($cond);

    // Delete Job from database
    $delete = $JobhunterDB->delete($Jobhunter_ID);

    // Store status into the session
    //$_SESSION['sessData'] = $sessData;
}

// Redirect to the respective page
header("Location:".$redirectURL);
exit();
?>
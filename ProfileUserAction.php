<?php
// Include configuration file
require_once 'config.php';

// Include and initialize Page DB class
require_once 'ProfileDB.class.php';
$ProfileDB = new ProfileDB();

// Set default redirect url
$Jobhunter_ID = !empty($_POST['Jobhunter_ID'])?$_POST['Jobhunter_ID']:$_REQUEST['Jobhunter_ID'];
$redirectURL = 'ProfileIndex.php?Jobhunter_ID='. $Jobhunter_ID;


if(isset($_POST['userSubmit'])){
	// Get form fields value
	$Profile_id = $_POST['Profile_id'];	
	$Profile_Title = trim(strip_tags($_POST['Profile_Title']));
	$Education = trim(strip_tags($_POST['Education']));
	$Role = trim(strip_tags($_POST['Role']));
	$Skills = trim(strip_tags($_POST['Skills']));
	$Work_exp = trim(strip_tags($_POST['Work_exp']));
	$Status = trim(strip_tags($_POST['Status']));
	$id_str = '';
	if(!empty($Profile_id)){
		$id_str = '?Profile_id='.$Profile_id;
	}
	
	// Fields validation
	$errorMsg = '';
    if(empty($Profile_Title)){
		$errorMsg .= '<p>Please enter title.</p>';
	}elseif(empty($Education)){
		$errorMsg .= '<p>Please enter Education.</p>';
	}elseif(empty($Role)){
		$errorMsg .= '<p>Please enter Role.</p>';
	}elseif(empty($Skills)){
		$errorMsg .= '<p>Please enter Skills.</p>';
	}elseif(empty($Work_exp)){
		$errorMsg .= '<p>Please enter Work experience.</p>';
	}elseif(empty($Status)){
		$errorMsg .= '<p>Please enter Profile Status.</p>';
	}
	
	// Submitted form data
	$ProfileData = array(
        'Jobhunter_ID' => $Jobhunter_ID,
		'Profile_Title' => $Profile_Title,
        'Education' => $Education,
        'Role' => $Role,
        'Skills' => $Skills,
        'Work_exp' => $Work_exp,
		'Status' => $Status,
        'modified' => date("Y-m-d H:i:s")
	);
	
	// Store the submitted field values in the session
	$sessData['userData'] = $ProfileData;
	
	// Process the form data


    if(empty($errorMsg)){

		if(!empty($Profile_id)){
			// Get previous data
			$cond = array(
				'where' => array(
					'Profile_id' => $Profile_id
				),
				'return_type' => 'single'
			);
			$prevPageData = $ProfileDB->getRows($cond);
			
			// Update page data
			$cond = array(
				'Profile_id' => $Profile_id
			);
			$update = $ProfileDB->update($ProfileData, $cond);

			if($update){
				$sessData['status']['type'] = 'success';
				$sessData['status']['msg'] = 'Profile data has been updated successfully.';

				// Remote submitted fields value from session
				unset($sessData['userData']);
			}else{
				$sessData['status']['type'] = 'error';
				$sessData['status']['msg'] = 'Something went wrong, please try again.';

				// Set redirect url
				$redirectURL = 'ProfileAddEdit.php?Jobhunter_ID=' . $Jobhunter_ID . $id_str;
			}
		}else{
			// Insert page data
			$insert = $ProfileDB->insert($ProfileData);

			if($insert){
				$sessData['status']['type'] = 'success';
				$sessData['status']['msg'] = 'Profile data has been added successfully.';

				// Remote submitted fields value from session
				unset($sessData['userData']);
			}else{
				$sessData['status']['type'] = 'error';
				$sessData['status']['msg'] = 'Something went wrong, please try again.';

				// Set redirect url
				$redirectURL = 'ProfileAddEdit.php?Jobhunter_ID=' . $Jobhunter_ID . $id_str;
			}
		}
    }else{
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = '<p>Please fill all the mandatory fields.</p>'.$errorMsg;

        // Set redirect url
        $redirectURL = 'ProfileAddEdit.php?Jobhunter_ID=' . $Jobhunter_ID . $id_str;
    }
	
	// Store status into the session
}elseif(($_REQUEST['action_type'] == 'delete') && !empty($_GET['Profile_id'])){
    $Profile_id = $_GET['Profile_id'];

    // Get page data
    $cond = array(
        'where' => array(
            'Profile_id' => $Profile_id
        ),
        'return_type' => 'single'
    );
    $ProfileData = $ProfileDB->getRows($cond);

    // Delete Profile from database
    $delete = $ProfileDB->delete($Profile_id);

    // Store status into the session
    //$_SESSION['sessData'] = $sessData;
}

// Redirect to the respective page//
header("Location:".$redirectURL);
exit();
?>
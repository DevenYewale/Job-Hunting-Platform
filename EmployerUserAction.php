<?php
// Include configuration file
require_once 'config.php';

// Include and initialize Page DB class
require_once 'EmployerDB.class.php';
$EmployerDB = new EmployerDB();

// Set default redirect url
$redirectURL = 'about:blank';

if(isset($_POST['userSubmit'])){
	// Get form fields value
	$Company_ID = $_POST['Company_ID'];
	$CompanyName = trim(strip_tags($_POST['CompanyName']));
	$Company_Category = trim(strip_tags($_POST['Company_Category']));
	$City = trim(strip_tags($_POST['City']));
	$State = trim(strip_tags($_POST['State']));
	$Contact_Person = trim(strip_tags($_POST['Contact_Person']));
	$Position = trim(strip_tags($_POST['Position']));
	$Phone_NO = trim(strip_tags($_POST['Phone_NO']));
	$Email = trim(strip_tags($_POST['Email']));	
	$Status = trim(strip_tags($_POST['Status']));
	$id_str = '';
	if(!empty($Company_ID)){
		$id_str = '?Company_ID='.$Company_ID;		
	} else {
		$Password = trim(strip_tags($_POST['Password']));
	}
	
	// Fields validation
	$errorMsg = '';
    if(empty($CompanyName)){
		$errorMsg .= '<p>Please enter Company Name.</p>';
	}elseif(empty($Company_Category)){
		$errorMsg .= '<p>Please enter Company Category.</p>';
	}elseif(empty($City)){
		$errorMsg .= '<p>Please enter City where company located.</p>';
	}elseif(empty($State)){
		$errorMsg .= '<p>Please enter State where company located.</p>';
	}elseif(empty($Contact_Person)){
		$errorMsg .= '<p>Please enter contact person of company.</p>';
	}elseif(empty($Position)){
		$errorMsg .= '<p>Please enter Position of Contact Person.</p>';
	}elseif(empty($Phone_NO)){
		$errorMsg .= '<p>Please enter Phone Number  of Contact Person.</p>';
	}elseif(empty($Email)){
		$errorMsg .= '<p>Please enter Email address of Contact Person.</p>';
	}elseif(empty($Company_ID) && empty($Password)){
		$errorMsg .= '<p>Please enter Email address of Contact Person.</p>';
	}elseif(empty($Status)){
		$errorMsg .= '<p>Please enter Registration Status.</p>';
	}
	
	// Submitted form data
	if (empty($Company_ID)) {
		$EmployerData = array(
			'CompanyName' => $CompanyName,
			'Company_Category' => $Company_Category,
			'City' => $City,
			'State' => $State,
			'Contact_Person' => $Contact_Person,
			'Position' => $Position,
			'Phone_NO' => $Phone_NO,
			'Email' => $Email,
			'Password' => $Password,
			'Status' => $Status,
			'modified' => date("Y-m-d H:i:s")
		);
	
	} else{
		$EmployerData = array(
			'CompanyName' => $CompanyName,
			'Company_Category' => $Company_Category,
			'City' => $City,
			'State' => $State,
			'Contact_Person' => $Contact_Person,
			'Position' => $Position,
			'Phone_NO' => $Phone_NO,
			'Email' => $Email,
			'Status' => $Status,
			'modified' => date("Y-m-d H:i:s")
		);
	
	}
	
	// Store the submitted field values in the session
	$sessData['userData'] = $EmployerData;
	
	// Process the form data

    if(empty($errorMsg)){

		if(!empty($Company_ID)){
			// Get previous data
			$cond = array(
				'where' => array(
					'Company_ID' => $Company_ID
				),
				'return_type' => 'single'
			);
			$prevPageData = $EmployerDB->getRows($cond);

			// Update page data
			$cond = array(
				'Company_ID' => $Company_ID
			);
			$update = $EmployerDB->update($EmployerData, $cond);

			if($update){
				$sessData['status']['type'] = 'success';
				$sessData['status']['msg'] = 'Compnay data has been updated successfully.';

				// Remote submitted fields value from session
				unset($sessData['userData']);
			}else{
				$sessData['status']['type'] = 'error';
				$sessData['status']['msg'] = 'Something went wrong, please try again.';

				// Set redirect url
				$redirectURL = 'EmployerDashboard.php'.$id_str;
			}
		}else{
			// Insert page data
			$insert = $EmployerDB->insert($EmployerData);
			
			if($insert){
				$sessData['status']['type'] = 'success';
				$sessData['status']['msg'] = 'Employee data has been added successfully.';

				// Remote submitted fields value from session
				unset($sessData['userData']);
				$redirectURL = 'Login.php'.$id_str;
			}else{
				$sessData['status']['type'] = 'error';
				$sessData['status']['msg'] = 'Something went wrong, please try again.';

				// Set redirect url
				$redirectURL = 'EmployerViewEditProfile.php'.$id_str;
			}
		}
    }else{
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = '<p>Please fill all the mandatory fields.</p>'.$errorMsg;

        // Set redirect url
        $redirectURL = 'EmployerViewEditProfile.php'.$id_str;
    }
	
	// Store status into the session
}elseif(($_REQUEST['action_type'] == 'delete') && !empty($_GET['Company_ID'])){
    $Company_ID = $_GET['Company_ID'];

    // Get page data
    $cond = array(
        'where' => array(
            'Company_ID' => $Company_ID
        ),
        'return_type' => 'single'
    );
    $EmployerData = $EmployerDB->getRows($cond);

    // Delete Job from database
    $delete = $EmployerDB->delete($Company_ID);

    // Store status into the session
    //$_SESSION['sessData'] = $sessData;
}



// Redirect to the respective page
header("Location:".$redirectURL);
exit();
?>
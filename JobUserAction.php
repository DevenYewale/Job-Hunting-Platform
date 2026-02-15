<?php
// Include configuration file
require_once 'config.php';

// Include and initialize Page DB class
require_once 'JobDB.class.php';
$JobDB = new JobDB();

$Company_ID = !empty($_POST['Company_ID'])?$_POST['Company_ID']:$_REQUEST['Company_ID'];

// Set default redirect url
$redirectURL = 'JobIndex.php?Company_ID='. $Company_ID;

if(isset($_POST['userSubmit'])){
	// Get form fields value
	$Job_ID = $_POST['Job_ID'];	
	$Job_Category = trim(strip_tags($_POST['Job_Category']));
	$Job_Title = trim(strip_tags($_POST['Job_Title']));
	$Job_Location = trim(strip_tags($_POST['Job_Location']));
	$Openings = trim(strip_tags($_POST['Openings']));
	$Salary = trim(strip_tags($_POST['Salary']));
	$Experience_Level = trim(strip_tags($_POST['Experience_Level']));
	$Status = trim(strip_tags($_POST['Status']));
	$Job_Description = trim(strip_tags($_POST['Job_Description']));
	$id_str = '';
	if(!empty($Job_ID)){
		$id_str = '?Job_ID='.$Job_ID;
	}
	
	// Fields validation
	$errorMsg = '';
    if(empty($Job_Title)){
		$errorMsg .= '<p>Please enter title.</p>';
	}elseif(empty($Job_Category)){
		$errorMsg .= '<p>Please enter Job Category.</p>';
	}elseif(empty($Job_Location)){
		$errorMsg .= '<p>Please enter Job Location.</p>';
	}elseif(empty($Job_Description)){
		$errorMsg .= '<p>Please enter Job Description.</p>';
	}elseif(empty($Openings)){
		$errorMsg .= '<p>Please enter Job Openings.</p>';
	}elseif(empty($Salary)){
		$errorMsg .= '<p>Please enter Job Salary.</p>';
	}elseif(empty($Experience_Level)){
		$errorMsg .= '<p>Please enter Job Experience Level.</p>';
	}elseif(empty($Status)){
		$errorMsg .= '<p>Please enter Job Status.</p>';
	}
	
	// Submitted form data
	$JobData = array(
        'Company_ID' => $Company_ID,
		'Job_Category' => $Job_Category,
		'Job_Title' => $Job_Title,
        'Job_Description' => $Job_Description,
        'Job_Location' => $Job_Location,
        'Openings' => $Openings,
        'Salary' => $Salary,
        'Experience_Level' => $Experience_Level,
		'Status' => $Status,
        'modified' => date("Y-m-d H:i:s")
	);
	
	// Store the submitted field values in the session
	$sessData['userData'] = $JobData;
	
	// Process the form data

    if(empty($errorMsg)){

		if(!empty($Job_ID)){
			// Get previous data
			$cond = array(
				'where' => array(
					'Job_ID' => $Job_ID
				),
				'return_type' => 'single'
			);
			$prevPageData = $JobDB->getRows($cond);

			// Update page data
			$cond = array(
				'Job_ID' => $Job_ID
			);
			$update = $JobDB->update($JobData, $cond);

			if($update){
				$sessData['status']['type'] = 'success';
				$sessData['status']['msg'] = 'Job data has been updated successfully.';

				// Remote submitted fields value from session
				unset($sessData['userData']);
			}else{
				$sessData['status']['type'] = 'error';
				$sessData['status']['msg'] = 'Something went wrong, please try again.';

				// Set redirect url
				$redirectURL = 'JobAddEdit.php?Company_ID='.$Company_ID . '&' .$id_str;
			}
		}else{
			// Insert page data
			$insert = $JobDB->insert($JobData);

			if($insert){
				$sessData['status']['type'] = 'success';
				$sessData['status']['msg'] = 'Job data has been added successfully.';

				// Remote submitted fields value from session
				unset($sessData['userData']);
			}else{
				$sessData['status']['type'] = 'error';
				$sessData['status']['msg'] = 'Something went wrong, please try again.';

				// Set redirect url
				$redirectURL = 'JobAddEdit.php?Company_ID='.$Company_ID . '&' .$id_str;
			}
		}
    }else{
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = '<p>Please fill all the mandatory fields.</p>'.$errorMsg;

        // Set redirect url
        $redirectURL = 'JobAddEdit.php?Company_ID='.$Company_ID . '&' .$id_str;
    }
	
	// Store status into the session
}elseif(($_REQUEST['action_type'] == 'delete') && !empty($_GET['Job_ID'])){
    $Job_ID = $_GET['Job_ID'];

    // Get page data
    $cond = array(
        'where' => array(
            'Job_ID' => $Job_ID
        ),
        'return_type' => 'single'
    );
    $JobData = $JobDB->getRows($cond);

    // Delete Job from database
    $delete = $JobDB->delete($Job_ID);
}

// Redirect to the respective page
header("Location:".$redirectURL);
exit();
?>
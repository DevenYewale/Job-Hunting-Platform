<?php
// Include configuration file
require_once 'config.php';

// Include and initialize Page DB class
require_once 'JobHunterDB.class.php';
require_once 'EmployerDB.class.php';

$JobhunterDB = new JobhunterDB();
$EmployerDB = new EmployerDB();

$redirectURL = 'Login.php';
$UserType = $_POST['UserType'];

if(isset($_POST['userSubmit'])){
	// Get form fields value
	
	$Email = strtolower(trim(strip_tags($_POST['Email'])));
	$Passowrd = trim(strip_tags($_POST['Passowrd']));

	// Fields validation
	$errorMsg = '';
    if(empty($Email)){
		$errorMsg .= '<p>Please enter Email.</p>';
	}elseif(empty($Passowrd)){
		$errorMsg .= '<p>Please enter Passowrd.</p>';
	}
	
    if(empty($errorMsg))
    {
        
        if($UserType == 'Jobhunter' ){

            // Fetch data from database by row ID
            $cond = array(
                'where' => array(
                    'Email' => $Email,
                    'Password' => $Passowrd
                ),
                'return_type' => 'all'
            );
            $JobhunterData = $JobhunterDB->getRows($cond);
            if(!empty($JobhunterData)){ $count = 0; foreach($JobhunterData as $row){ $count++; 
                $AccountID = $row['JobHunter_ID'];
                $AccountName = $row['FirstName'] . " " . $row['LastName'] ;
                $sessData['status']['type'] = 'success';
                $sessData['status']['msg'] = 'Login successfully.';
                $redirectURL = 'JobHunterDashboard.php?AccountID=' . $AccountID . '&AccountName=' . $AccountName;
             } 
            }else{
                $AccountID = "";
                $AccountName = "";
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Invalid login credentials, please try again.';
                $redirectURL = 'Login.php';
            }
        }else{
            // Fetch data from database by row ID
            $cond = array(
                'where' => array(
                    'Email' => $Email,
                    'Password' => $Passowrd
                ),
                'return_type' => 'all'
            );
           
            $EmployerData = $EmployerDB->getRows($cond);
            if(!empty($EmployerData)){ $count = 0; foreach($EmployerData as $row){ $count++; 
                echo $row['Company_ID'];

                $AccountID = $row['Company_ID'];
                $AccountName = $row['CompanyName'] ;
                $sessData['status']['type'] = 'success';
                $sessData['status']['msg'] = 'Login successfully.';
                $redirectURL = 'EmployerDashboard.php?AccountID=' . $AccountID . '&AccountName=' . $AccountName;
             } 
            }else{
                $AccountID = "";
                $AccountName = "";
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Invalid login credentials, please try again.';
                $redirectURL = 'Login.php';
            }
        }

    }else
    {
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = '<p>Please fill all the mandatory fields.</p>'.$errorMsg;

        // Set redirect url
        $redirectURL = 'Login.php';
    }
}elseif(isset($_POST['Register'])){
    if($UserType == 'Jobhunter' ){
        $redirectURL = 'JobhunterViewEditProfile.php';
    }else {
        $redirectURL = 'EmployerViewEditProfile.php';
    }
}


//echo $redirectURL;

// Redirect to the respective page
header("Location:".$redirectURL);
exit();
?>
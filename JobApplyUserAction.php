<?php
// Include configuration file
require_once 'config.php';

// Include and initialize Page DB class
require_once 'JobDb.class.php';
$JobDb = new JobDb();

// Set default redirect url
//$redirectURL = 'about:blank';


if(isset($_POST['userSubmit'])){
	// Get form fields value
	$Jobhunter_ID = $_POST['Jobhunter_ID'];
	$Job_ID = $_POST['Job_ID'];
	$Company_ID = $_POST['Company_ID'];
	$Profile_ID = $_POST['Profile_ID'];
  
    $StatusJobApplication = $JobDb->UpdateJobApplication($Job_ID, $Company_ID, $Profile_ID, $Jobhunter_ID);
  
    $pages = $JobDb->GetJobDetails($Job_ID, $Company_ID);
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Job Applied</title>
<meta charset="utf-8">

<!-- Bootstrap library -->
<link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">

<!-- Stylesheet file -->
<link rel="stylesheet" href="assets/css/style.css"/>

</head>
<body>
<div class="container">
	<h1>Job Applied</h1>
	<div class="row">
        <!-- List the pages -->
                <?php if(!empty($pages)){ $countOuter = 0; foreach($pages as $row){ $countOuter++; ?>
                    <table class="table table-striped table-bordered">
                        <tbody>
                            <tr>
                                <td>
                                    <b><?php echo $row['Job_Title']; ?></b></br>
                                    <?php echo $row['CompanyName']; ?></br>
                                    <?php echo $row['Job_Category']; ?></br>
                                </td>
                                <td colspan=2><?php echo $row['Job_Description']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo $row['Experience_Level']; ?></td>
                                <td><?php echo $row['Salary']; ?></td>
                                <td><?php echo $row['Job_Location']; ?></td>
                            </tr>
                                <td><?php echo $row['Openings']; ?></td>
                                <td><?php echo $row['created']; ?></td>
                                <td>APPLIED SUCCESSFULLY</td>
                            </tr>
                        </tbody>
                    </table>
                </br>
                <?php } } ?>
    </div>
</div>
</body>
</html>
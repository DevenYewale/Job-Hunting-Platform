<?php
// Include configuration file
require_once 'config.php';

// Retrieve session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

$AccountID = $_GET['AccountID'];
$AccountName = $_GET['AccountName'];


// Get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Employer Homepage</title>
<meta charset="utf-8">

<!-- Bootstrap library -->
<link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">

<!-- Stylesheet file -->
<link rel="stylesheet" href="assets/css/style.css"/>

</head>
<body>
<div class="container">
	<h1>Employer Dashboard - <?php echo $AccountName ?> </h1>
    
	<!-- Display status message -->
	<?php if(!empty($statusMsg) && ($statusMsgType == 'success')){ ?>
	<div class="col-xs-12">
		<div class="alert alert-success"><?php echo $statusMsg; ?></div>
	</div>
	<?php }elseif(!empty($statusMsg) && ($statusMsgType == 'error')){ ?>
	<div class="col-xs-12">
		<div class="alert alert-danger"><?php echo $statusMsg; ?></div>
	</div>
	<?php } ?>
	
    <div class="row">
        <div class="col-md-9">
		<a href="Login.php?Mode='Logout'" class="btn btn-secondary">Logout</a>
		<a href="EmployerViewEditProfile.php?Company_ID=<?php echo $AccountID; ?>" class="btn btn-outline-warning" target="Employee_Iframe">View Profile</a>
		<a href="JobIndex.php?Company_ID=<?php echo $AccountID;; ?>" class="btn btn-outline-warning" target="Employee_Iframe">View Job Postings</a>
		</div>
    </div>
	<iframe src="about:blank" style="border:none;height:800px;" width="100%" name="Employee_Iframe"  title="Employee Iframe"></iframe>
</div>
</body>
</html>
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
<title>Jobhunter Homepage</title>
<meta charset="utf-8">

<!-- Bootstrap library -->
<link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">

<!-- Stylesheet file -->
<link rel="stylesheet" href="assets/css/style.css"/>
</head>
<body>
<div class="container">
	<h1>JobHunter Dashboard - Welcome back <?php echo $AccountName ?> </h1>
    
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
		<a href="JobhunterViewEditProfile.php?Jobhunter_ID=<?php echo $AccountID; ?>" class="btn btn-outline-warning" target="Jobhunter_Iframe">My Profile</a>
		<a href="ProfileIndex.php?Jobhunter_ID=<?php echo $AccountID; ?>" class="btn btn-outline-warning" target="Jobhunter_Iframe">View Job Profiles</a>
		<form action="JobSearch.php" method="post" target="Jobhunter_Iframe">
			<input type="text" style=".cms_editor_content"  name="JobSearch" placeholder="Enter Search Criteria">
			<input type="hidden" name="Jobhunter_ID" value="<?php echo $AccountID ?>">
			<input type="submit" name="userSubmit" class="btn btn-success" value="Search">
		</Form>	
	</div>
    </div>
	<iframe src="about:blank" style="border:none;height:800px;" width="100%" name="Jobhunter_Iframe"  title="Jobhunter_Iframe"></iframe>

</div>
</body>
</html>
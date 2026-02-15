<?php
// Include configuration file
require_once 'config.php';

// Retrieve session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

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
<title>Login</title>
<meta charset="utf-8">

<!-- Bootstrap library -->
<link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">

<!-- Stylesheet file -->
<link rel="stylesheet" href="assets/css/style.css"/>

</head>
<body>
<div class="container">
	<h1>Login</h1>
    
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
             <form method="post" action="LoginAction.php">

             <table class="table table-striped table-bordered">
                <tbody>
                <tr>
                    <td width="15%">User Type</td>
                    <td width="85%">
                    <input type="radio" name="UserType" id="User_Employer" value="Employer" />
                        <label for="User_Employer">Employer</label>
                    <input type="radio" name="UserType" id="User_JobHunter" value="Jobhunter" checked />
                        <label for="User_JobHunter">Jobhunter</label>
                    </td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="text" class="form-control" name="Email" placeholder="Enter Email"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="text" class="form-control" name="Passowrd" placeholder="Enter Password"></td>
                </tr>
            </table>
                <input type="submit" name="Register" class="btn btn-success" value="Register">
                <input type="submit" name="userSubmit" class="btn btn-success" value="Login">
            </form>
        </div>
    </div>

</div>
</body>
</html>
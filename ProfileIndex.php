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
$Jobhunter_ID = '';
$ProfileData = $userData = array();
if(!empty($_GET['Jobhunter_ID'])){
    $Jobhunter_ID = $_GET['Jobhunter_ID'];

	// Include and initialize Page DB class
    require_once 'ProfileDb.class.php';
    $ProfileDb = new ProfileDb();

	// Fetch data from database by row ID
    $cond = array(
        'where' => array(
            'Jobhunter_ID' => $Jobhunter_ID
        ),
        'return_type' => 'all'
    );
    $pages = $ProfileDb->getRows($cond);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Profile Listing</title>
<meta charset="utf-8">

<!-- Bootstrap library -->
<link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">

<!-- Stylesheet file -->
<link rel="stylesheet" href="assets/css/style.css"/>

</head>
<body>
<div class="container">
	<h1>Profile Listing</h1>
    
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
        <div class="col-md-12 head">
            <h5>Profiles</h5>
            <!-- Add link -->
            <div class="float-right">
                <a href="ProfileAddEdit.php?Jobhunter_ID=<?php echo $Jobhunter_ID; ?>" class="btn btn-success"><i class="plus"></i> New Profiles</a>
            </div>
        </div>
        
        <!-- List the pages -->
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th width="3%">#</th>
                    <th width="15%">Profile Title</th>
                    <th width="15%">Education</th>
                    <th width="10%">Role</th>
                    <th width="10%">Skills</th>
                    <th width="10%">Work_exp</th>
                    <th width="10%">Created On</th>
                    <th width="10%">Status</th>
                    <th width="17%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($pages)){ $count = 0; foreach($pages as $row){ $count++; ?>
                <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $row['Profile_Title']; ?></td>
                    <td><?php echo $row['Education']; ?></td>
                    <td><?php echo $row['Role']; ?></td>
                    <td><?php echo $row['Skills']; ?></td>
                    <td><?php echo $row['Work_exp']; ?></td>
                    <td><?php echo $row['created']; ?></td>
                    <td><?php echo $row['Status']; ?></td>
                    <td>
                        <a href="ProfileAddEdit.php?Jobhunter_ID=<?php echo $Jobhunter_ID; ?>&Profile_id=<?php echo $row['Profile_id']; ?>" class="btn btn-outline-warning">view/edit</a>
                        <a href="ProfileUserAction.php?action_type=delete&Jobhunter_ID=<?php echo $Jobhunter_ID; ?>&Profile_id=<?php echo $row['Profile_id']; ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure to delete?');">delete</a>
                    </td>
                </tr>
                <?php } }else{ ?>
                <tr><td colspan="5">No Profile(s) found...</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
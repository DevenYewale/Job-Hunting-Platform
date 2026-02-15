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
$Company_ID = '';
$JobData = $userData = array();
if(!empty($_GET['Company_ID'])){
    $Company_ID = $_GET['Company_ID'];

	// Include and initialize Page DB class
    require_once 'JobDb.class.php';
    $JobDb = new JobDb();

	// Fetch data from database by row ID
    $cond = array(
        'where' => array(
            'Company_ID' => $Company_ID
        ),
        'return_type' => 'all'
    );
    $pages = $JobDb->getRows($cond);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Job Listing</title>
<meta charset="utf-8">

<!-- Bootstrap library -->
<link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">

<!-- Stylesheet file -->
<link rel="stylesheet" href="assets/css/style.css"/>

</head>
<body>
<div class="container">
	<h1>Job Listing</h1>
    
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
            <h5>Jobs</h5>
            <!-- Add link -->
            <div class="float-right">
                <a href="JobAddEdit.php?Company_ID=<?php echo $Company_ID; ?>" class="btn btn-success"><i class="plus"></i> New Jobs</a>
            </div>
        </div>
        
        <!-- List the pages -->
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th width="3%">#</th>
                    <th width="10%">Job Category</th>
                    <th width="10%">Job Title</th>
                    <th width="10%">Job Location</th>
                    <th width="10%">Openings</th>
                    <th width="10%">Salary</th>
                    <th width="10%">Experience</th>
                    <th width="10%">Created On</th>
                    <th width="10%">Status</th>
                    <th width="17%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($pages)){ $count = 0; foreach($pages as $row){ $count++; ?>
                <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $row['Job_Category']; ?></td>
                    <td><?php echo $row['Job_Title']; ?></td>
                    <td><?php echo $row['Job_Location']; ?></td>
                    <td><?php echo $row['Openings']; ?></td>
                    <td><?php echo $row['Salary']; ?></td>
                    <td><?php echo $row['Experience_Level']; ?></td>
                    <td><?php echo $row['created']; ?></td>
                    <td><?php echo $row['Status']; ?></td>
                    <td>
                        <a href="JobAddEdit.php?Company_ID=<?php echo $Company_ID; ?>&Job_ID=<?php echo $row['Job_ID']; ?>" class="btn btn-outline-warning">view/edit</a>
                        <a href="JobUserAction.php?action_type=delete&Company_ID=<?php echo $Company_ID; ?>&Job_ID=<?php echo $row['Job_ID']; ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure to delete?');">delete</a>
                    </td>
                </tr>
                <?php } }else{ ?>
                <tr><td colspan="5">No Job(s) found...</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
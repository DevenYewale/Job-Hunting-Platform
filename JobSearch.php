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

$SearchCriteria = $_POST['JobSearch'];
$JobhunterID = $_POST['Jobhunter_ID'];

$JobData = $userData = array();
// Include and initialize Page DB class
require_once 'JobDb.class.php';
require_once 'ProfileDb.class.php';

$ProfileDB = new ProfileDb();
$JobDb = new JobDb();

// Fetch data from database by row ID
$cond = array(
    'where' => array(
        'Job_Category' => $SearchCriteria,
        'Job_Description' => $SearchCriteria,
        'Job_Location' => $SearchCriteria,
        'Job_Title' => $SearchCriteria,
        'Openings' => $SearchCriteria,
        'Salary' => $SearchCriteria,
        'Experience_Level' => $SearchCriteria,
    ),
    'return_type' => 'all'
);
$pages = $JobDb->getRowsOR($cond);

$ProfileDD = $ProfileDB->GetProfileList($JobhunterID);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Job Searching</title>
<meta charset="utf-8">

<!-- Bootstrap library -->
<link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">

<!-- Stylesheet file -->
<link rel="stylesheet" href="assets/css/style.css"/>

</head>
<body>
<div class="container">
	<h1>Job Search</h1>
    
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
                                <td>
                                <?php if (empty($row['Profile_Title'])){ ?>
                                <form action="JobApplyUserAction.php" name="JobApply" method="post">
                                    <input type="hidden" name="Jobhunter_ID" value="<?php echo $JobhunterID ?>">
                                    <input type="hidden" name="Job_ID" value="<?php echo $row['Job_ID']; ?>">
                                    <input type="hidden" name="Company_ID" value="<?php echo $row['Company_ID']; ?>">
                                    <select name="Profile_ID<?php echo $countOuter; ?>">
                                    <?php if(!empty($ProfileDD)){ $count = 0; foreach($ProfileDD as $dropdown){ $count++; ?>
                                    <option value="<?php echo $dropdown["Profile_id"];?>"><?php echo $dropdown["Profile_Title"];?></option>
                                    <?php } }?>
                                    </select>
                                    <input type="submit" name="userSubmit<?php echo $countOuter; ?>" class="btn btn-success" value="Apply">
                                </Form>
                                <?php } else {?>
                                    Applied on <?php echo $row['Application_Date']; ?> using Profile - <?php echo $row['Profile_Title']; ?>
                                <?php } ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </br>
                <?php } }else{ ?>
                    <table class="table table-striped table-bordered">
                        <tr><td colspan="5">No Job(s) found...</td></tr>
                    </table>
                <?php } ?>
    </div>
</div>
</body>
</html>
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

// Get Job data
$Job_ID = '';
$JobData = $userData = array();
$Company_ID = $_GET['Company_ID'];
if(!empty($_GET['Job_ID'])){
    $Job_ID = $_GET['Job_ID'];

	// Include and initialize Page DB class
    require_once 'JobDB.class.php';
    $JobDB = new JobDB();
	
	// Fetch data from database by row ID
    $cond = array(
        'where' => array(
            'Job_ID' => $Job_ID
        ),
        'return_type' => 'single'
    );
    $JobData = $JobDB->getRows($cond);
}
$userData = !empty($sessData['userData'])?$sessData['userData']:$JobData;
unset($_SESSION['sessData']['userData']);

$actionLabel = !empty($Job_ID)?'Edit':'Add';

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Add Jobs</title>
<meta charset="utf-8">

<!-- Bootstrap library -->
<link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">

<!-- Stylesheet file -->
<link rel="stylesheet" href="assets/css/style.css"/>

<!-- jQuery library -->
<script src="assets/js/jquery.min.js"></script>

<!-- TinyMCE plugin library -->
<script src="assets/js/tinymce/tinymce.min.js"></script>

<!-- Initialize TinyMCE -->
<script>
tinymce.init({
	selector: '#page_content',
	plugins: [
	  'lists', 'link', 'image', 'preview', 'anchor',
      'visualblocks', 'code', 'fullscreen',
      'table', 'code', 'help', 'wordcount'
    ],
	toolbar: 'undo redo | formatselect | ' +
	  'bold italic underline strikethrough | alignleft aligncenter ' +
	  'alignright alignjustify | bullist numlist outdent indent | ' +
	  'forecolor backcolor | link image | preview | ' +
	  'removeformat | help',
    menubar: 'edit view format help'
});
</script>
</head>
<body>
<div class="container">
	<h1>Add Jobs</h1>
    
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
		<div class="col-md-12">
			<h2><?php echo $actionLabel; ?> Job</h2>
		</div>
        <div class="col-md-9">
             <form method="post" action="JobUserAction.php">

             <table class="table table-striped table-bordered">
                <tbody>
                <tr>
                    <td width="25%">Job Category</td>
                    <td width="75%"><input type="text" class="form-control" name="Job_Category" placeholder="Enter Job Category" value="<?php echo !empty($userData['Job_Category'])?$userData['Job_Category']:''; ?>" required=""></td>
                </tr>
                <tr>
                    <td>Job Title</td>
                    <td><input type="text" class="form-control" name="Job_Title" placeholder="Enter Job title" value="<?php echo !empty($userData['Job_Title'])?$userData['Job_Title']:''; ?>" required=""></td>
                </tr>
                <tr>
                    <td>Job Location</td>
                    <td><input type="text" class="form-control" name="Job_Location" placeholder="Enter Job Location" value="<?php echo !empty($userData['Job_Location'])?$userData['Job_Location']:''; ?>" required=""></td>
                </tr>
                <tr>
                    <td>Openings</td>
                    <td><input type="text" class="form-control" name="Openings" placeholder="Enter Openings" value="<?php echo !empty($userData['Openings'])?$userData['Openings']:''; ?>" required=""></td>
                </tr>
                <tr>
                    <td>Salary</td>
                    <td><input type="text" class="form-control" name="Salary" placeholder="Enter page Salary" value="<?php echo !empty($userData['Salary'])?$userData['Salary']:''; ?>" required=""></td>
                </tr>
                <tr>
                    <td>Experience Level</td>
                    <td><input type="text" class="form-control" name="Experience_Level" placeholder="Enter Experience Level" value="<?php echo !empty($userData['Experience_Level'])?$userData['Experience_Level']:''; ?>" required=""></td>
                </tr>
                <tr>
                    <td>Job Description</td>
                    <td>
                        <div class="form-group">
                            <textarea class="form-control" name="Job_Description" id="Job_Description" placeholder="Enter Job Description here..."><?php echo !empty($userData['Job_Description'])?$userData['Job_Description']:''; ?></textarea></td>
                        </div>
                    </tr>
                <tr>
                    <td>Status</td>
                    <td><input type="text" class="form-control" name="Status" placeholder="Enter Status" value="<?php echo !empty($userData['Status'])?$userData['Status']:''; ?>" required=""></td>
                </tr>
            </table>
                <a href="JobIndex.php" class="btn btn-secondary">Back</a>
                <input type="hidden" name="Job_ID" value="<?php echo !empty($JobData['Job_ID'])?$JobData['Job_ID']:''; ?>">
                <input type="hidden" name="Company_ID" value="<?php echo $Company_ID; ?>">
                <input type="submit" name="userSubmit" class="btn btn-success" value="Submit">
            </form>
        </div>
    </div>
</div>
</body>
</html>
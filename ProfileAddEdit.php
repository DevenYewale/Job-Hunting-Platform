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



// Get page data

$Profile_id = '';
$ProfileData = $userData = array();
$Jobhunter_ID = $_GET['Jobhunter_ID'];
if(!empty($_GET['Profile_id'])){
    $Profile_id = $_GET['Profile_id'];

	// Include and initialize Page DB class
    require_once 'ProfileDB.class.php';
    $ProfileDB = new ProfileDB();
	
	// Fetch data from database by row ID
    $cond = array(
        'where' => array(
            'Profile_id' => $Profile_id
        ),
        'return_type' => 'single'
    );
    $ProfileData = $ProfileDB->getRows($cond);
}
$userData = !empty($sessData['userData'])?$sessData['userData']:$ProfileData;
unset($_SESSION['sessData']['userData']);

$actionLabel = !empty($Profile_id)?'Edit':'Add';

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Add Profiles</title>
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
	<h1>Add Profiles</h1>
    
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
			<h2><?php echo $actionLabel; ?> Profile</h2>
		</div>
        <div class="col-md-9">
             <form method="post" action="ProfileUserAction.php">

             <table class="table table-striped table-bordered">
                <tbody>
                <tr>
                    <td width="15%">Profile</td>
                    <td width="85%"><input type="text" class="form-control" name="Profile_Title" placeholder="Enter Profile title" value="<?php echo !empty($userData['Profile_Title'])?$userData['Profile_Title']:''; ?>" required=""></td>
                </tr>
                <tr>
                    <td>Education</td>
                    <td><input type="text" class="form-control" name="Education" placeholder="Enter Profile Education" value="<?php echo !empty($userData['Education'])?$userData['Education']:''; ?>" required=""></td>
                </tr>
                <tr>
                    <td>Role</td>
                    <td><input type="text" class="form-control" name="Role" placeholder="Enter Role" value="<?php echo !empty($userData['Role'])?$userData['Role']:''; ?>" required=""></td>
                </tr>
                <tr>
                    <td>Skills</td>
                    <td><input type="text" class="form-control" name="Skills" placeholder="Enter Skills" value="<?php echo !empty($userData['Skills'])?$userData['Skills']:''; ?>" required=""></td>
                </tr>
                <tr>
                    <td>Work Experience</td>    
                    <td><input type="text" class="form-control" name="Work_exp" placeholder="Enter Experience Level" value="<?php echo !empty($userData['Work_exp'])?$userData['Work_exp']:''; ?>" required=""></td>
                </tr>
                <tr>
                    <td>Status</td>    
                    <td><input type="text" class="form-control" name="Status" placeholder="Enter Status" value="<?php echo !empty($userData['Status'])?$userData['Status']:''; ?>" required=""></td>
                </tr>            
            </table>
                <a href="ProfileIndex.php" class="btn btn-secondary">Back</a>
                <input type="hidden" name="Profile_id" value="<?php echo !empty($ProfileData['Profile_id'])?$ProfileData['Profile_id']:''; ?>">
                <input type="hidden" name="Jobhunter_ID" value="<?php echo $Jobhunter_ID; ?>">
                <input type="submit" name="userSubmit" class="btn btn-success" value="Submit">
            </form>
        </div>
    </div>
</div>
</body>
</html>
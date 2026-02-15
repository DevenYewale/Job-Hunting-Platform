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
$Company_ID = '';
$EmployerData = $userData = array();
if(!empty($_GET['Company_ID'])){
    $Company_ID = $_GET['Company_ID'];
    require_once 'EmployerDB.class.php';
    $EmployerDB = new EmployerDB();
	
	// Fetch data from database by row ID
    $cond = array(
        'where' => array(
            'Company_ID' => $Company_ID
        ),
        'return_type' => 'single'
    );
    $EmployerData = $EmployerDB->getRows($cond);
}
$userData = !empty($sessData['userData'])?$sessData['userData']:$EmployerData;
unset($_SESSION['sessData']['userData']);

$actionLabel = !empty($Company_ID)?'Edit':'Add';

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $actionLabel; ?> Company Profile</title>
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
	<h1><?php echo $actionLabel; ?> Company Profile</h1>
    
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
             <form method="post" action="EmployerUserAction.php">

             <table class="table table-striped table-bordered">
                <tbody>
                <tr>
                    <td width="25%">Company Name</td>
                    <td width="75%"><input type="text" class="form-control" name="CompanyName" placeholder="Enter Company Name" value="<?php echo !empty($userData['CompanyName'])?$userData['CompanyName']:''; ?>" required=""></td>
                </tr>
                <tr>
                    <td>Company Category</td>
                    <td><input type="text" class="form-control" name="Company_Category" placeholder="Enter Company Category" value="<?php echo !empty($userData['Company_Category'])?$userData['Company_Category']:''; ?>" required=""></td>
                </tr>
                <tr>
                    <td>City</td>
                    <td><input type="text" class="form-control" name="City" placeholder="Enter City where company located" value="<?php echo !empty($userData['City'])?$userData['City']:''; ?>" required=""></td>
                </tr>
                <tr>
                    <td>State</td>
                    <td><input type="text" class="form-control" name="State" placeholder="Enter State where company located" value="<?php echo !empty($userData['State'])?$userData['State']:''; ?>" required=""></td>
                </tr>
                <tr>
                    <td>Contact Person</td>
                    <td><input type="text" class="form-control" name="Contact_Person" placeholder="Enter Contact Person Name" value="<?php echo !empty($userData['Contact_Person'])?$userData['Contact_Person']:''; ?>" required=""></td>
                </tr>
                <tr>
                    <td>Position</td>
                    <td><input type="text" class="form-control" name="Position" placeholder="Enter Position of Contact Person" value="<?php echo !empty($userData['Position'])?$userData['Position']:''; ?>" required=""></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="text" class="form-control" name="Email" placeholder="Enter Email of Contact Person" value="<?php echo !empty($userData['Email'])?$userData['Email']:''; ?>" required=""></td>
                </tr>
                <?php 
                if ($actionLabel == 'Add')
                    {
                        echo $actionLabel;
                        echo "<tr>";
                        echo "    <td>Password</td>";
                        echo "    <td><input type='text' class='form-control' name='Password' placeholder='Enter Password of Contact Person' value='' required=''></td>";
                        echo "</tr>";
                    }
                ?>
                <tr>
                    <td>Phone NO</td>
                    <td><input type="text" class="form-control" name="Phone_NO" placeholder="Enter Phone NO of Contact Person" value="<?php echo !empty($userData['Phone_NO'])?$userData['Phone_NO']:''; ?>" required=""></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td><input type="text" class="form-control" name="Status" placeholder="Enter Status" value="<?php echo !empty($userData['Status'])?$userData['Status']:''; ?>" required=""></td>
                </tr>
            </table>
                <a href="about:blank" class="btn btn-secondary">Back</a>
                <input type="hidden" name="Mode" value="<?php echo $actionLabel; ?>">
                <input type="hidden" name="Company_ID" value="<?php echo $Company_ID; ?>">
                <input type="submit" name="userSubmit" class="btn btn-success" value="Submit">
            </form>
        </div>
    </div>
</div>
</body>
</html>
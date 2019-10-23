<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Edit Existing Status  //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php");
$title = "Edit Status | ". $syatem_title;
include("../templates/admin-header.php");

 if(!($session->isLoggedIn())){
		redirectTo($url."index.php");
	}
if($_SESSION['accountStatus'] == 2){
	redirectTo($url."client/index.php");
}
if($_SESSION['accountStatus'] == 3){
	redirectTo($url."staff/index.php");
} 
$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;
$email=$user->email;
$settings = settings::findById((int)$id);
$account_stat=$user->status;
	$pro_id =  $_POST['idstatus'];
if($pro_id == ""){
	header("Location:status.php");
}
$_SESSION['pro_id'] = $pro_id;
$pro_id_u = $_SESSION['pro_id'];
	if(isset($_POST['update-status'])){

$flag=0;//determines if all posted values are not empty includ
		
		if($flag==0)
		{
			$cont_desc = mysqli_real_escape_string($connect, $_POST['description']);
			$statusTite = mysqli_real_escape_string($connect, $_POST['statusTite']);
				 $pp_id	= $pro_id;
				$pp_title	= $statusTite;
                $p_status		=$_POST['status'];
                $pp_desc		= $cont_desc;

				  
$sql_up = "UPDATE `project_status` SET
`name`='$pp_title',
`description`='$pp_desc',
`status`='$p_status',
`modified_by`='$username',
`c_id`='$id'
WHERE `idstatus`='$pp_id'";
if ($connect->query($sql_up) === TRUE){
	

 $status_title = $_POST['statusTite'];
					  	if(isset($_POST['notifyClient'])){
							$user = user::findById($_POST['client']); 
							// send verification email
							$to  = $user->email;
				  			$subject = 'Status Updated';
$variablesArr = array('{USER_NAME}' => $user->firstName, '{SIGNATURE}' => $company_name, '{DASHBOARD_URL}' => $url, '{PROJECT_NAME}' => $status_title);
$templateHTML = $settings->project_update_email;
$message = strtr($templateHTML, $variablesArr);
						  // To send HTML mail, the Content-type header must be set (don't change this section)
						  $headers  = 'MIME-Version: 1.0' . "\r\n";
						  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						  
						  $headers .= 'From: '.$company_name.' <'.$system_email.'>' . "\r\n";
						  $emailSent=mail($to,$subject, $message, $headers);
						  if($emailSent){ 
					  			$message="<p class='alert alert-success'><i class='fa fa-check'></i>Status has been created successfully!</p>";
						  }
						  else{
							  echo "Status has been created successfully! but Error sending the Email please contact site administrator";
						 }
/* Staff Email */
 $all_users=user::findBySql("select * from users");
 foreach($all_users as $recentlyRegisteredUser){ 
				if($recentlyRegisteredUser->accountStatus ==3){  
					$s_all = $_POST['staff'];
					if(in_array($recentlyRegisteredUser->id, $s_all)){
		$user = user::findById($recentlyRegisteredUser->id); 
		// send verification email
		$to  = $user->email; 
		$subject = 'Status Updated';
		$variablesArr = array('{USER_NAME}' => $user->firstName, '{SIGNATURE}' => $company_name, '{DASHBOARD_URL}' => $url, '{PROJECT_NAME}' => $pp_title);
						$templateHTML = $settings->project_update_email;
						$message = strtr($templateHTML, $variablesArr);
						  // To send HTML mail, the Content-type header must be set (don't change this section)
						  $headers  = 'MIME-Version: 1.0' . "\r\n";
						  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						  
						  $headers .= 'From: '.$company_name.' <'.$system_email.'>' . "\r\n";
						  $emailSent=mail($to,$subject, $message, $headers);
						  
						  if($emailSent){ 
						  
						  }else{
							header("Location:status.php?message=error_email");
						 }
				}
				}
 }
/* Staff Email End */
	}
header("Location:status.php?message=success");
				} else {
header("Location:status.php?message=fail");
				}
$connect->close();
		}
}
if(isset($_GET['message'])){
$msgstatus = $_GET['message'];
$notmessagea = $lang['Record updated successfully'];
$notmessageb = $lang['Error! Please Try Again later.'];
if($msgstatus == 'success'){
					$message="<p class='alert alert-success'><i class='fa fa-check'></i> ".$notmessagea."</p>";
}
if($msgstatus == 'fail'){		 
					$message="<p class='alert alert-success'><i class='fa fa-check'></i> ".$notmessageb."</p>"; 
}
}
?>
	
    
<div class="page-container">
<div class="container-fluid">
<div class="row row-eq-height">
	<?php  include("../templates/sidebar.php"); ?>
	
    <div class="page-content col-lg-9 col-md-12 col-sm-12 col-lg-push-3">
<?php include('../templates/top-header.php'); ?>
         <div class="row">
            <div class="col-md-12 margin-top-10 clients">
          <div class="add-project">
<?php 
$qur_pro = status::findBySql("select * from project_status where idstatus = '$pro_id'");

foreach($qur_pro as $qur_ar){
	// print_r($qur_ar);
 $client_id = $qur_ar->c_id;
 $name = $qur_ar->name;
 $description = $qur_ar->description;
 $status = $qur_ar->status;
 
 $recentlyRegisteredUsers=user::findBySql("select * from users");
?>
          	<form method="post" action="#" enctype="multipart/form-data">
<div class="row">
            <div class="col-md-12 margin-top-10 clients">
                <?php if(isset($message) && (!empty($message))){echo $message;} ?>
			</div>
    <div class="col-md-3">
        	<div class="project-header">
            	<h2><?php echo $lang['Edit Status']; ?> </h2>
			</div>
			<div class="project-himg">
			<img src="<?php echo $url?>images/create-a-project.png" class="img-fluid"/> 
			</div>
    </div>
<div class="col-md-8">
			<div class="form-group">
			 <div class="field-label"><label for="firstName"><?php echo $lang['Status title']; ?></label></div>
				<input type="text" name="statusTite" class="form-control" value="<?php echo $name; ?>" required>
			</div>
			<div class="form-group">
			<div class="field-label"><label for="firstName"><?php echo $lang['Write a status description here']; ?></label></div>
				<textarea class="form-control" name="description"><?php echo $description;?></textarea>
			</div>
<div class="row">

<div class="col-md-6">
<div class="form-group">
	<input type="hidden" name="status"  value="<?php echo $status;?>" >
	<input type="hidden" name="archive" value="<?php echo $archive;?>">
</div>

</div>

<div class="col-md-12 input-notify">
<div class="form-group">
<div class="inline field">
    <div class="ui toggle checkbox custom-btnc">
	<input type="checkbox" name="notifyClient" tabindex="0" class="hidden"/>
      <label><?php echo $lang['Email Notification']; ?><br><span><?php echo $lang['Notify to client and staff status has been Updated']; ?></span></label>
    </div>
<input type="hidden" value="<?php echo $pro_id_u;?>" name="idstatus"/>
<input type="submit" name="update-status" value="<?php echo $lang['Update Status']; ?>"  class="btn new-btnblue"/>
</div>
</div>
</div>			
</div> 
</div>

</div>
              <div class="clearfix"></div> 
            </form>
<?php } ?>
          </div><!--add-project -->
                
            </div>
        </div><!-- row -->
    </div>
	<div class="clearfix"></div>
		
</div>        
</div>        
</div>        
<?php  include("../templates/admin-footer.php"); ?>
<script>
$('.custom-btnc').checkbox();
</script>
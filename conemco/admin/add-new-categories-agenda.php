<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Add New Projects  //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php");
$title = "Add New type | ". $syatem_title;
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
//condition check for login
$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;
$email=$user->email;
$account_stat=$user->status;
$settings = settings::findById((int)$id);
$message = "";
	if(isset($_POST['add-type']))
	{
		
		$flag=0;//determines if all posted values are not empty includ
		
		if($flag==0)
		{
			$type = new Type_Diary();
                $type->idtype		= (int)NULL;
                $type->name	=$_POST['typeTite'];

				$type->description		=$_POST['description'];
				$type->status		=$_POST['status'];
                $type->created_by		=$username;
                $type->modified_by		=$username;

                $type->trash		= 0 ;
                $type->c_id		=$id;

				  $saveType=$type->save();
$notmessagea = $lang['type has been created successfully!'];
$notmessageb = $lang['type could not created at this time. Please Try Again Later . Thanks'];
				  if($saveType)
				  {
					  $name = $_POST['TypeTite'];
					  	if(isset($_POST['notifyClient'])){
							$user = user::findById($_POST['client']); 
							// send verification email
							$to  = $user->email;
				  			$subject = 'New type Created';
$variablesArr = array('{USER_NAME}' => $user->firstName, '{SIGNATURE}' => $company_name, '{DASHBOARD_URL}' => $url, '{PROJECT_NAME}' => $project_title);
$templateHTML = $settings->project_assign_email;
$message = strtr($templateHTML, $variablesArr);
						  // To send HTML mail, the Content-type header must be set (don't change this section)
						  $headers  = 'MIME-Version: 1.0' . "\r\n";
						  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						  
						  $headers .= 'From: '.$company_name.' <'.$system_email.'>' . "\r\n";
						  $emailSent=mail($to,$subject, $message, $headers);
						  if($emailSent){ 
					  			$message="<p class='alert alert-success'><i class='fa fa-check'></i> type has been created successfully!</p>";
						  }
						  else{
							  echo "type has been created successfully! but Error sending the Email please contact site administrator";
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
		$subject = 'Project assignment notification';
		$variablesArr = array('{USER_NAME}' => $user->firstName, '{SIGNATURE}' => $company_name, '{DASHBOARD_URL}' => $url, '{PROJECT_NAME}' =>  $project_title);
						$templateHTML = $settings->assign_staff_email;
						$message = strtr($templateHTML, $variablesArr);
						  // To send HTML mail, the Content-type header must be set (don't change this section)
						  $headers  = 'MIME-Version: 1.0' . "\r\n";
						  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						  
						  $headers .= 'From: '.$company_name.' <'.$system_email.'>' . "\r\n";
						  $emailSent=mail($to,$subject, $message, $headers);
						  
						  if($emailSent){ 
						  
						  }else{
							header("Location:categories_agenda.php?message=error_email");
						 }
				}
				}
 }
/* Staff Email End */
						} else{
							$message="<p class='alert alert-success'><i class='fa fa-check'></i> ".$notmessagea."</p>";
						}
header("Location:categories_agenda.php?message=created");
				  }
				  else
				  {
					  $message="<p class='alert alert-danger'><i class='fa fa-times'></i> ".$notmessageb."</p>";
				  
				  }
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
		
                <?php if(isset($message) && (!empty($message))){echo $message;} ?>
          <div class="add-project">
          	<form method="post" action="#" enctype="multipart/form-data">
<div class="row">
    <div class="col-md-3">
        	<div class="project-header">
            	<h2><?php echo $lang['Create New type']; ?> </h2>
				<p><?php echo $lang['create a new type for your client here.']; ?></p>
			</div>
			<div class="project-himg">
			<img src="<?php echo $url?>images/create-a-project.png" class="img-fluid"/> 
			</div>
    </div>
<div class="col-md-8">
<div class="form-group">
	<input type="text" name="typeTite" id="nombre" class="form-control" placeholder="<?php echo $lang['title diary']; ?>" required>
</div>
<div class="form-group">
	<textarea class="form-control" placeholder="<?php echo $lang['Description']; ?>" name="description"></textarea>
</div>
<div class="row">
<div class="col-md-6">
<div class="form-group">
	<input type="hidden" name="status" value="0" >
	<input type="hidden" name="archive" value="0" >
</div>

</div>
<div class="col-md-6">


<div class="form-group">
</div>
</div>
<div class="col-md-12">


<div class="col-md-12 input-notify">
<div class="form-group">
<div class="inline field">
    <div class="ui toggle checkbox custom-btnc">
	<input type="checkbox" name="notifyClient" tabindex="0" class="hidden"/>
      <label><?php echo $lang['Email Notification']; ?><br><span><?php echo $lang['Notify to client and staff type has been created']; ?></span></label>
    </div>
	<input type="submit" name="add-type" value="<?php echo $lang['Add New type']; ?>" class="btn new-btnblue"/>
</div>
</div>
</div>
</div>
</div>

</div>
            </form>
          </div><!--add-project -->
                
            </div>
        </div><!-- row -->
    </div>
	<div class="clearfix"></div>
		
</div>        
</div>        
</div>        
<script src="../assets/js/jquery.js" type="text/javascript"></script>

<script>
$(document).ready(function(){
$("#nombre").focus();
});
</script>
<?php  include("../templates/admin-footer.php"); ?>
<script>
$('.custom-btnc').checkbox();
</script>
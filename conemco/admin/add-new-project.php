<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Add New Projects  //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php");
$title = "Add New Project | ". $syatem_title;
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
	if(isset($_POST['add-project']))
	{
		
		$flag=0;//determines if all posted values are not empty includ
		
		if($flag==0)
		{
			$project = new Projects();
			$s_idsa = implode(',', $_POST['staff']);
				$project->project_title	=$_POST['projectTite'];
				$project->p_id		= (int)NULL;
				$project->c_id		=$_POST['client'];
				$project->s_ids		= $s_idsa;
				$project->project_desc		=$_POST['description'];
				$project->budget		=$_POST['budget'];
				$project->status		=$_POST['status'];
				$project->archive		=$_POST['archive'];
				$project->trash		= 0 ;
				$project->start_time		=$_POST['startTime'];
				$project->end_time		=$_POST['endTime'];
				$project->quoted_hour		=$_POST['quoted_hour'];
				$project->quoted_price		=$_POST['quoted_price'];
				$project->ocurrence_probability		=$_POST['ocurrence_probability'];
				$project->idstatus		=$_POST['idstatus'];
				$project->idtype		=$_POST['idtype'];
				$project->date_arrive		=$_POST['llegada'];
				$project->date_envio_propuesta		=$_POST['enviopropuesta'];
				$project->date_aprobacion_propuesta		=$_POST['fechaaprobacion'];
				$project->referido_por		=$_POST['referidopor'];
				$project->oficina		=$_POST['idoficina'];
				$project->project_manager		=$_POST['project_manager'];
				$project->contratista		=$_POST['contratista'];
				$project->porcentaje_avance		=$_POST['porcentaje_avance'];

				  $saveProject=$project->save();
$notmessagea = $lang['Project has been created successfully!'];
$notmessageb = $lang['Project could not created at this time. Please Try Again Later . Thanks'];
				  if($saveProject)
				  {
					  $project_title = $_POST['projectTite'];
					  	if(isset($_POST['notifyClient'])){
							$user = user::findById($_POST['client']); 
							// send verification email
							$to  = $user->email;
				  			$subject = 'New Project Created';
$variablesArr = array('{USER_NAME}' => $user->firstName, '{SIGNATURE}' => $company_name, '{DASHBOARD_URL}' => $url, '{PROJECT_NAME}' => $project_title);
$templateHTML = $settings->project_assign_email;
$message = strtr($templateHTML, $variablesArr);
						  // To send HTML mail, the Content-type header must be set (don't change this section)
						  $headers  = 'MIME-Version: 1.0' . "\r\n";
						  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						  
						  $headers .= 'From: '.$company_name.' <'.$system_email.'>' . "\r\n";
						  $emailSent=mail($to,$subject, $message, $headers);
						  if($emailSent){ 
					  			$message="<p class='alert alert-success'><i class='fa fa-check'></i> Project has been created successfully!</p>";
						  }
						  else{
							  echo "Project has been created successfully! but Error sending the Email please contact site administrator";
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
							header("Location:projects.php?message=error_email");
						 }
				}
				}
 }
/* Staff Email End */
						} else{
							$message="<p class='alert alert-success'><i class='fa fa-check'></i> ".$notmessagea."</p>";
						}
header("Location:projects.php?message=created");
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
            	<h2><?php echo $lang['Create New Project']; ?> </h2>
				<p><?php echo $lang['create a project and assigned the staff here.']; ?></p>
			</div>
			<div class="project-himg">
			<img src="<?php echo $url?>images/create-a-project.png" class="img-fluid"/> 
			</div>
    </div>
<div class="col-md-8">
<div class="form-group">
	<input type="text" name="projectTite" id="nombre" class="form-control" placeholder="<?php echo $lang['Project titles']; ?>" required>
</div>
<div class="form-group">
	<textarea class="form-control" placeholder="<?php echo $lang['Description']; ?>" name="description"></textarea>
</div>
<div class="row">
<div class="col-md-6">
<div class="form-group">
	<input type="number" name="budget" placeholder="<?php echo $lang['Budget']; ?> <?php echo $currency_symbol . $recentProject->budget;?>" class="form-control" required>
	<input type="hidden" name="status" value="0" >
	<input type="hidden" name="archive" value="0" >
</div>
<div class="form-group">
	<input type="text" placeholder="<?php echo $lang['Start Time']; ?>" name="startTime" class="form-control datepicker" required />
</div>
</div>
<div class="col-md-6">
<div class="form-group">
	<select required class="ui dropdown form-control" name="client">
		 <option value=""><?php echo $lang['Select a client']; ?></option>
		<?php $recentlyRegisteredUsers=user::findBySql("select * from users ORDER BY id DESC");
				foreach($recentlyRegisteredUsers as $recentlyRegisteredUser){ 
					if($recentlyRegisteredUser->accountStatus ==2){
						?>
						<option value="<?php echo $recentlyRegisteredUser->id; ?>"><?php echo $recentlyRegisteredUser->firstName; ?></option>
						<?php 
					}
				}?>
	</select>
</div>

<div class="form-group">
	<input type="text" placeholder="End Time" autocomplete="off" name="endTime" class="form-control datepicker" required />
</div>
</div>
<div class="col-md-6">
<div class="form-group">
	<select required class="ui dropdown form-control" name="idstatus">
		 <option value=""><?php echo $lang['Select a status']; ?></option>
		<?php $recentlyRegisteredUsers=status::findBySql("select * from project_status where status=0 ORDER BY idstatus DESC");
				foreach($recentlyRegisteredUsers as $recentlyRegisteredUser){ 
					if($recentlyRegisteredUser->trash !=1){
						?>
						<option value="<?php echo $recentlyRegisteredUser->idstatus; ?>"><?php echo $recentlyRegisteredUser->name; ?></option>
						<?php 
					}
				}?>
	</select>
</div>
</div>			
<div class="col-md-6">
<div class="form-group">
	<select required class="ui dropdown form-control" name="idtype">
		 <option value=""><?php echo $lang['Select a type']; ?></option>
		<?php $recentlyRegisteredUsers=Type::findBySql("select * from project_types where status=0 ORDER BY idtype DESC");
				foreach($recentlyRegisteredUsers as $recentlyRegisteredUser){ 
					if($recentlyRegisteredUser->trash !=1){
						?>
						<option value="<?php echo $recentlyRegisteredUser->idtype; ?>"><?php echo $recentlyRegisteredUser->name; ?></option>
						<?php 
					}
				}?>
	</select>
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<input type="text" placeholder="<?php echo $lang["arrival date"] ?>" name="llegada" class="form-control datepicker" autocomplete="off" />

</div>
</div>
<div class="col-md-6">
<div class="form-group">
<input type="text" placeholder="<?php echo $lang["proposal submission"] ?>" name="enviopropuesta" class="form-control datepicker" autocomplete="off"/>

</div>
</div>
<div class="col-md-6">
<div class="form-group">
<input type="text" placeholder="<?php echo $lang["approval date"] ?>" name="fechaaprobacion" class="form-control datepicker" autocomplete="off" />

</div>
</div>
<div class="col-md-6">
<div class="form-group">
<input type="text" placeholder="<?php echo $lang["referred by"] ?>" name="referidopor" class="form-control"/>

</div>
</div>
<div class="col-md-6">
<div class="form-group">
	<select required class="ui dropdown form-control" name="idoficina">
		 <option value=""><?php echo $lang['Select a office']; ?></option>
		<?php $recentlyRegisteredUsers=Oficina::findBySql("select * from office where status=0 ORDER BY idoficina DESC");
				foreach($recentlyRegisteredUsers as $recentlyRegisteredUser){ 
					if($recentlyRegisteredUser->trash !=1){
						?>
						<option value="<?php echo $recentlyRegisteredUser->idoficina; ?>"><?php echo $recentlyRegisteredUser->name; ?></option>
						<?php 
					}
				}?>
	</select>
</div>
</div>	
<div class="col-md-6">
<div class="form-group">
	<select required class="ui dropdown form-control" name="project_manager">
	<option value=""><?php echo $lang['Select project manager']; ?></option>
                    	<?php $recentlyRegisteredUsers=user::findBySql("select * from users ORDER BY id DESC");
                 				foreach($recentlyRegisteredUsers as $recentlyRegisteredUser){ 
					 				if($recentlyRegisteredUser->accountStatus ==3){
										?>
                                        <option value="<?php echo $recentlyRegisteredUser->id; ?>"><?php echo $recentlyRegisteredUser->firstName; ?></option>
                                        <?php 
					 				}
								}?>
	</select>
</div>
</div>	
<div class="col-md-6">
<div class="form-group">
<input type="text" placeholder="<?php echo $lang["contractor"] ?>" name="contratista" class="form-control"/>

</div>
</div>	
<div class="col-md-6">
<div class="form-group">
<input type="number" placeholder="<?php echo $lang["percentage of completion"] ?>" name="porcentaje_avance" class="form-control"/>

</div>
</div>	
<div class="col-md-12">
 <div class="form-group">
 <div class="staff-heading">
 <h4><?php echo $lang['Assign staff']; ?></h4>
 <span><?php echo $lang['Choose any team member for this project']; ?></span>
 </div>
 <input type="hidden" name="staff[]" value="1" />
 <input type="hidden" name="staff[]" class="new_val" />
                    <select multiple required class="ui fluid dropdown" name="staff[]">
					<option value=""><?php echo $lang['Select Staff members']; ?></option>
                    	<?php $recentlyRegisteredUsers=user::findBySql("select * from users ORDER BY id DESC");
                 				foreach($recentlyRegisteredUsers as $recentlyRegisteredUser){ 
					 				if($recentlyRegisteredUser->accountStatus ==3){
										?>
                                        <option value="<?php echo $recentlyRegisteredUser->id; ?>"><?php echo $recentlyRegisteredUser->firstName; ?></option>
                                        <?php 
					 				}
								}?>
                    </select>
</div></div>
<div class="col-md-12">
 <div class="form-group">
 <div class="staff-heading">
 <h4><?php echo $lang['quote data']; ?></h4>
 <span><?php echo $lang['Choose any data qoute for this project']; ?></span>
 </div>
 <div class="row">
<div class="col-md-6">
<div class="form-group">
	<input type="number" name="quoted_hour" placeholder="<?php echo $lang['quote hour']; ?>" class="form-control">

</div>
<div class="form-group">
<input type="number" name="quoted_price" placeholder="<?php echo $lang['quote price']; ?>" class="form-control">
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<input type="number" name="ocurrence_probability" placeholder="<?php echo $lang['performance probabilities']; ?>" class="form-control">

</div>
</div>
</div>
</div>
</div></div>

<div class="col-md-12 input-notify">
<div class="form-group">
<div class="inline field">
    <div hidden class="ui toggle checkbox custom-btnc">
	<input type="checkbox" name="notifyClient" tabindex="0" class="hidden"/>
      <label><?php echo $lang['Email Notification']; ?><br><span><?php echo $lang['Notify to client and staff project has been created']; ?></span></label>
    </div>
	<input type="submit" name="add-project" value="<?php echo $lang['add new project']; ?>" class="btn new-btnblue"/>
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
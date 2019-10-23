<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Add New Projects  //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php");
$title = "Add New Status | ". $syatem_title;
include("../templates/admin-header.php");

 if(!($session->isLoggedIn())){
		redirectTo($url."index.php");
	}

//condition check for login
$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;
$email=$user->email;
$account_stat=$user->status;
$settings = settings::findById((int)$id);
$message = "";
	if(isset($_POST['add-timesheet']))
	{
		
		$flag=0;//determines if all posted values are not empty includ
		
		if($flag==0)
		{
			$timesheet = new Timesheet();
                $timesheet->idtimesheet		= (int)NULL;
                $timesheet->idactivity	=$_POST['idactivity'];

				$timesheet->worked_hours		=$_POST['worked_hours'];
				$timesheet->ended_date		=$_POST['ended_date'];
                $timesheet->user_note		=$_POST['user_note'];

                $timesheet->trash		= 0 ;
                $timesheet->idproject		=$_POST['idproject'];
                $timesheet->status		=$_POST['status'];
				if(isset($_POST['notifyClient'])){
					$timesheet->finish		=1;

				}else{
					$timesheet->finish		=0;

				}
				$timesheet->c_id		=$id;
				$timesheet->created_by		=$username;
				$timesheet->modified_by		=$id;

				  $saveTimesheet=$timesheet->save();
$notmessagea = $lang['timesheet has been created successfully!'];
$notmessageb = $lang['timesheet could not created at this time. Please Try Again Later . Thanks'];
				  if($saveTimesheet)
				  {
					  $name = $_POST['idtimesheet'];
				
header("Location:timesheet.php?message=created");
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
            	<h2><?php echo $lang['Create New Timesheet']; ?> </h2>
				<p><?php echo $lang['create a new timesheet for your project here.']; ?></p>
			</div>
			<div class="project-himg">
			<img src="<?php echo $url?>images/timesheet.png" class="img-fluid"/> 
			</div>
    </div>
<div class="col-md-8">

<div class="row">
<div class="col-md-6">
<div class="form-group">
<div class="field-label"><label for="name"><?php echo $lang["Proyect"]; ?></label></div>

<select required class="ui dropdown form-control" name="idproject" id="idproject">
		 <option value=""><?php echo $lang['Select a proyect']; ?></option>
         
		<?php $recentlyRegisteredUsers=projects::findBySql("select * from projects ORDER BY p_id DESC");
				foreach($recentlyRegisteredUsers as $recentlyRegisteredUser){ 
					if($recentlyRegisteredUser->trash !=1){
						?>
						<option value="<?php echo $recentlyRegisteredUser->p_id; ?>"><?php echo $recentlyRegisteredUser->project_title; ?></option>
						<?php 
					}
				}?>
	</select>	
  
</div>
<div class="form-group">
<div class="field-label"><label for="worked_hours"><?php echo $lang["Worked Hour"]; ?></label></div>

	<input type="text" placeholder="<?php echo $lang['Worked Hour']; ?>" name="worked_hours" class="form-control" required />
</div>
</div>
<div class="col-md-6">
<div class="form-group" id="refrescar">
<div class="field-label"><label for="idactivity"><?php echo $lang["task"]; ?></label></div>

	<select required class="ui dropdown form-control" name="idactivity" id="tareas">
		 <option value=""><?php echo $lang['Select a task']; ?></option>
	
	</select>

</div>

<div class="form-group">
<div class="field-label"><label for="ended_date"><?php echo $lang["end Time"]; ?></label></div>

	<input type="text" placeholder="Terminada en Fecha" autocomplete="off" name="ended_date" class="form-control datepicker" required />
</div>
</div>
			
</div>
<div class="form-group">
<div class="field-label"><label for="user_note"><?php echo $lang["Description"]; ?></label></div>

	<textarea class="form-control" placeholder="<?php echo $lang['Description']; ?>" name="user_note"></textarea>
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
      <label><?php echo $lang['Finish Task']; ?><br><span><?php echo $lang['use this option to mark as completed task']; ?></span></label>
    </div>
	<input type="submit" name="add-timesheet" value="<?php echo $lang['finish activity']; ?>" class="btn new-btnblue"/>
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
$(document).ready(function() {
	$("#idproject").change(function(){
	$("#refrescar .text").empty();
        var el_proyecto=$(this).val();
        $.post('tareas.php',{tarea:el_proyecto}).done(function(respuesta){
            $('#tareas').html(respuesta);
        });

    });

	});
</script>


<?php  include("../templates/admin-footer.php"); ?>
<script>
$('.custom-btnc').checkbox();
</script>
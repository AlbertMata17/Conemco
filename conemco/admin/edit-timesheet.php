<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Add New Projects  //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php");
$title = "Edit Status | ". $syatem_title;
include("../templates/admin-header.php");

 if(!($session->isLoggedIn())){
		redirectTo($url."index.php");
	}

$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;
$email=$user->email;
$settings = settings::findById((int)$id);
$account_stat=$user->status;
	$pro_id =  $_POST['idtimesheet'];
if($pro_id == ""){
	header("Location:timesheet.php");
}
$_SESSION['pro_id'] = $pro_id;
$pro_id_u = $_SESSION['pro_id'];
	if(isset($_POST['update-timesheet'])){
		
		$flag=0;//determines if all posted values are not empty includ
		
        if($flag==0)
		{
			// $project = new Projects();
			$cont_desc = mysqli_real_escape_string($connect, $_POST['user_note']);
				 $pp_id	= $pro_id;
				$idproject		=$_POST['idproject'];
				$pp_desc		= $cont_desc;
				$worked_hours		=$_POST['worked_hours'];
				$idactivity		=$_POST['idactivity'];
				$ended_date		=$_POST['ended_date'];
				$finish		=$_POST['finish'];
                if(isset($_POST['notifyClient'])){
					$finish		=1;

				}
				$modified_by		=$id;

$sql_up = "UPDATE `timesheet` SET
`user_note`='$pp_desc',
`idproject`='$idproject',
`worked_hours`='$worked_hours',
`idactivity`='$idactivity',
`ended_date`='$ended_date',
`finish`='$finish',
`modified_by`='$modified_by'

WHERE `idtimesheet`='$pp_id'";
if ($connect->query($sql_up) === TRUE){
	

 $idtimesheet = $_POST['idtimesheet'];
					  	
header("Location:timesheet.php?message=success");
				} else {
header("Location:timesheet.php?message=fail");
				}
$connect->close();
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
          <?php 
$qur_pro = Timesheet::findBySql("select * from timesheet where idtimesheet = '$pro_id'");

foreach($qur_pro as $qur_ar){
	// print_r($qur_ar);
 $idtimesheet = $qur_ar->idtimesheet;
 $idactivity = $qur_ar->idactivity;
 $worked_hours = $qur_ar->worked_hours;
 $ended_date = $qur_ar->ended_date;
 $user_note = $qur_ar->user_note;
 $trash = $qur_ar->trash;
 $idproject = $qur_ar->idproject;
 $finish = $qur_ar->finish;
 
 
 $recentlyRegisteredUsers=user::findBySql("select * from users");
 $recentlyRegisteredproject=projects::findBySql("select * from  projects ORDER BY p_id DESC");
 $recentlyRegisteredstype=milestone::findBySql("select * from milestones WHERE id='$idactivity' ORDER BY id DESC");

?>
          	<form method="post" action="#" enctype="multipart/form-data">
<div class="row">
    <div class="col-md-3">
        	<div class="project-header">
            	<h2><?php echo $lang['Edit Timesheet']; ?> </h2>
				<p><?php echo $lang['Edit timesheet for your project here.']; ?></p>
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
				foreach($recentlyRegisteredproject as $recentlyRegisteredproject){ 
					if($recentlyRegisteredproject->trash !=1){
						?>
						<option value="<?php echo $recentlyRegisteredproject->p_id; ?>" <?php if($recentlyRegisteredproject->p_id== $idproject){ ?> selected="selected" <?php } ?>><?php echo $recentlyRegisteredproject->project_title; ?></option>
						<?php 
					}
				}?>
	</select>	
  
</div>
<div class="form-group">
<div class="field-label"><label for="worked_hours"><?php echo $lang["Worked Hour"]; ?></label></div>

	<input type="text" value="<?php echo $worked_hours?>" placeholder="<?php echo $lang['Worked Hour']; ?>"  name="worked_hours" class="form-control" required />
</div>
</div>
<div class="col-md-6">
<div class="form-group" id="refrescar">
<div class="field-label"><label for="idactivity"><?php echo $lang["task"]; ?></label></div>

	<select required class="ui dropdown form-control" name="idactivity" id="tareas">
		 <option value=""><?php echo $lang['Select a task']; ?></option>
	     
         <?php $recentlyRegisteredUsers=projects::findBySql("select * from projects ORDER BY p_id DESC");
				foreach($recentlyRegisteredstype as $recentlyRegisteredstype){ 
					if($recentlyRegisteredstype->id==$idactivity){
						?>
						<option value="<?php echo $recentlyRegisteredstype->id; ?>" <?php if($recentlyRegisteredstype->id== $idactivity){ ?> selected="selected" <?php } ?>><?php echo $recentlyRegisteredstype->title; ?></option>
						<?php 
					}
				}?>
	</select>

</div>

<div class="form-group">
<div class="field-label"><label for="ended_date"><?php echo $lang["end Time"]; ?></label></div>

	<input type="text" placeholder="Terminada en Fecha" value="<?php echo $ended_date?>" name="ended_date" class="form-control datepicker" required />
</div>
</div>
			
</div>
<div class="form-group">
<div class="field-label"><label for="user_note"><?php echo $lang["Description"]; ?></label></div>

	<textarea class="form-control" placeholder="<?php echo $lang['Description']; ?>" name="user_note"><?php echo $user_note?></textarea>
</div>
<div class="row">
<div class="col-md-6">
<div class="form-group">
	<input type="hidden" name="finish" value="<?php echo $finish?>" >
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
<?php 
							  if($finish == 0){ ?>
    <div class="ui toggle checkbox custom-btnc">
	<input type="checkbox" name="notifyClient" tabindex="0" class="hidden"/>
      <label><?php echo $lang['Finish Task']; ?><br><span><?php echo $lang['use this option to mark as completed task']; ?></span></label>
    </div>
    <input type="hidden" value="<?php echo $pro_id_u;?>" name="idtimesheet"/>

	<input type="submit" name="update-timesheet" value="<?php echo $lang['finish activity']; ?>" class="btn new-btnblue"/>
    							  <?php } else { ?>
                                    <input type="hidden" value="<?php echo $pro_id_u;?>" name="idtimesheet"/>

                                    <input type="submit" name="update-timesheet" value="<?php echo $lang['Save Changes']; ?>" class="btn new-btnblue"/>
							  <?php }?>

</div>
</div>
</div>
</div>
</div>

</div>
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
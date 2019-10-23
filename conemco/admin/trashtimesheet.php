<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Projects Trash Page  //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php");
$title = "Trash | ". $syatem_title;
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
$username=$user->firstName;;
$email=$user->email;;
// $account_stat=$user->status;
$user->regDate;


if(isset($_POST['del_proj']))
{
	 $delProjId=$_POST['del_id'];
	
	  $deleteProj="delete from timesheet where idtimesheet=$delProjId limit 1";
	  $projDeleted=mysqli_query($connect, $deleteProj);
	  $deleteProjChat="delete from messages where Project_id=$delProjId";
	  $projChatDeleted=mysqli_query($connect, $deleteProjChat);
	  if($projDeleted){
		 header("Location:trashtimesheet.php?message=trash");
	   } else{
			   header("Location:trashtimesheet.php?message=fail");
	   }
 }
if(isset($_POST['comp_proj']))
{
	 $comp_id=$_POST['comp_id'];
	 $comp_val=$_POST['comp_val'];
	  $updateProj="UPDATE timesheet SET status=$comp_val WHERE idtimesheet=$comp_id";
	  $comp_proj=mysqli_query($connect, $updateProj);
if($comp_proj){
		  header("Location:timesheet.php?message=restore");
	  } else{
		  header("Location:timesheet.php?message=fail");
	  }
}
if(isset($_POST['arc_proj']))
{
	 $arc_id=$_POST['arc_id'];
	 $arc_val=$_POST['arc_val'];
	 $arc_del_val=$_POST['arc_del_val'];
	  $updateProj="UPDATE timesheet SET trash=$arc_del_val WHERE idtimesheet=$arc_id";
	  $arc_proj=mysqli_query($connect, $updateProj);
	  if($arc_proj){
		  header("Location:timesheet.php?message=restore");
	  }else{
		   header("Location:timesheet.php?message=fail");
	  }
}
if(isset($_GET['message'])){
$msgstatus = $_GET['message'];
$notmsga = $lang['Record updated successfully'];
$notmsgb = $lang['timesheet has been created successfully!']; 
$notmsgc = $lang['Error! Please Try Again later.'];
$notmsgd = $lang['timesheet has been deleted sucessfully'];
$notmsgg = $lang['timesheet status updated to re-open.'];
$notmsgf = $lang['timesheet marked as Completed.'];
$notmsgh = $lang['timesheet restored Successfully.'];
if($msgstatus == 'success'){
					$message="<p class='alert alert-success'><i class='fa fa-check'></i> ".$notmsga."</p>";
}
if($msgstatus == 'created'){
					$message="<div class='container extra-top'><p class='alert alert-success'><i class='fa fa-check'></i> ".$notmsgb."</p></div>";
}
if($msgstatus == 'fail'){		 
$message="<div class='container extra-top'><p class='col-md-12 alert alert-danger'><i class='fa fa-times'></i> ".$notmsgc."</p></div>";
}
if($msgstatus == 'psuccess'){		 
		 $message= "<div class='container extra-top'><p class='col-md-12 alert alert-success'><i class='fa fa-check'></i> ".$notmsgd."</p></div>";
}
if($msgstatus == 'archive'){		 
		 $message= "<div class='container extra-top'><p class='col-md-12 alert alert-success'><i class='fa fa-check'></i> ".$notmsge."</p></div>";
}
if($msgstatus == 'completed'){		 
		 $message= "<div class='container extra-top'><p class='col-md-12 alert alert-success'><i class='fa fa-check'></i> ".$notmsgf."</p></div>";
}
if($msgstatus == 'reopen'){		 
		 $message= "<div class='container extra-top'><p class='col-md-12 alert alert-success'><i class='fa fa-check'></i> ".$notmsgg."</p></div>";
}
if($msgstatus == 'restore'){		 
		 $message= "<div class='container extra-top'><p class='col-md-12 alert alert-success'><i class='fa fa-check'></i> ".$notmsgh."</p></div>";
}
if($msgstatus == 'error_email'){		 
		 $message= "<div class='container extra-top'><p class='col-md-12 alert alert-danger'><i class='fa fa-times'></i> ".$notmsgi."</p></div>";
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
			<div class="row project-dash">
            	<div class="col-lg-5 col-md-5 col-sm-5 project-opt mobileleft">
				<div class="pm-heading"><h2><?php echo $lang['Trash']; ?> </h2><span><?php echo $lang['All timesheet deleted']; ?></span></div>
				<div class="pm-form"><form class="form-inline md-form form-sm">
    <input class="form-control form-control" type="text" placeholder="<?php echo $lang['Search timesheet']; ?>" id="protbl-input">
    <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
</form></div>
<?php $recentProjects=Timesheet::findBySql("select * from timesheet WHERE trash=1");?>
				</div> 
                <div class="col-lg-7 col-md-7 col-sm-7 project-opt creative-right text-right">
				<div class="mobilepromenu">
				<div class="projbtnm"><a href="add-new-timesheet.php"><span>+</span></a></div>
				<div class="projmobilem">
				<i class="fa fa-bars" aria-hidden="true"></i>
					<ul>
					<li class="pm-trashbox"><a href="trashtimesheet.php">
					<?php echo $lang['Trash']; ?> (<?php echo count($recentProjects); ?>)
					</a></li>
					<li class="pm-trash">
					<form method="post" action="#">
					<input type="hidden" class="bulk_ids" value="" name="bulk_del_id"/>
					<input type="hidden" value="1" name="bulk_del_val"/>
					<button type="submit" name="bulk_del_proj" disabled><?php echo $lang['Delete']; ?></button>
					</form>
					</li>
					</ul>
					</div>
				</div>
				<ul class="deskvisible">
				<li class="cproject"><a href="add-new-timesheet.php"><?php echo $lang['Create Timesheet']; ?> <span>+</span></a></li>
				<li class="pm-arc"><a href="timesheet.php"><?php echo $lang['timesheet']; ?></a></li>
				<li class="pm-trashbox"><a href="trashtimesheet.php">
				<?php echo $lang['TRASH']; ?> (<?php echo count($recentProjects); ?>)
				</a></li>
				</ul>
			</div>
			</div> 
			<div class="clearfix"></div>
			<div class="row">
            <div class="col-md-12 margin-top-10 clients">
                <?php if(isset($message) && (!empty($message))){echo $message;} ?>
			</div>
                <?php 
$limit = 10;  
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;
$start_from_b = ($page-1) * $limit;	

$recentProjects_page=Timesheet::findBySql("select * from timesheet WHERE trash = 1"); 
$recentProjects=Timesheet::findBySql("select * from timesheet WHERE trash = 1 ORDER BY date_created DESC LIMIT $start_from, $limit"); 


				
				?>
                <div class="table-responsive">          
                <table class="table table-new projectspage" data-pagination="true" data-page-size="5">
                        <thead>
                          <tr>
                            <th><input name="btSelectAll" type="checkbox"></th>
							<th><?php echo $lang['idproject']; ?></th>

                            <th><?php echo $lang['activity']; ?></th>
                            <th><?php echo $lang['worked_hours']; ?></th> 
                            <th><?php echo $lang['ended_date']; ?></th>
							<th><?php echo $lang['Estatus']; ?></th>

                            <th></th>
                          </tr>
                        </thead>
                        <tbody id="projects-tbl">
						  <?php 
						  $counter=1;
					if($recentProjects == NULL){
                        echo '<tr><td colspan="8">'.$lang['Trash is Empty!'].'</td></tr>';
                    }
                      foreach($recentProjects as $recentProject){ ?>
                      
                            <tr>
							<td class="bs-checkbox" style="width:36px !important; text-align:left !important;"><input data-index="<?php echo $counter; ?>" value="<?php echo $recentProject->idstatus ?>" name="btSelectItem" type="checkbox"></td>
						
							<td>
							  <?php 
							 echo '<div>';
							  $fkid = $recentProject->idproject;
$querya = $db->query("SELECT project_title FROM projects WHERE p_id = '$fkid'");
		 $rowa = mysqli_fetch_array($querya);
		 $imagea = $rowa['project_title'];
 if($imagea){
echo '<p class="onmobil">'.$imagea.'</p>
';
		 } else {
			echo '<span class="onmobil">'.'ninguno'.'</span>
			';
						 } 	
							//   echo '<div class="user-n">'. $user1->firstName . '</div>';
							  echo '</div>';
							  ?></td>
							<td class="tbl-ttl">
							  <span class="onmobile centera"><?php echo $lang['']; ?></span>
							  <?php 
							 echo '<div';
							  $user1 = milestone::findById($recentProject->idactivity); 
							  $fkid = $recentProject->idactivity;
$querya = $db->query("SELECT title FROM milestones WHERE id = '$fkid'");
		 $rowa = mysqli_fetch_array($querya);
		 $imagea = $rowa['title'];
 if($imagea){
echo '<span class="onmobil">'.$user1->title.'</span>
';
		 } else {
			echo '<span class="onmobil">'.'ninguno'.'</span>
			';
						 } 	
							//   echo '<div class="user-n">'. $user1->firstName . '</div>';
							  echo '</div>';
							  ?></td>
							  
                              <td><span class="onmobile"><?php echo $lang['Deadline']; ?>: </span> <?php echo $recentProject->worked_hours;?></td>
                          



													  
							                                <td><span class="onmobile"><?php echo $lang['Deadline']; ?>: </span> <?php echo $recentProject->ended_date;?></td>

															<td class="prostatus">
							  <span class="onmobile centera"><?php echo $lang['Status']; ?> </span>
							  <?php $finish = $recentProject->finish;
							  $trash = $recentProject->trash;
							  if($finish == 0){ ?>
							  <span class="inprogress"><?php echo $lang['IN PROGRESS']; ?></span>
							  <?php } else { ?>
								<span class="completed"><?php echo $lang['COMPLETED']; ?></span>
							  <?php }?>
							  </td>

                              
                              <td class="extra-height">
							  <span class="onmobile centera"><?php echo $lang['Options']; ?></span>
							  <div class="action-toggle" data-toggle="collapse" data-target="#time-menu<?php echo $recentProject->idtimesheet;?>"><?php echo $lang['Action']; ?> <i class="fa fa-caret-down"></i></div>
							  <div id="time-menu<?php echo $recentProject->idtimesheet;?>" class="toggle-action collapse">
							  <ul>
								<li>
								<form method="post" action="#">
								<input type="hidden" value="<?php echo $recentProject->idtimesheet;?>" name="arc_id"/>
								<input type="hidden" value="0" name="arc_val"/>
								<input type="hidden" value="0" name="arc_del_val"/>
								<button type="submit" name="arc_proj"><i class="fa fa-folder-open-o"></i> <?php echo $lang['RESTORE']; ?> </button>
								</form>
								</li>
								<li>
								<button type="button" data-toggle="modal" class="mod" data-target="#deletepro<?php echo $recentProject->idtimesheet;?>"><i class="fa fa-trash-o"></i> <?php echo $lang['Delete Permanently']; ?></button>
								</li>
							</ul>
								</div>

							
							<!-- The Modal -->
<div  class="modal hide fade deletepro"  tabindex="-1" aria-labelledby="basicModal" aria-hidden="true" id="deletepro<?php echo $recentProject->idtimesheet;?>" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"><?php echo $lang['Confirmation']; ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
<h3><?php echo $lang['Are your sure you want to <br> permanently delete this timesheet']; ?></h3>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
	  <div class="mod-footbox">
<button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><?php echo $lang['CANCEL']; ?></button>
</div>
<div class="mod-footbox">
<form method="post" action="#">
								<input type="hidden" value="<?php echo $recentProject->idtimesheet;?>" name="del_id"/>
								<button type="submit" class="btn btn-danger" name="del_proj"><?php echo $lang['DELETE']; ?></button>
								</form>
</div>
      </div>

    </div>
  </div>
</div>  
								</td>
                            </tr>
                          
                        <?php 
					 			$counter++;	
								} ?>
                    	</tbody>
                      </table>
<?php $total_records = count($recentProjects_page);  
$total_pages = ceil($total_records / $limit); ?>
<div class="row pagination-box">
<div class="col-md-6 resilts-txt"><?php echo $lang['Showing']; ?> <span class="start_val"><?php echo $start_from_b;?></span> <?php echo $lang['to']; ?> <span class="end_val"><?php echo $limit; ?></span> <?php echo $lang['of']; ?> <?php echo $total_records;?> <?php echo $lang['entries']; ?></div>
<div class="col-md-6">
<?php
echo '<nav aria-label="Page navigation"><ul class="pagination justify-content-end">';
echo '<li class="page-item">
      <a class="page-link" href="?page=1" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">'.$lang['Previous'].'</span>
      </a>
    </li>
';
for ($i=1; $i<=$total_pages; $i++) {

    $pagLink .= "<li class='page-item'><a class='page-link' href='?page=".$i."'>".$i."</a></li>";
};  
echo $pagLink . '
<li class="page-item">
      <a class="page-link" href="?page='.$total_pages.'" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">'.$lang['Next'].'</span>
      </a>
    </li>
</ul></nav>';  
?>
            </div>
            </div>
                	</div>
            </div>
        </div><!-- row -->
    </div>
	<div class="clearfix"></div>
		
</div>        
</div>        
</div>
</div>
<script src="../assets/js/jquery.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {
	$(".mod").click(function(){
		$('#deletepro<?php echo $recentProject->idtimesheet;?>').modal('toggle');
		$("#deletepro<?php echo $recentProject->idtimesheet;?>").removeClass("fade");


	});
	$(".close").click(function(){
		$('.modal').modal('hide');


	});
});
</script>
<?php  include("../templates/admin-footer.php"); ?>
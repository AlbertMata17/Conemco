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
	
	  $deleteProj="delete from categories_diary where idtype=$delProjId limit 1";
	  $projDeleted=mysqli_query($connect, $deleteProj);
	  $deleteProjChat="delete from messages where Project_id=$delProjId";
	  $projChatDeleted=mysqli_query($connect, $deleteProjChat);
	  if($projDeleted){
		 header("Location:trash_categories.php?message=trash");
	   } else{
			   header("Location:trash_categories.php?message=fail");
	   }
 }
if(isset($_POST['comp_proj']))
{
	 $comp_id=$_POST['comp_id'];
	 $comp_val=$_POST['comp_val'];
	  $updateProj="UPDATE categories_diary SET status=$comp_val WHERE idtype=$comp_id";
	  $comp_proj=mysqli_query($connect, $updateProj);
if($comp_proj){
		  header("Location:categories_agenda.php?message=restore");
	  } else{
		  header("Location:categories_agenda.php?message=fail");
	  }
}
if(isset($_POST['arc_proj']))
{
	 $arc_id=$_POST['arc_id'];
	 $arc_val=$_POST['arc_val'];
	 $arc_del_val=$_POST['arc_del_val'];
	  $updateProj="UPDATE categories_diary SET trash=$arc_del_val WHERE idtype=$arc_id";
	  $arc_proj=mysqli_query($connect, $updateProj);
	  if($arc_proj){
		  header("Location:categories_agenda.php?message=restore");
	  }else{
		   header("Location:categories_agenda.php?message=fail");
	  }
}
if(isset($_GET['message'])){
$msgstatus = $_GET['message'];
$notmsga = $lang['Record updated successfully'];
$notmsgb = $lang['type has been created successfully!']; 
$notmsgc = $lang['Error! Please Try Again later.'];
$notmsgd = $lang['type has been deleted sucessfully'];
$notmsgg = $lang['type status updated to re-open.'];
$notmsgh = $lang['type restored Successfully.'];
$notmsgi = $lang['type has been created successfully! but Error sending the Email please contact site administrator.'];
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
				<div class="pm-heading"><h2><?php echo $lang['Trash']; ?> </h2><span><?php echo $lang['All type deleted']; ?></span></div>
				<div class="pm-form"><form class="form-inline md-form form-sm">
    <input class="form-control form-control" type="text" placeholder="<?php echo $lang['Search type diary']; ?>" id="protbl-input">
    <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
</form></div>
<?php $recentProjects=Type_Diary::findBySql("select * from categories_diary WHERE trash=1");?>
				</div> 
                <div class="col-lg-7 col-md-7 col-sm-7 project-opt creative-right text-right">
				<div class="mobilepromenu">
				<div class="projbtnm"><a href="add-new-categories-agenda.php"><span>+</span></a></div>
				<div class="projmobilem">
				<i class="fa fa-bars" aria-hidden="true"></i>
					<ul>
					<li class="pm-trashbox"><a href="trashstatus.php">
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
				<li class="cproject"><a href="add-new-categories-agenda.php"><?php echo $lang['Create type']; ?> <span>+</span></a></li>
				<li class="pm-arc"><a href="categories_agenda.php"><?php echo $lang['Categories']; ?></a></li>
				<li class="pm-trashbox"><a href="trash_categories.php">
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

$recentProjects_page=Type_Diary::findBySql("select * from categories_diary WHERE trash = 1"); 
$recentProjects=Type_Diary::findBySql("select * from categories_diary WHERE trash = 1 ORDER BY date_created DESC LIMIT $start_from, $limit"); 
				
				?>
                <div class="table-responsive">          
                <table class="table table-new projectspage" data-pagination="true" data-page-size="5">
                        <thead>
                          <tr>
                            <th><input name="btSelectAll" type="checkbox"></th>
                            <th><?php echo $lang['id']; ?></th>
                            <th width="26%"><?php echo $lang['type Name']; ?></th> 
                            <th><?php echo $lang['Description type']; ?></th>
                            <th><?php echo $lang['Created By']; ?></th>
                           
                            <th></th>
                          </tr>
                        </thead>
                        <tbody id="projects-tbl">
						  <?php 
						  $counter=1;
					if($recentProjects == NULL){
						  echo '<tr><td colspan="9">'.$lang['There is no type Please Create type!'].'</td></tr>';
					  }
                      foreach($recentProjects as $recentProject){ ?>
                      
                            <tr>
							<td class="bs-checkbox" style="width:36px !important; text-align:left !important;"><input data-index="<?php echo $counter; ?>" value="<?php echo $recentProject->idtype ?>" name="btSelectItem" type="checkbox"></td>
                            <td class="tbl-ttl"><span class="onmobile"><?php echo $lang['Title']; ?>: </span> <?php echo $recentProject->idtype;?></td>

                              <td class="tbl-ttl"><span class="onmobile"><?php echo $lang['Title']; ?>: </span> <?php echo $recentProject->name;?></td>
                           
                             
                              <td><span class="onmobile"><?php echo $lang['Deadline']; ?>: </span> <?php echo $recentProject->description;?></td>
                              <td><span class="onmobile"><?php echo $lang['Deadline']; ?>: </span> <?php echo $recentProject->created_by;?></td>



                              
                              <td class="extra-height">
							  <span class="onmobile centera"><?php echo $lang['Options']; ?></span>
							  <div class="action-toggle" data-toggle="collapse" data-target="#client-menu<?php echo $recentProject->idtype;?>"><?php echo $lang['Action']; ?> <i class="fa fa-caret-down"></i></div>
							  <div id="client-menu<?php echo $recentProject->idtype;?>" class="toggle-action collapse">
							  <ul>
								<li>
								<form method="post" action="#">
								<input type="hidden" value="<?php echo $recentProject->idtype;?>" name="arc_id"/>
								<input type="hidden" value="0" name="arc_val"/>
								<input type="hidden" value="0" name="arc_del_val"/>
								<button type="submit" name="arc_proj"><i class="fa fa-folder-open-o"></i> <?php echo $lang['RESTORE']; ?> </button>
								</form>
								</li>
								<li>
								<button type="button" data-toggle="modal" class="mod" data-target="#deletepro<?php echo $recentProject->idtype;?>"><i class="fa fa-trash-o"></i> <?php echo $lang['Delete Permanently']; ?></button>
								</li>
							</ul>
								</div>

							
							<!-- The Modal -->
<div  class="modal hide fade deletepro"  tabindex="-1" aria-labelledby="basicModal" aria-hidden="true" id="deletepro<?php echo $recentProject->idtype;?>" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"><?php echo $lang['Confirmation']; ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
      <h3><?php echo $lang['Are your sure you want to <br> permanently delete this Record']; ?></h3>
<p><?php echo $lang['Deleting this record will also  delete all data.']; ?></p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
	  <div class="mod-footbox">
<button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><?php echo $lang['CANCEL']; ?></button>
</div>
<div class="mod-footbox">
<form method="post" action="#">
								<input type="hidden" value="<?php echo $recentProject->idtype;?>" name="del_id"/>
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
		$('#deletepro<?php echo $recentProject->idtype;?>').modal('toggle');
		$("#deletepro<?php echo $recentProject->idtype;?>").removeClass("fade");


	});
	$(".close").click(function(){
		$('.modal').modal('hide');


	});
});
</script>
<?php  include("../templates/admin-footer.php"); ?>
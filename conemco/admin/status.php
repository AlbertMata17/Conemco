<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// All Projects Page  //////////////////////////
*/
ob_start(); 
include("../includes/lib-initialize.php");
$title = "Projects | ". $syatem_title;
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
	 $delProjId= (int)$_POST['del_id'];
	 $delProjval=$_POST['del_val'];
	
	  $deleteProj="UPDATE project_status SET trash=$delProjval WHERE idstatus=$delProjId";
	  $projDeleted=mysqli_query($connect, $deleteProj);
	  if($projDeleted){
		 header("Location:status.php?message=psuccess");
	   } else{
			   header("Location:status.php?message=fail");
	   }
}
if(isset($_POST['bulk_del_proj']))
{

 	 $bulk_del_id=$_POST['bulk_del_id'];
	 $bulk_del_val=$_POST['bulk_del_val'];
 $bulk_arr = explode(',', $bulk_del_id);
	foreach($bulk_arr as $bulk_id){
$deleteProj="UPDATE project_status SET trash=$bulk_del_val WHERE idstatus=$bulk_id";
	  $proj_bulk_Deleted=mysqli_query($connect, $deleteProj);
	}
}
if(isset($_POST['comp_proj']))
{
	 $comp_id=$_POST['comp_id'];
	 $comp_val=$_POST['comp_val'];
	 if($comp_val == 1){
	  $updateProj="UPDATE project_status SET status=$comp_val WHERE idstatus=$comp_id";
	  $comp_proj=mysqli_query($connect, $updateProj);
	  if($comp_proj){
		  header("Location:status.php?message=completed");
	  } else{
		  header("Location:status.php?message=fail");
	  }
	 } else{
	  $updateProj="UPDATE project_status SET status=$comp_val WHERE idstatus=$comp_id";
	  $comp_proj=mysqli_query($connect, $updateProj);
	  if($comp_proj){
		  header("Location:status.php?message=reopen");
	  } else{
		  header("Location:status.php?message=fail");
	  }		 
	 }
}
if(isset($_POST['arc_proj']))
{
	 $arc_id=$_POST['arc_id'];
	 $arc_val=$_POST['arc_val'];
	  $updateProj="UPDATE project_status SET archive=$arc_val WHERE idstatus=$arc_id";
	  $arc_proj=mysqli_query($connect, $updateProj);
	  if($arc_proj){
		  header("Location:status.php?message=archive");
	  }else{
		   header("Location:status.php?message=fail");
	  }
}
if(isset($_GET['message'])){
$msgstatus = $_GET['message'];
$notmsga = $lang['Record updated successfully'];
$notmsgb = $lang['Status has been created successfully!']; 
$notmsgc = $lang['Error! Please Try Again later.'];
$notmsgd = $lang['Status has been deleted sucessfully'];
$notmsgh = $lang['Status restored Successfully.'];
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
				<div class="pm-heading"><h2><?php echo $lang['Manage Status']; ?> </h2><span><?php echo $lang['All Status leads']; ?></span></div>
				<div class="pm-form"><form class="form-inline md-form form-sm">
    <input class="form-control form-control" type="text" placeholder="<?php echo $lang['Search Status']; ?>" id="protbl-input">
    <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
</form></div>
<?php $recentProjects=status::findBySql("select * from project_status WHERE trash=1");?>
				</div> 
                <div class="col-lg-7 col-md-7 col-sm-7 project-opt creative-right text-right">
				<div class="mobilepromenu">
				<div class="projbtnm"><a href="add-new-status.php"><span>+</span></a></div>
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
<li class="cproject deskvisibleb"><a href="add-new-status.php"><?php echo $lang['Create Status']; ?> <span>+</span></a></li>
<li class="cproject tabvisible"><a href="add-new-status.php"><span>+</span></a></li>
<li class="pm-trashbox"><a href="trashstatus.php">
				<?php echo $lang['TRASH']; ?> (<?php echo count($recentProjects); ?>)
				</a></li>
				<li class="pm-trash">
								<form method="post" action="#">
								<input type="hidden" class="bulk_ids" value="" name="bulk_del_id"/>
								<input type="hidden" value="1" name="bulk_del_val"/>
								<button type="submit" name="bulk_del_proj" disabled><i class="fa fa-trash-o"></i></button>
								</form>
				</li>
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

$recentProjects_page=status::findBySql("select * from project_status WHERE trash != 1"); 
$recentProjects=status::findBySql("select * from project_status WHERE trash != 1 ORDER BY date_created DESC LIMIT $start_from, $limit"); 
				
				?>
                <div class="table-responsive">          
                <table class="table table-new projectspage" data-pagination="true" data-page-size="5">
                        <thead>
                          <tr>
                            <th><input name="btSelectAll" type="checkbox"></th>
                            <th><?php echo $lang['id']; ?></th>
                            <th width="26%"><?php echo $lang['Status Name']; ?></th> 
                            <th><?php echo $lang['Description Status']; ?></th>
                            <th><?php echo $lang['Created By']; ?></th>
                           
                            <th></th>
                          </tr>
                        </thead>
                        <tbody id="projects-tbl">
						  <?php 
						  $counter=1;
					if($recentProjects == NULL){
						  echo '<tr><td colspan="9">'.$lang['There is no Project Please Create Project!'].'</td></tr>';
					  }
                      foreach($recentProjects as $recentProject){ ?>
                      
                            <tr>
							<td class="bs-checkbox" style="width:36px !important; text-align:left !important;"><input data-index="<?php echo $counter; ?>" value="<?php echo $recentProject->idstatus ?>" name="btSelectItem" type="checkbox"></td>
                            <td class="tbl-ttl"><span class="onmobile"><?php echo $lang['Title']; ?>: </span> <?php echo $recentProject->idstatus;?></td>

                              <td class="tbl-ttl"><span class="onmobile"><?php echo $lang['Title']; ?>: </span> <?php echo $recentProject->name;?></td>
                           
                             
                              <td><span class="onmobile"><?php echo $lang['Deadline']; ?>: </span> <?php echo $recentProject->description;?></td>
                              <td><span class="onmobile"><?php echo $lang['Deadline']; ?>: </span> <?php echo $recentProject->created_by;?></td>



                              
                              <td class="extra-height">
							  <span class="onmobile centera"><?php echo $lang['Options']; ?></span>
							  <div class="action-toggle" data-toggle="collapse" data-target="#client-menu<?php echo $recentProject->idstatus;?>"><?php echo $lang['Action']; ?><i class="fa fa-caret-down"></i></div>
							  <div id="client-menu<?php echo $recentProject->idstatus;?>" class="toggle-action collapse">
							  <ul>
								
								<li>
								<form method="post" action="edit-status.php">
								<input type="hidden" value="<?php echo $recentProject->idstatus;?>" name="idstatus"/>
								<button type="submit" name="edt_pro"><i class="fa fa-pencil"></i> <?php echo $lang['Edit Status']; ?></button>
								</form>
								</li>
								<li>
								<form method="post" action="#">
								<input type="hidden" value="<?php echo $recentProject->idstatus;?>" name="del_id"/>
								<input type="hidden" value="<?php if($trash == 0){ echo '1';}else { echo '0';} ?>" name="del_val"/>
								<button type="submit" name="del_proj"><i class="fa fa-trash-o"></i> <?php echo $lang['Delete']; ?></button>
								</form>
								</li>
								
								
							</ul>
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
<?php  include("../templates/admin-footer.php"); ?>
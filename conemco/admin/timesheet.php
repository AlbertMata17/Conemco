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

//condition check for login

$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;
$email=$user->email;
$account=$user->accountStatus;

// $account_stat=$user->status;
$user->regDate;

if(isset($_POST['del_proj']))
{
	 $delProjId= (int)$_POST['del_id'];
	 $delProjval=$_POST['del_val'];
	
	  $deleteProj="UPDATE timesheet SET trash=$delProjval WHERE idtimesheet=$delProjId";
	  $projDeleted=mysqli_query($connect, $deleteProj);
	  if($projDeleted){
		 header("Location:timesheet.php?message=psuccess");
	   } else{
			   header("Location:timesheet.php?message=fail");
	   }
}
if(isset($_POST['bulk_del_proj']))
{

 	 $bulk_del_id=$_POST['bulk_del_id'];
	 $bulk_del_val=$_POST['bulk_del_val'];
 $bulk_arr = explode(',', $bulk_del_id);
	foreach($bulk_arr as $bulk_id){
$deleteProj="UPDATE timesheet SET trash=$bulk_del_val WHERE idtimesheet=$bulk_id";
	  $proj_bulk_Deleted=mysqli_query($connect, $deleteProj);
	}
}
if(isset($_POST['comp_proj']))
{
	 $comp_id=$_POST['comp_id'];
	 $comp_val=$_POST['comp_val'];
	 if($comp_val == 1){
	  $updateProj="UPDATE timesheet SET finish=$comp_val WHERE idtimesheet=$comp_id";
	  $comp_proj=mysqli_query($connect, $updateProj);
	  if($comp_proj){
		  header("Location:timesheet.php?message=completed");
	  } else{
		  header("Location:timesheet.php?message=fail");
	  }
	 } else{
	  $updateProj="UPDATE timesheet SET finish=$comp_val WHERE idtimesheet=$comp_id";
	  $comp_proj=mysqli_query($connect, $updateProj);
	  if($comp_proj){
		  header("Location:timesheet.php?message=reopen");
	  } else{
		  header("Location:timesheet.php?message=fail");
	  }		 
	 }
}
if(isset($_POST['arc_proj']))
{
	 $arc_id=$_POST['arc_id'];
	 $arc_val=$_POST['arc_val'];
	  $updateProj="UPDATE timesheet SET archive=$arc_val WHERE idtimesheet=$arc_id";
	  $arc_proj=mysqli_query($connect, $updateProj);
	  if($arc_proj){
		  header("Location:timesheet.php?message=archive");
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
				<div class="pm-heading"><h2><?php echo $lang['Manage timesheet']; ?> </h2><span><?php echo $lang['All timesheet leads']; ?></span></div>
				<div class="pm-form"><form class="form-inline md-form form-sm">
    <input class="form-control form-control" type="text" placeholder="<?php echo $lang['Search timesheet']; ?>" id="protbl-input" autocomplete="off">

    <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
	

</form>
<div class="custom-control custom-checkbox" id="check">
    <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
    <label class="custom-control-label" id="checkboxfecha" for="defaultUnchecked">Filtrar por Fecha</label>
</div>
</div>

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
<li class="cproject deskvisibleb"><a href="add-new-timesheet.php"><?php echo $lang['Create Timesheet']; ?> <span>+</span></a></li>
<li class="cproject tabvisible"><a href="add-new-timesheet.php"><span>+</span></a></li>
<li class="pm-trashbox"><a href="trashtimesheet.php">
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
if($account==1){
$recentProjects_page=Timesheet::findBySql("select * from timesheet WHERE trash != 1"); 
$recentProjects=Timesheet::findBySql("select * from timesheet WHERE trash != 1 ORDER BY date_created DESC LIMIT $start_from, $limit"); 

}else{
	$recentProjects_page=Timesheet::findBySql("select * from timesheet WHERE trash != 1 AND c_id=$id "); 
$recentProjects=Timesheet::findBySql("select * from timesheet WHERE trash != 1 AND c_id=$id ORDER BY date_created DESC LIMIT $start_from, $limit"); 

}
				
				?>
                <div class="table-responsive"> 
				<div class="pm-form">
				<div class="form-row ej" id="ocultarmostrar">
				<p id="filtrofecha1">Busqueda por fecha: </p>
				<form class="form-inline md-form form-sm">
<input type="button" placeholder="busqueda" value="Selecciona rango de fecha fecha" name="worked_hours" class="form-control  datepicker" id="Date_search" required />


</form></div>
</div>
                <table class="table table-new projectspage" id="tabla" data-pagination="true" data-page-size="5">
                        <thead>
                          <tr>
                            <th><input name="btSelectAll" type="checkbox"></th>
							<th><?php echo $lang['idproject']; ?></th>

                            <th><?php echo $lang['activity']; ?></th>
                            <th><?php echo $lang['worked_hours']; ?></th> 
                            <th><?php echo $lang['ended_date']; ?></th>
							<th><?php echo $lang['created by']; ?></th>

							<th><?php echo $lang['Estatus']; ?></th>

                            <th></th>
                          </tr>
                        </thead>
                        <tbody id="projects-tbl">
						  <?php 
						  $counter=1;
					if($recentProjects == NULL){
						  echo '<tr><td colspan="9">'.$lang['There is no timesheet Please Create timesheet!'].'</td></tr>';
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
															<td><span class="onmobile"><?php echo $lang['Deadline']; ?>: </span> <?php echo $recentProject->created_by;?></td>

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
							  <div class="action-toggle" data-toggle="collapse" data-target="#time-menu<?php echo $recentProject->idtimesheet;?>"><?php echo $lang['Action']; ?><i class="fa fa-caret-down"></i></div>
							  <div id="time-menu<?php echo $recentProject->idtimesheet;?>" class="toggle-action collapse">
							  <ul>
							  
								<?php if($account==1){?>
								<li>
								<form method="post" action="edit-timesheet.php">
								<input type="hidden" value="<?php echo $recentProject->idtimesheet;?>" name="idtimesheet"/>
								<button type="submit" name="edt_pro"><i class="fa fa-pencil"></i> <?php echo $lang['Edit timesheet']; ?></button>
								</form>
								</li>
								<?php }?>
								<li>
								<form method="post" action="#">
								<input type="hidden" value="<?php echo $recentProject->idtimesheet;?>" name="del_id"/>
								<input type="hidden" value="<?php if($trash == 0){ echo '1';}else { echo '0';} ?>" name="del_val"/>
								<button type="submit" name="del_proj"><i class="fa fa-trash-o"></i> <?php echo $lang['Delete']; ?></button>
								</form>
								</li>
								<li>
								<form method="post" action="#">
								<input type="hidden" value="<?php echo $recentProject->idtimesheet;?>" name="comp_id"/>
								<input type="hidden" value="<?php if($finish == 0){ echo '1';}else { echo '0';} ?>" name="comp_val"/>
								<button type="submit" name="comp_proj">
								<?php if($finish == 0){
								echo '<i class="fa fa-check-square-o"></i> '. $lang['Mark as complete'];
								}else { 
								echo '<i class="fa fa-retweet"></i>'. $lang['Re-open'];
								} ?>
								</button>
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
<script src="../assets/js/jquery.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css"/>
<script>
$(document).ready(function(){

	
});
</script>

 
 
<script>
minDateFilter = "";
maxDateFilter = "";
$.fn.dataTableExt.afnFiltering.push(
  function(oSettings, aData, iDataIndex) {
    if (typeof aData._date == 'undefined') {
      aData._date = new Date(aData[4]).getTime();
    }

    if (minDateFilter && !isNaN(minDateFilter)) {
      if (aData._date < minDateFilter) {
        return false;
      }
    }

    if (maxDateFilter && !isNaN(maxDateFilter)) {
      if (aData._date > maxDateFilter) {
        return false;
      }
    }

    return true;
  }
);
$(document).ready(function() {
	
  $("#Date_search").val("Seleccione Rango de fecha");
});
var table = $('#tabla').DataTable( {
	  deferRender:    true, 
	"bLengthChange": false,
	"bInfo": false,
	"bPaginate": false,
	"bSort": false,
  "autoWidth": false,     
  "search": {
    "regex": true,
    "caseInsensitive": false,
  },});

$("#Date_search").daterangepicker({
  "locale": {
    "format": "YYYY-MM-DD",
    "separator": " Hasta ",
    "applyLabel": "Confirmar",
    "cancelLabel": "Cancelar",
    "fromLabel": "Desde",
    "toLabel": "Hasta",
    "customRangeLabel": "Custom",
    "weekLabel": "W",
    "daysOfWeek": [
      "Su",
      "Mo",
      "Tu",
      "We",
      "Th",
      "Fr",
      "Sa"
    ],
    "monthNames": [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December"
    ],
    "firstDay": 1
  },
  "opens": "center",
}, function(start, end, label) {
  maxDateFilter = end;
  minDateFilter = start;
  table.draw();  
});

$( '#defaultUnchecked' ).on( 'click', function() {
    if( $(this).is(':checked') ){
        // Hacer algo si el checkbox ha sido seleccionado
		$("#ocultarmostrar").addClass("ej1");

		$("#ocultarmostrar").show("swing");


    } else {
		$("#ocultarmostrar").hide("swing");
		document.getElementById("Date_search").value=""; 
		location.reload();
		var value = $(this).val().toLowerCase();
		$("#Date_search").val("Seleccione Rango de fecha");

        // Hacer algo si el checkbox ha sido deseleccionado
    }
});
</script>


<?php  include("../templates/admin-footer.php"); ?>
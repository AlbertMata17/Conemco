<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// All Projects Page  //////////////////////////
*/
ob_start(); 
include("../includes/lib-initialize.php");
$title = "Projects | ". $syatem_title;
include("../templates/admin-header1.php");

 if(!($session->isLoggedIn())){
		redirectTo($url."index.php");
	}

	$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;
$email=$user->email;
$accountStatus=$user->accountStatus;

// $account_stat=$user->status;
$user->regDate;

	$sql = "SELECT id, title, start, end, color,c_id,created_by,modified_by FROM events";
	$events=mysqli_query($connect, $sql);
//condition check for login





?>
      
<div class="page-container">
<div class="container-fluid">
<div class="row row-eq-height">
	<?php  include("../templates/sidebar.php"); ?>
	
    <div class="page-content col-lg-9 col-md-12 col-sm-12 col-lg-push-3">
<?php include('../templates/top-header.php'); ?>
  <!-- Bootstrap Core CSS -->
  <link href="../css/bootstrap.min.css" rel="stylesheet">
	
	<!-- FullCalendar -->
	<link href='../css/fullcalendar.css' rel='stylesheet' />
	<link href='../css/fullcalendar.print.min.css' rel='stylesheet' media='print' />


    <!-- Custom CSS -->
    <style>
    body {
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
	#calendar {
		max-width: 999px;
		background:#FFF;
		padding-top:10px;
	}
	.col-centered{
		float: none;
		margin: 0 auto;
	}
	#deleted{
		-webkit-appearance:checkbox;
		
		opacity:1;

	}
	
    </style>

         <div class="row">
            <div class="col-md-12 margin-top-10 clients">
			<div class="row project-dash">
            	<div class="col-lg-5 col-md-5 col-sm-5 project-opt mobileleft">
				<div class="pm-heading"><h2><?php echo $lang['Manage calendar']; ?> </h2><span><?php echo $lang['All events leads']; ?></span></div>
				<div class="pm-form">
				<?php if($accountStatus=='1') { ?>
				<label for="title" class="col-sm-12 col-md-12 control-label"><?php echo $lang["filter by user or client"]?></label>

				<select class="form-control col-md-12 mb-4" id="selector">
    <option value="all">Todos</option>
	<?php $recentlyRegisteredUsers=user::findBySql("select * from users ORDER BY id DESC");
				foreach($recentlyRegisteredUsers as $recentlyRegisteredUser){ 
					if($recentlyRegisteredUser->status ==0){
						?>
						<option value="<?php echo $recentlyRegisteredUser->id; ?>"><?php echo $recentlyRegisteredUser->firstName; ?></option>
						<?php 
					}
				}?>
  </select>
			<?php } ?>    
			<?php if($accountStatus=='2' || $accountStatus=='3') { ?>
				<label for="title" hidden class="col-sm-12 col-md-12 control-label"><?php echo $lang["filter by user or client"]?></label>

				<select class="form-control col-md-12 mb-4" id="selector" hidden>
    <option value="all" selected>Todos</option>
	<?php $recentlyRegisteredUsers=user::findBySql("select * from users ORDER BY id DESC");
				foreach($recentlyRegisteredUsers as $recentlyRegisteredUser){ 
					if($recentlyRegisteredUser->status ==0){
						?>
						<option value="<?php echo $recentlyRegisteredUser->id; ?>" <?php if($recentlyRegisteredUser->id == $id){ ?> selected="selected" <?php } ?>><?php echo $recentlyRegisteredUser->firstName; ?></option>
						<?php 
					}
				}?>
  </select>
			<?php } ?>   
</div>
<?php $recentProjects=status::findBySql("select * from customers WHERE trash=1");?>
				</div> 
                <div class="col-lg-7 col-md-7 col-sm-7 project-opt creative-right text-right">
				<div class="mobilepromenu">
				<div class="projbtnm"><a href="#"><span>Calendario</span></a></div>
				<div class="projmobilem">
				<i class="fa fa-bars" aria-hidden="true"></i>
					
					</div>
				</div>
				<ul class="deskvisible">
<li class="cproject deskvisibleb"><a href="#"><?php echo $lang['calendar']; ?> <span></span></a></li>
<li class="cproject tabvisible"><a href="#"><span>+</span></a></li>

			
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

$recentProjects_page=customer::findBySql("select * from customers WHERE trash != 1"); 
$recentProjects=customer::findBySql("select * from customers WHERE trash != 1 ORDER BY date_created DESC LIMIT $start_from, $limit"); 
				
				?>
<div class="container">

<div class="row">
	<div class="col-lg-12 text-center">
		<div id="calendar" class="col-centered">
		</div>
	</div>
	
</div>
<!-- /.row -->

<!-- Modal -->
<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	<form class="form-horizontal" method="POST" action="addEvent.php">
	
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel"><?php echo $lang["Add event"]?></h4>
	  </div>
	  <div class="modal-body">
		
		  <div class="form-group">
			<label for="title" class="col-sm-2 control-label"><?php echo $lang["Title"]?></label>
			<div class="col-sm-10">
			  <input type="text" name="title" class="form-control" id="title" placeholder="Actividad o evento">
			</div>
		  </div>
		  <div class="form-group">
			<label for="color" class="col-sm-2 control-label">Color</label>
			<div class="col-sm-10">
			  <select name="color" class="form-control" id="color">
				  <option value="">Choose</option>
				  <option style="color:#0071c5;" value="#0071c5">&#9724; <?php echo $lang["Dark blue"]?></option>
				  <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
				  <option style="color:#008000;" value="#008000">&#9724; Green</option>						  
				  <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
				  <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
				  <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
				  <option style="color:#000;" value="#000">&#9724; Black</option>
				  
				</select>
			</div>
		  </div>
		  <div class="form-group">
			<label for="start" class="col-sm-2 control-label"><?php echo $lang["start date"]?></label>
			<div class="col-sm-10">
			  <input type="datetime-local" name="start" class="form-control" id="start">
			</div>
		  </div>
		  <div class="form-group">
			<label for="end" class="col-sm-2 control-label"><?php echo $lang["end date"]?></label>
			<div class="col-sm-10">
			  <input type="datetime-local" name="end" class="form-control" id="end">
			</div>
		  </div>
		
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang["close"]?></button>
		<button type="submit" class="btn btn-primary"><?php echo $lang["Save changes"]?></button>
	  </div>
	</form>
	</div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	<form class="form-horizontal" method="POST" action="editEventTitle.php">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Editar Evento</h4>
	  </div>
	  <div class="modal-body">
		
		  <div class="form-group">
			<label for="title" class="col-sm-2 control-label">Title</label>
			<div class="col-sm-10">
			  <input type="text" name="title" class="form-control" id="title" placeholder="Title">
			</div>
		  </div>
		  <div class="form-group">
			<label for="color" class="col-sm-2 control-label">Color</label>
			<div class="col-sm-10">
			  <select name="color" class="form-control" id="color">
				  <option value="">Choose</option>
				  <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
				  <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
				  <option style="color:#008000;" value="#008000">&#9724; Green</option>						  
				  <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
				  <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
				  <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
				  <option style="color:#000;" value="#000">&#9724; Black</option>
				  
				</select>
			</div>
		  </div>
		  <!-- <div><p>hola</p><div> -->
		  <!-- <div><p>hola</p><div> -->

			<div class="form-group"> 
				<div class="col-sm-offset-2 col-sm-10">
				  <div class="checkbox">

					<label class="text-danger"><input type="checkbox"  id="deleted" name="delete"> Borrar Evento</label>
				  </div>
				</div>
			</div>
		  
		  <input type="hidden" name="id" class="form-control" id="id">
		
		
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang["close"]?></button>
		<button type="submit" class="btn btn-primary"><?php echo $lang["Save changes"]?></button>
	  </div>
	</form>
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
<div class="modal fade" id="visualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title text-center">Datos del Evento</h4>
					</div>
					<div class="modal-body">
						<dl class="dl-horizontal">

							<dt>Titulo de Evento</dt>
							<dd id="title"></dd>
							<dt>Inicio de Evento</dt>
							<dd id="start"></dd>
							<dt>Fin de Evento</dt>
							<dd id="end"></dd>
							<dt>Creado Por</dt>
							<dd id="created"></dd>

						</dl>
					</div>
				</div>
			</div>
		</div>
		
<script src="../js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>


<!-- FullCalendar -->
<script src='../js/moment.min.js'></script>
<script src='../js/fullcalendar.min.js'></script>
<script src='locales-all.js'></script>
<script src='../js/fullcalendar-rightclick.js'></script>

<script>

$(document).ready(function() {
	
	$('#calendar').fullCalendar({
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
    monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
    dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
    dayNamesShort: ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'],
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		defaultDate: Date(),
		editable: true,
		eventLimit: true, // allow "more" link when too many events
		navLinks: true,

		selectable: true,
		selectHelper: true,
		select: function(start, end) {
			
			$('#ModalAdd #start').val(moment(start).format('YYYY-MM-DDTHH:mm'));
				$('#ModalAdd #end').val(moment(end).format('YYYY-MM-DDTHH:mm'));
			$('#ModalAdd').modal('show');
		},
		eventRender: function(event, element,view) {
			element.bind('dblclick', function() {
				$('#ModalEdit #id').val(event.id);
				$('#ModalEdit #title').val(event.title);
				$('#ModalEdit #color').val(event.color);
				$('#ModalEdit').modal('show');
			});
			return ['all', event.c_id].indexOf($('#selector').val()) >= 0
		
		
		},
		eventDrop: function(event, delta, revertFunc) { // si changement de position

			edit(event);

		},
		eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

			edit(event);

		},
		eventRightclick: function(event,element,view) {
						
						$('#visualizar #title').text(event.title);
						$('#visualizar #start').text(event.start.format('YYYY-MM-DD HH:mm:ss a'));
						$('#visualizar #end').text(event.end.format('YYYY-MM-DD HH:mm:ss a'));
						$('#visualizar #created').text(event.created_by);

						$('#visualizar').modal('show');
						return false;

					},
				
					
		events: [
		<?php foreach($events as $event): 
		
			$start = explode(" ", $event['start']);
			$end = explode(" ", $event['end']);
			if($start[1] == '00:00:00'){
				$start = $start[0];
			}else{
				$start = $event['start'];
			}
			if($end[1] == '00:00:00'){
				$end = $end[0];
			}else{
				$end = $event['end'];
			}
		?>
			{
				id: '<?php echo $event['id']; ?>',
				title: '<?php echo $event['title']; ?>',
				start: '<?php echo $start; ?>',
				end: '<?php echo $end; ?>',
				color: '<?php echo $event['color']; ?>',
				c_id: '<?php echo $event['c_id']; ?>',
				created_by: '<?php echo $event['created_by']; ?>',

			},
		<?php endforeach; ?>
		]
	});
	
	function edit(event){
		start = event.start.format('YYYY-MM-DD HH:mm:ss');
		if(event.end){
			end = event.end.format('YYYY-MM-DD HH:mm:ss');
		}else{
			end = start;
		}
		
		id =  event.id;
		
		Event = [];
		Event[0] = id;
		Event[1] = start;
		Event[2] = end;
		
		$.ajax({
		 url: 'editEventDate.php',
		 type: "POST",
		 data: {Event:Event},
		 success: function(rep) {
				if(rep == 'OK'){
					alert('Saved');
				}else{
					alert('Could not be saved. try again.'); 
				}
			}
		});
	}
	$('#selector').on('change',function(){
    $('#calendar').fullCalendar('rerenderEvents');
})
});

</script>

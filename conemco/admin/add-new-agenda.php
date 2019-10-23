<?php 
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Add Clients page  //////////////////////////
*/
ob_start(); 
include("../includes/lib-initialize.php");
$title = "Add Client | ". $syatem_title;
include("../templates/admin-header.php");
 if(!($session->isLoggedIn())){
		redirectTo($url."index.php");
	}

$id=$session->userId; //id of the current logged in user 
$userb = User::findById((int)$id); //take the record of current user in an object array 	
$username=$userb->firstName;;
$email=$userb->email;;
$account_stat=$userb->status;;
$settings = settings::findById((int)$id);
$message = "";
$h="";
if(isset($_POST['add-company']))
	{
		$flag=0;
		if($flag==0)
		{
			$company = new Company();

			$company->idcompany		= (int)NULL;
			$company->name	=$_POST['name'];

			$company->contact		=$_POST['contact'];
			$company->address		=$_POST['address'];
			$company->phone		=$_POST['phone'];
			$company->description		=$_POST['description'];
		
			$company->status		=0;
			$company->created_by		=$username;
			$company->modified_by		=$username;
			$company->c_id		=$id;
		

			$company->trash		= 0 ;
			
			  $saveType=$company->save();
			  if($saveType){
			  $h="valor";
			  }
}
	}
	if(isset($_POST['add-type']))
	{
		$flag=0;
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
			  if($saveType){
			  $h="tipo";
			  }
}
	}
	if(isset($_POST['add-customer']))
	{
		$flag=0;
		if($flag==0)
		{
			$customer = new Customer();

			$customer->idcustomer		= (int)NULL;
			$customer->name	=$_POST['name'];

			$customer->description		=$_POST['description'];
			$customer->phone		=$_POST['phone'];
			$customer->email		=$_POST['email'];
			$customer->address		=$_POST['address'];
		
			$customer->status		=0;
			$customer->created_by		=$username;
			$customer->modified_by		=$username;
			$customer->idcompany		=$_POST['idcompany'];
			$customer->idtype		=$_POST['idtype'];
			$customer->reference		=$_POST['reference'];
		
			$customer->c_id		=$id;
			$customer->country		=$_POST['country'];
			$customer->city		=$_POST['city'];

			$customer->trash		= 0 ;

			  $saveType=$customer->save();

			  $notmessagea = $lang['contact has been created successfully!'];
			  $notmessageb = $lang['contact could not created at this time. Please Try Again Later . Thanks'];
								if($customer)
								{
									$project_title = $_POST['projectTite'];
									
			  header("Location:agenda.php?message=created");
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
         <h2 class="page-title"><?php echo $lang["Add Contact"]; ?></h2>
			 <?php if(isset($message) && (!empty($message))){echo $message;} ?>
          <div class="add-customer">
          	<form method="post" action="#" enctype="multipart/form-data">
			<div class="row">
              <div class="col-md-4 upload-profile-pic">
              		<div class="upload-pro-pic">
					<div class="img-uploadwrap">
                    	<img src="../assets/images/upload-img.jpg" class="img-fluid"/>
						</div>
                       
				
                    
                    </div>
              </div>
              <div class="col-md-8 user-info">
                <div class="row">
                	<div class="col-md-6">
                    	<div class="form-group row">
                            <div class="col-md-12">
             	<div class="field-label"><label for="name"><?php echo $lang["Full name*"]; ?></label></div>

                            	<input type="text" name="name" id="nombre" class="form-control" required>
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12 passfieldcont">
                                 <div class="field-label"><label for="description"><?php echo $lang["Description"]; ?></label></div>
                            	<input type="text" name="description" class="form-control passwordfield">
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                  <div class="field-label"><label for="phone"><?php echo $lang["Phone client"]; ?></label></div>
                            	<input type="text" id="telefono" name="phone" class="form-control">
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-10">
                                 <div class="field-label"><label for="skype_id"><?php echo $lang["Company"]; ?></label></div>
								 <select  class="form-control" id="compan" name="idcompany">
		 <option value=""><?php echo $lang['Select a company']; ?></option>
		<?php $recentlyRegisteredUsers=company::findBySql("select * from companies where status=0 ORDER BY idcompany DESC");
				foreach($recentlyRegisteredUsers as $recentlyRegisteredUser){ 
					if($recentlyRegisteredUser->trash !=1){
						?>
						<option value="<?php echo $recentlyRegisteredUser->idcompany; ?>"><?php echo $recentlyRegisteredUser->name; ?></option>
						<?php 
					}
				}?>
	</select>                            </div>
	<div class="col-md-1">
	<button type="button" id="crea" data-toggle="modal" class="mod" data-target="#crear"><i class="fa fa-plus"></i></button>

	</div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                 <div class="field-label"><label for="city"><?php echo $lang["City"]; ?></label></div>
                            	<input type="text" name="city" class="form-control">
                            </div>
                         </div>
                        
                    </div>
                    <div class="col-md-6">
                    	<div class="form-group row">
                            <div class="col-md-12">
                                <div class="field-label"><label for="email"><?php echo $lang["Email"]; ?></label></div>
                            	<input type="email" name="email" class="form-control">
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                 <div class="field-label"><label for="address"><?php echo $lang["Address"]; ?></label></div>
                            	<input type="text" name="address" class="form-control">
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                 <div class="field-label"><label for="reference"><?php echo $lang["reference"]; ?></label></div>
                            	<input type="text" name="reference" class="form-control">
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-10">
                                <div class="field-label"><label for="idtype"><?php echo $lang["Type contact"]; ?></label></div>
								<select class="form-control" name="idtype" id="tipocontacto">
		 <option value=""><?php echo $lang['Select a type contact']; ?></option>
		<?php $recentlyRegisteredUsers=Type_Diary::findBySql("select * from categories_diary where status=0 ORDER BY idtype DESC");
				foreach($recentlyRegisteredUsers as $recentlyRegisteredUser){ 
					if($recentlyRegisteredUser->trash !=1){
						?>
						<option value="<?php echo $recentlyRegisteredUser->idtype; ?>"><?php echo $recentlyRegisteredUser->name; ?></option>
						<?php 
					}
				}?>
	</select>                                      </div>
	<div class="col-md-1">
	<button type="button" id="crea1" data-toggle="modal" class="mod1" data-target="#crear1"><i class="fa fa-plus"></i></button>

	</div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                <div class="field-label"><label for="country"><?php echo $lang["Country"]; ?></label></div>
								<select name="country" class="form-control">
								<option value=""><?php echo $lang["Select Country"]; ?></option>
	<?php foreach($countries as $countrie){
		echo '<option value="'.$countrie.'">'.$countrie.'</option>';
	} ?>
								</select>
                            </div>
                         </div>
                        
						 
                    </div>
					<div class="col-md-12 submit-btnal">
					<div class="form-group row">
                         <input class="bigbutton" value="<?php echo $lang["Create Contact"]; ?>" type="submit" name="add-customer"/>
					</div>
					</div>
                    
                </div>
              </div>
            </div>
              <div class="clearfix"></div>
            </form> 
          </div><!--add-client -->
       
    </div>
	<div class="clearfix"></div>
		
</div>        
</div>        
</div>        
<div class="modal fade" id="crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <div class="add-company">
	  <iframe name="votar" style="display:none;"></iframe>

          	<form method="post" id="formulario" action="#" target="votar" enctype="multipart/form-data">
			<div class="row">
           
              <div class="col-md-12 user-infos">
                <div class="row">
                	<div class="col-md-6">
                    	<div class="form-group row">
                            <div class="col-md-12">
             	<div class="field-label"><label for="name"><?php echo $lang["name company"]; ?></label></div>

                            	<input type="text" name="name" id="nombres" class="form-control" required>
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12 passfieldcont">
                                 <div class="field-label"><label for="description"><?php echo $lang["Description"]; ?>*</label></div>
                            	<input type="text" id="descripcion" name="description" class="form-control">
                            </div>
                         </div>
                        
                         <div class="form-group row">
                            <div class="col-md-12">
                                 <div class="field-label"><label for="contact"><?php echo $lang["contact"]; ?></label></div>
                            	<input type="text" id="contacto" name="contact" class="form-control">
                            </div>
                         </div>
                        
                        
                    </div>
                    <div class="col-md-6">
                    	
                         <div class="form-group row">
                            <div class="col-md-12">
                                 <div class="field-label"><label for="address"><?php echo $lang["Address"]; ?></label></div>
                            	<input type="text" id="direccion" name="address" class="form-control">
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                  <div class="field-label"><label for="phone"><?php echo $lang["Phone client"]; ?></label></div>
                            	<input type="text" id="telefonos" id="telefono" name="phone" class="form-control">
                            </div>
                         </div>
                      
                        
						 
                    </div>
					<div class="col-md-12 submit-btnal">
					<div class="form-group row">
                         <input class="bigbutton" id="guarda" value="<?php echo $lang["Create Company"]; ?>" type="submit" name="add-company"/>
					</div>
					</div>
					</div>
                    
                </div>
              </div>
            </div>
              <div class="clearfix"></div>
            </form> 

      </div>
     
    </div>
  </div>
</div>

<!--Modal para tipos de contactos -->
<div class="modal fade" id="crear1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tipo de Contacto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <div class="add-company">
	  <iframe name="votar" style="display:none;"></iframe>

	  <form method="post" id="formulario" action="#" target="votar" enctype="multipart/form-data">
			<div class="row">
           
              <div class="col-md-12 user-infos">
                <div class="row">
                	<div class="col-md-6">
                    	<div class="form-group row">
                            <div class="col-md-12">
             	<div class="field-label"><label for="name"><?php echo $lang["name company"]; ?></label></div>

				 <input type="text" name="typeTite" id="nombre" class="form-control" placeholder="<?php echo $lang['title diary']; ?>">
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12 passfieldcont">
                                 <div class="field-label"><label for="description"><?php echo $lang["Description"]; ?>*</label></div>
								 <textarea class="form-control" placeholder="<?php echo $lang['Description']; ?>" name="description"></textarea>
                            </div>
                         </div>
                        
                       
						 <div class="col-md-6">
<div class="form-group">
	<input type="hidden" name="status" value="0" >
	<input type="hidden" name="archive" value="0" >
</div>

</div>
                        
                    </div>
                    <div class="col-md-6">
                    	
                         
                        
                      
                        
						 
                    </div>
					<div class="col-md-12 submit-btnal">
					<div class="form-group row">
                         <input class="bigbutton" id="guarda1" name="add-type" value="<?php echo $lang['Add New type']; ?>" type="submit"/>
					</div>
					</div>
					</div>
                    
                </div>
              </div>
            </div>
              <div class="clearfix"></div>
            </form> 
      </div>
     
    </div>
  </div>
</div>

<script src="../assets/js/jquery.js" type="text/javascript"></script>

<script src="https://lib.arvancloud.com/ar/jquery.mask/1.14.9/jquery.mask.js"></script>
<script src="https://lib.arvancloud.com/ar/jquery.mask/1.14.9/jquery.mask.min.js"></script>
<script>
$("#telefono").mask("(999) 999-9999");
$("#telefonos").mask("(999) 999-9999");
</script>  
	<script>
$(document).ready(function(){


$("#nombre").focus();
$(".mod1").click(function(){
	document.getElementById("nombres").value="";
document.getElementById("direccion").value="";
document.getElementById("descripcion").value="";
document.getElementById("telefonos").value="";
document.getElementById("contacto").value="";

		$('#crear1').modal('toggle');
		$("#crear1").removeClass("fade");
		$("#crear1").removeAttr("style");


	});
	$(".close1").click(function(){
		$('.modal').modal('hide');


	});
	$("#guarda1").click(function(){

		$('.modal').modal('hide');
		
		
		
		
	});


	
});
</script>

<script>
$(document).ready(function(){


$("#nombre").focus();
$(".mod").click(function(){
	document.getElementById("nombres").value="";
document.getElementById("direccion").value="";
document.getElementById("descripcion").value="";
document.getElementById("telefonos").value="";
document.getElementById("contacto").value="";

		$('#crear').modal('toggle');
		$("#crear").removeClass("fade");
		$("#crear").removeAttr("style");


	});
	$(".close").click(function(){
		$('.modal').modal('hide');


	});
	$("#guarda").click(function(){

		$('.modal').modal('hide');
		
		
		
		
	});


	
});
</script>
<script>
	

	function alerta(){
	$.post('companiasearch.php').done(function(respuesta){
			$('#compan').empty();
			$('#compan').html(respuesta);
			
		});
	}
	$("#guarda").click(function(){
	window.setInterval("alerta()",100);
});

function tipo(){
	$.post('tiposearch.php').done(function(respuesta){
			$('#tipocontacto').empty();
			$('#tipocontacto').html(respuesta);
			
		});
	}
	$("#guarda1").click(function(){
	window.setInterval("tipo()",100);
});
// 	function reFresh() {



// location.reload(true)



// }

// window.setInterval("reFresh()",1000);
</script>

<?php  include("../templates/admin-footer.php"); ?>


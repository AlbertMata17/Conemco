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
if($_SESSION['accountStatus'] == 2){
	redirectTo($url."client/index.php");
}
if($_SESSION['accountStatus'] == 3){
	redirectTo($url."staff/index.php");
} 
$id=$session->userId; //id of the current logged in user 
$userb = User::findById((int)$id); //take the record of current user in an object array 	
$username=$userb->firstName;;
$email=$userb->email;;
$account_stat=$userb->status;;
$settings = settings::findById((int)$id);
$message = "";
	if(isset($_POST['add-oficina']))
	{
		$flag=0;
		if($flag==0)
		{
			$oficina = new Oficina();

			$oficina->idoficina		= (int)NULL;
			$oficina->name	=$_POST['name'];

			$oficina->contact		=$_POST['contact'];
			$oficina->address		=$_POST['address'];
			$oficina->phone		=$_POST['phone'];
			$oficina->description		=$_POST['description'];
		
			$oficina->status		=0;
			$oficina->created_by		=$username;
			$oficina->modified_by		=$username;
			$oficina->c_id		=$id;
		

			$oficina->trash		= 0 ;
			$oficina->city		=$_POST['city'];
			$oficina->estado		=$_POST['estado'];
			$oficina->country		=$_POST['country'];

			  $saveOficina=$oficina->save();

              $notmessagea = $lang['office has been created successfully!'];
              $notmessageb = $lang['office could not created at this time. Please Try Again Later . Thanks'];
                                if($saveOficina)
                                {
                                    $name = $_POST['TypeTite'];
                                       
              header("Location:oficina.php?message=created");
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
         <h2 class="page-title"><?php echo $lang["Add office"]; ?></h2>
			 <?php if(isset($message) && (!empty($message))){echo $message;} ?>
          <div class="add-oficina">
          	<form method="post" action="#" enctype="multipart/form-data">
			<div class="row">
              <div class="col-md-4 upload-profile-pic">
              		<div class="upload-pro-pic">
					<div class="img-uploadwrap">
                    	<img src="../assets/images/company.png" class="img-fluid"/>
						</div>
                       
						
                    
                    </div>
              </div>
              <div class="col-md-8 user-info">
                <div class="row">
                	<div class="col-md-6">
                    	<div class="form-group row">
                            <div class="col-md-12">
             	<div class="field-label"><label for="name"><?php echo $lang["name office"]; ?></label></div>

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
                                 <div class="field-label"><label for="contact"><?php echo $lang["contact"]; ?></label></div>
                            	<input type="text" name="contact" class="form-control">
                            </div>
                         </div>
                        
                         <div class="form-group row">
                            <div class="col-md-12">
                                 <div class="field-label"><label for="estado"><?php echo $lang["status"]; ?></label></div>
                            	<input type="text" name="estado" class="form-control">
                            </div>
                         </div>
                    </div>
                    <div class="col-md-6">
                    	
                         <div class="form-group row">
                            <div class="col-md-12">
                                 <div class="field-label"><label for="address"><?php echo $lang["Address"]; ?></label></div>
                            	<input type="text" name="address" class="form-control">
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                  <div class="field-label"><label for="phone"><?php echo $lang["Phone client"]; ?></label></div>
                            	<input type="text" id="telefono" name="phone" class="form-control">
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                 <div class="field-label"><label for="ciudad"><?php echo $lang["city"]; ?></label></div>
                            	<input type="text" name="city" class="form-control">
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                 <div class="field-label"><label for="ciudad"><?php echo $lang["country office"]; ?></label></div>
                                 <select name="country" class="form-control">
								<option value=""><?php echo $lang["Select Country"]; ?></option>
	<?php foreach($countries as $countrie){
		echo '<option value="'.$countrie.'">'.$countrie.'</option>';
	} ?>
								</select>                            </div>
                         </div>
                        
						 
                    </div>
					<div class="col-md-12 submit-btnal">
					<div class="form-group row">
                         <input class="bigbutton" value="<?php echo $lang["Create office"]; ?>" type="submit" name="add-oficina"/>
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
<script src="../assets/js/jquery.js" type="text/javascript"></script>

<script src="https://lib.arvancloud.com/ar/jquery.mask/1.14.9/jquery.mask.js"></script>
<script src="https://lib.arvancloud.com/ar/jquery.mask/1.14.9/jquery.mask.min.js"></script>
<script>
$("#telefono").mask("(999) 999-9999");
</script>  
<script>
$(document).ready(function(){
$("#nombre").focus();
});
</script>
<?php  include("../templates/admin-footer.php"); ?>
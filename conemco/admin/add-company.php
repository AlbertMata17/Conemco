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

              $notmessagea = $lang['company has been created successfully!'];
              $notmessageb = $lang['company could not created at this time. Please Try Again Later . Thanks'];
                                if($saveType)
                                {
                                    $name = $_POST['TypeTite'];
                                       
              header("Location:Company.php?message=created");
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
         <h2 class="page-title"><?php echo $lang["Add Company"]; ?></h2>
			 <?php if(isset($message) && (!empty($message))){echo $message;} ?>
          <div class="add-company">
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
             	<div class="field-label"><label for="name"><?php echo $lang["name company"]; ?></label></div>

                            	<input type="text" name="name" id="nombre" class="form-control" required>
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12 passfieldcont">
                                 <div class="field-label"><label for="description"><?php echo $lang["Description"]; ?>*</label></div>
                            	<input type="text" name="description" class="form-control passwordfield" required>
                            </div>
                         </div>
                        
                         <div class="form-group row">
                            <div class="col-md-12">
                                 <div class="field-label"><label for="contact"><?php echo $lang["contact"]; ?></label></div>
                            	<input type="text" name="contact" class="form-control">
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
                      
                        
						 
                    </div>
					<div class="col-md-12 submit-btnal">
					<div class="form-group row">
                         <input class="bigbutton" value="<?php echo $lang["Create Company"]; ?>" type="submit" name="add-company"/>
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
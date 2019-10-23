<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Edit Existing Status  //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php");
$title = "Edit Status | ". $syatem_title;
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
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;
$email=$user->email;
$settings = settings::findById((int)$id);
$account_stat=$user->status;
	$pro_id =  $_POST['idoficina'];
if($pro_id == ""){
	header("Location:oficina.php");
}
$_SESSION['pro_id'] = $pro_id;
$pro_id_u = $_SESSION['pro_id'];
	if(isset($_POST['update-oficina'])){

$flag=0;//determines if all posted values are not empty includ
		
		if($flag==0)
		{
			$cont_desc = mysqli_real_escape_string($connect, $_POST['description']);
			$statusTite = mysqli_real_escape_string($connect, $_POST['name']);
				 $pp_id	= $pro_id;
				$pp_title	= $statusTite;
                $p_status		=$_POST['status'];
                $address		=$_POST['address'];
                $phone		=$_POST['phone'];
                $contact		=$_POST['contact'];
                $city		=$_POST['city'];
                $estado		=$_POST['estado'];
                $country		=$_POST['country'];
                $pp_desc		= $cont_desc;

				  
$sql_up = "UPDATE `office` SET
`name`='$pp_title',
`description`='$pp_desc',
`status`='$p_status',
`modified_by`='$username',
`phone`='$phone',
`contact`='$contact',
`address`='$address',
`city`='$city',
`country`='$county',
`estado`='$estado'
WHERE `idoficina`='$pp_id'";
if ($connect->query($sql_up) === TRUE){
	

 $status_title = $_POST['statusTite'];
					
header("Location:oficina.php?message=success");
				} else {
header("Location:oficina.php?message=fail");
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
          <div class="add-project">
<?php 
$qur_pro = Oficina::findBySql("select * from office where idoficina = '$pro_id'");

foreach($qur_pro as $qur_ar){
	// print_r($qur_ar);
    $idoficina = $qur_ar->idoficina;
    $name = $qur_ar->name;
    $description = $qur_ar->description;
    $status = $qur_ar->status;
    $contact = $qur_ar->contact;
    $address = $qur_ar->address;
    $phone = $qur_ar->phone;
    $status = $qur_ar->status;
    $city = $qur_ar->city;
    $estado = $qur_ar->estado;
    $country = $qur_ar->country;
 
 $recentlyRegisteredUsers=user::findBySql("select * from users");
?>
          	<form method="post" action="#" enctype="multipart/form-data">

<div class="row">

              <div class="col-md-4 upload-profile-pic">
              <h2 class="page-title"><?php echo $lang["Edit office"]; ?></h2>

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

                            	<input type="text" name="name" value="<?php echo $name?>" id="nombre" class="form-control" required>
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12 passfieldcont">
                                 <div class="field-label"><label for="description"><?php echo $lang["Description"]; ?>*</label></div>
                            	<input type="text" name="description" value="<?php echo $description?>" class="form-control" required>
                            </div>
                         </div>
                        
                         <div class="form-group row">
                            <div class="col-md-12">
                                 <div class="field-label"><label for="contact"><?php echo $lang["contact"]; ?></label></div>
                            	<input type="text" value="<?php echo $contact?>" name="contact" class="form-control">
                            </div>
                         </div>
                        
                         <div class="form-group row">
                            <div class="col-md-12">
                                 <div class="field-label"><label for="estado"><?php echo $lang["status"]; ?></label></div>
                            	<input type="text" value="<?php echo $estado?>" name="estado" class="form-control">
                            </div>
                         </div>
                    </div>
                    <div class="col-md-6">
                    	
                         <div class="form-group row">
                            <div class="col-md-12">
                                 <div class="field-label"><label for="address"><?php echo $lang["Address"]; ?></label></div>
                            	<input type="text" value="<?php echo $address?>" name="address" class="form-control">
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                  <div class="field-label"><label for="phone"><?php echo $lang["Phone client"]; ?></label></div>
                            	<input type="text" id="telefono" value="<?php echo $phone?>" name="phone" class="form-control">
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                 <div class="field-label"><label for="ciudad"><?php echo $lang["city"]; ?></label></div>
                            	<input type="text" value="<?php echo $city?>" name="city" class="form-control">
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                 <div class="field-label"><label for="ciudad"><?php echo $lang["country office"]; ?></label></div>
                                 <select name="country" id="country" class="form-control">
								<option value=""><?php echo $lang["Select Country"]; ?></option>
	<?php foreach($countries as $countrie){
		echo '<option value="'.$countrie.'">'.$countrie.'</option>';
	} ?>
								</select>                            </div>
                         </div>
                        
						 
                    </div>
					<div class="col-md-12 submit-btnal">
					<div class="form-group row">
                    <input type="hidden" value="<?php echo $pro_id_u;?>" name="idoficina"/>

                         <input class="bigbutton" value="<?php echo $lang["edit office"]; ?>" type="submit" name="update-oficina"/>
					</div>
					</div>
                    
                </div>
              </div>
            </div>
              <div class="clearfix"></div>
            </form> 
            <?php } ?>
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
    var ultimoval = "<?php echo $country;?>";
    $("#country").val(ultimoval);
$("#nombre").focus();
});
</script>
<?php  include("../templates/admin-footer.php"); ?>
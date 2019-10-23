<?php 
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Add Clients page  //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php");
$title = "Edit client | ". $syatem_title;
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
	$pro_id =  $_POST['idcustomer'];
if($pro_id == ""){
	header("Location:agenda.php");
}
$_SESSION['pro_id'] = $pro_id;
$pro_id_u = $_SESSION['pro_id'];
if(isset($_POST['update-client'])){

    $flag=0;//determines if all posted values are not empty includ
            
            if($flag==0)
            {
                // $project = new Projects();
                $cont_desc = mysqli_real_escape_string($connect, $_POST['description']);
                $projectTite = mysqli_real_escape_string($connect, $_POST['name']);
                     $pp_id	= $pro_id;
                    $pp_title	= $projectTite;
                    $pp_desc		= $cont_desc;
                    $phone		=$_POST['phone'];
                    $email		=$_POST['email'];
                    $address		=$_POST['address'];
                    $status		=$_POST['status'];

                    $modified_by		=$username;
                    $idcompany		=$_POST['idcompany'];
                    $idtype		=$_POST['idtype'];
                    $reference		=$_POST['reference'];
                    $c_id		=$id;

                    $country		=$_POST['country'];
                    $city		=$_POST['city'];              
    $sql_up = "UPDATE `customers` SET
    `c_id`='$c_id',
    `name`='$pp_title',
    `description`='$pp_desc',
    `phone`='$phone',
    `email`='$email',
    `address`='$address',
    `status`='$status',
    `modified_by`='$modified_by',
    `idcompany`='$idcompany',
    `idtype`='$idtype',
    `reference`='$reference',
    `country`='$country',
    `city`='$city'
    WHERE `idcustomer`='$pp_id'";
    if ($connect->query($sql_up) === TRUE){
        
    
     $project_title = $_POST['projectTite'];
                           
    header("Location:agenda.php?message=success");
                    } else {
    header("Location:agenda.php?message=fail");
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
         <h2 class="page-title"><?php echo $lang["Edit contact"]; ?></h2>
			 <?php if(isset($message) && (!empty($message))){echo $message;} ?>
          <div class="add-customer">
          <?php 
$qur_pro = customer::findBySql("select * from customers where idcustomer = '$pro_id'");

foreach($qur_pro as $qur_ar){
	// print_r($qur_ar);
 $name = $qur_ar->name;
 $description = $qur_ar->description;
 $phone = $qur_ar->phone;
 $email = $qur_ar->email;
 $address = $qur_ar->address;
 $idcompany = $qur_ar->idcompany;
 $idtype = $qur_ar->idtype;
 $reference = $qur_ar->reference;
 $country = $qur_ar->country;
 $city = $qur_ar->city;
 $trash = $qur_ar->trash;

 
 $recentlyRegisteredUsers=user::findBySql("select * from users");
 $recentlyRegisteredstatus=customer::findBySql("select * from  customers where status=0 ORDER BY idcustomer DESC");
 $recentlyRegisteredstype=customer::findBySql("select * from customers where status=0 ORDER BY idcustomer DESC");

?>
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

                            	<input type="text" value="<?php echo $name?>" name="name" class="form-control" required>
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12 passfieldcont">
                                 <div class="field-label"><label for="description"><?php echo $lang["Description"]; ?>*</label></div>
                            	<input type="text" value="<?php echo $description?>" name="description" class="form-control passwordfield">
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
                                 <div class="field-label"><label for="skype_id"><?php echo $lang["Company"]; ?></label></div>
								 <select  class="form-control" name="idcompany">
		 <option value=""><?php echo $lang['Select a company']; ?></option>
		<?php $recentlyRegisteredUsers=company::findBySql("select * from companies where status=0 ORDER BY idcompany DESC");
				foreach($recentlyRegisteredUsers as $recentlyRegisteredUser){ 
					if($recentlyRegisteredUser->trash !=1){
						?>
 <option value="<?php echo $recentlyRegisteredUser->idcompany; ?>" <?php if($recentlyRegisteredUser->idcompany == $idcompany){ ?> selected="selected" <?php } ?>><?php echo $recentlyRegisteredUser->name; ?></option>

						<?php 
					}
				}?>
	</select>                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                 <div class="field-label"><label for="city"><?php echo $lang["City"]; ?></label></div>
                            	<input type="text" value="<?php echo $city?>" name="city" class="form-control">
                            </div>
                         </div>
                        
                    </div>
                    <div class="col-md-6">
                    	<div class="form-group row">
                            <div class="col-md-12">
                                <div class="field-label"><label for="email"><?php echo $lang["Email*"]; ?></label></div>
                            	<input type="text" value="<?php echo $email?>" name="email" class="form-control">
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                 <div class="field-label"><label for="address"><?php echo $lang["Address"]; ?></label></div>
                            	<input type="text" value="<?php echo $address?>" name="address" class="form-control">
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                 <div class="field-label"><label for="reference"><?php echo $lang["reference"]; ?></label></div>
                            	<input type="text" value="<?php echo $reference?>" name="reference" class="form-control">
                            </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                <div class="field-label"><label for="idtype"><?php echo $lang["Type contact"]; ?></label></div>
								<select class="form-control" name="idtype">
		 <option value=""><?php echo $lang['Select a type contact']; ?></option>
		<?php $recentlyRegisteredUsers=Type_Diary::findBySql("select * from categories_diary where status=0 ORDER BY idtype DESC");
				foreach($recentlyRegisteredUsers as $recentlyRegisteredUser){ 
					if($recentlyRegisteredUser->trash !=1){
						?>
            <option value="<?php echo $recentlyRegisteredUser->idtype; ?>" <?php if($recentlyRegisteredUser->idtype == $idtype){ ?> selected="selected" <?php } ?>><?php echo $recentlyRegisteredUser->name; ?></option>

						<?php 
					}
				}?>
	</select>                                      </div>
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
                    <input type="hidden" value="<?php echo $pro_id_u;?>" name="idcustomer"/>

                         <input class="bigbutton" value="<?php echo $lang["Edit contact"]; ?>" type="submit" name="update-client"/>
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
<?php  include("../templates/admin-footer.php"); ?>
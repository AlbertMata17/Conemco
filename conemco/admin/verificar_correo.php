<?php
$conexion=mysqli_connect("localhost","root","","conemco");
$el_correo=$_POST['email'];
$query=$conexion->query("SELECT * FROM users WHERE email='$el_correo'");
				
if($row=$query->fetch_assoc()!=null)
{
    
        echo $message="Existe";
         
}else{
   echo $message="No Existe";

}


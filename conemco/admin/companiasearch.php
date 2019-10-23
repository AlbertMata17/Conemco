<?php
$conexion=mysqli_connect("localhost","root","","conemco");
$query=$conexion->query("SELECT * FROM companies WHERE trash=0");
echo '<option value="0" disabled>Selecciona una Compañía </option>';
while($row=$query->fetch_assoc()){
    echo '<option selected value="'.$row['idcompany'].'">'.$row['name'].'</option>'."\n";
}

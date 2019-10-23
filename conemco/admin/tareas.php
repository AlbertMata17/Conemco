<?php
$conexion=mysqli_connect("localhost","root","","conemco");
$el_proyecto=$_POST['tarea'];
$query=$conexion->query("SELECT * FROM milestones WHERE p_id=$el_proyecto");
echo '<option value="0" selected disabled>Selecciona una actividad</option>';
while($row=$query->fetch_assoc()){
    echo '<option value="'.$row['id'].'">'.$row['title'].'</option>'."\n";
}

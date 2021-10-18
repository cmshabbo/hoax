<?php 
include("../../includes/config.php");
require_once('../class/database.php');
$db = new Database();

$getRooms = $db->executeQuery('SELECT * FROM rooms WHERE owner = "3" AND loyer = "1" ORDER BY prix_vente ASC');
foreach ($getRooms as $getRoomsRow) {
?>
		<tr>
			<td>#<?php echo $getRoomsRow["id"]; ?></td>
			<td><?php echo $getRoomsRow["caption"]; ?></td> 
			<td><?php echo $getRoomsRow["prix_vente"]; ?>c</td>
			<td style="text-align: right"><button class="louerButton" id="<?php echo $getRoomsRow["id"]; ?>">Louer</button></td>
		</tr>
<?php
}
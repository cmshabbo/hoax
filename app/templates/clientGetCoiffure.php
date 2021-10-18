<?php 
include("../../includes/config.php");
require_once('../class/database.php');
$db = new Database();

if(isset($_GET["gender"]))
{
	if($_GET["gender"] == "f" || $_GET["gender"] == "m")
	{
		$coiffureF = $db->executeQuery('SELECT * FROM coiffures WHERE type = ?', array($_GET["gender"]));
		foreach ($coiffureF as $coiffureFRow) 
		{
?>
			<li id="<?php echo $coiffureFRow["name"]; ?>"><img src="http://habbo.fr/habbo-imaging/avatarimage?figure=hr-<?php echo $coiffureFRow["name"]; ?>-61&amp;gender=<?php echo $_GET["gender"]; ?>"></li>
<?php 
		}
	}
}
?>

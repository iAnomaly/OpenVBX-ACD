<?php
$agents = (array)PluginData::get("Agents");
$calls = (array)PluginData::get("Calls");

switch ($_REQUEST["dbg"]) {
		case "globals":
			echo "<table border='1' width='100%'>";
			echo "<tr><td>KEY</td><td>VAL</td></tr>";
			foreach ($GLOBALS as $key => $value) {
				echo "<tr><td>$key</td><td>$value</td></tr>";
			}
			echo "</table>";
		break;
		
		case "requests":
			echo "<table border='1' width='100%'>";
			echo "<tr><td>KEY</td><td>VAL</td></tr>";
			foreach ($_REQUEST as $key => $value) {
				echo "<tr>";
				echo "<td>$key</td>";
				echo "<td>$value</td>";
				echo "</tr>";
			}
			echo "</table>";
		break;
		
		case "agents":
			var_dump($agents);
		break;
		
		case "users":
			echo "<table border='1' width='100%'>";
			echo "<tr><td>USER</td></tr>";
			foreach (OpenVBX::getUsers() as $user) {
				echo "<tr><td>";
				var_dump($user->devices);
				echo "</td></tr>";
			}
		break;
		
		case "devices":
			$user_id = "2";
			var_dump(PluginData::sqlQuery("SELECT * FROM numbers WHERE user_id=$user_id AND is_active=1 ORDER BY sequence"));
		break;
		
		case "debug":
			echo "<table border='1' width='100%'>";
			echo "<tr><td>KEY</td><td>VAL</td></tr>";
			foreach (PluginData::get("Debug") as $key => $value) {
				echo "<tr>";
				echo "<td>$key</td>";
				echo "<td>$value</td>";
				echo "</tr>";
			}
			echo "</table>";
		break;
		
		case "custom":
		break;
		
		case "delAgents":
			PluginData::delete("Agents");
			echo "Deleted.";
		break;
		
		case "delCalls":
			PluginData::delete("Calls");
			echo "Deleted.";
		break;
}
exit();
?>
<?php
if (isset($_REQUEST["get"])) {
	header("Content-Type: application/json");
	echo json_encode($calls);
} elseif (isset($_REQUEST["setAvailable"])) {
	if ($_REQUEST["setAvailable"])
	{
		$agents["U{$current_user_id}"] = "";
	} else {
		unset($agents["U{$current_user_id}"]);
	}
	
	PluginData::set("Agents", $agents);
	echo json_encode(NULL);
}

exit();
?>
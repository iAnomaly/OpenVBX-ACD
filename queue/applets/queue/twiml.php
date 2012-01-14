<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL | E_STRICT);

$twilio_sid = PluginData::get("twilio_sid");
$twilio_token = PluginData::get("twilio_token");

$agents = (array)PluginData::get("Agents");
$calls = (array)PluginData::get("Calls");

$response = new Response();
$rest_client = new TwilioRestClient($twilio_sid, $twilio_token);
$next = AppletInstance::getDropZoneUrl("next");
$instance_url = AppletInstance::getBaseURI().'/'.AppletInstance::getInstanceId();

if (isset($_REQUEST["JoinConference"])) {
	$dial = $response->addDial(NULL);
	$dial->addConference($_REQUEST["JoinConference"], array("endConferenceOnExit" => "true"));
} elseif (isset($_REQUEST["DialCallStatus"])) {
	switch ($_REQUEST["DialCallStatus"])
	{
		case "queued":
			break;
		case "ringing":
			break;
		case "in-progress":
			break;
		case "completed":
			unset($calls[$_REQUEST["CallSid"]]);
			PluginData::set("Calls", $calls);
			break;
		case "busy":
			//break;
		case "failed":
			//break;
		case "no-answer":
			//break;
		case "canceled":
			if (!empty($next)) {
				$response->addRedirect($next);
			}
			break;
	}
	
	$user_id;
	foreach ($agents as $agent_id => $callSid) {
		if ($callSid == $_REQUEST["CallSid"])
		{
			$agents[$agent_id] = ""; // unassign call from agent
			$user_id = substr($agent_id, 1);
			break;
		}
	}
	PluginData::set("Agents", $agents);
	
	// Check for a queued call
	if (!empty($calls) && $user_id) {
		$call = (array)array_shift($calls);
		PluginData::set("Calls", $calls);
		$user = OpenVBX::getUsers(array('id' => $user_id));
		$devices = $user[0]->devices;
		$rest_response = $rest_client->request("Accounts/$twilio_sid/Calls",
											"POST",
											array(
											"From" => $call["From"],
											"To" => $devices[0]->value,
											"Url" => $instance_url."?JoinConference=".$call['ConferenceName']));
	}
} else {
	if (empty($agents)) { // no operators available
			if (!empty($next)) {
				$response->addRedirect($next);
			}
	} else {
		$dial = $response->addDial(NULL, array("action" => $instance_url));
		
		$all_agents_busy = true;
		foreach ($agents as $agent_id => $callSid) {
			if (!$callSid) // not busy
			{
				$user_id = substr($agent_id, 1);
				$user = OpenVBX::getUsers(array('id' => $user_id));
				$devices = $user[0]->devices;
				
				foreach ($devices as $device) {
					if ($device->is_active) {
						if ($device->name == "client") {
							$dial->addClient(substr($device->value, 7));
						} else {
							$dial->addNumber($device->value);
						}
					}
				}
				
				$agents[$agent_id] = (string)$_REQUEST["CallSid"];
				PluginData::set("Agents", $agents);
				$all_agents_busy = false;
			}
		}
		
		if ($all_agents_busy) {
			$conference_name = "QU" . substr($_REQUEST["CallSid"], 2);
		
			if (isset($_REQUEST["CallSid"])) {
				$calls[$_REQUEST["CallSid"]] = array(
				"CallSid" => $_REQUEST["CallSid"],
				"From" => $_REQUEST["From"],
				"To" => $_REQUEST["To"],
				"FromCity" => ucwords(strtolower($_REQUEST["FromCity"])),
				"FromState" => $_REQUEST["FromState"],
				"FromZip" => $_REQUEST["FromZip"],
				"FromCountry" => $_REQUEST["FromCountry"],
				"StartTime" => date("r"),
				"ConferenceName" => $conference_name,
				"QueueName" => AppletInstance::getValue('queue-name'),
				);
				
				PluginData::set("Calls", $calls);
			} else {
			}
			
			$dial->addConference($conference_name, array("beep" => "false", "startConferenceOnEnter" => "false", "endConferenceOnExit" => "true", "waitUrl" => AppletInstance::getValue("hold-url")));
		}
	}
}
$response->Respond();
<?php
PluginData::set("twilio_sid", $this->twilio_sid);
PluginData::set("twilio_token", $this->twilio_token);
$baseURI="Accounts/{$this->twilio_sid}";
$current_user_id = OpenVBX::getCurrentUser()->id;
$agents = (array)PluginData::get("Agents");
$calls = (array)PluginData::get("Calls");

if (isset($_REQUEST["q"])) {
	require "req.php";
}

if (isset($_REQUEST["dbg"])) {
	include "dbg.php";
}

require "ui.php";
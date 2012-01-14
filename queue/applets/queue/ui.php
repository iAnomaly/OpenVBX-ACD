<?php
$holdUrl = AppletInstance::getValue('hold-url');
$holdMusicOptions = array(
						array("url" => "http://twimlets.com/holdmusic?Bucket=com.twilio.music.ambient", "name" => "Ambient"),
						array("url" => "http://twimlets.com/holdmusic?Bucket=com.twilio.music.classical", "name" => "Classical"),
						array("url" => "http://twimlets.com/holdmusic?Bucket=com.twilio.music.electronica", "name" => "Electronica"),
						array("url" => "http://twimlets.com/holdmusic?Bucket=com.twilio.music.guitars", "name" => "Guitars"),
						//array("url" => "http://twimlets.com/holdmusic?Bucket=com.twilio.music.newage", "name" => "New Age"),
						array("url" => "http://twimlets.com/holdmusic?Bucket=com.twilio.music.rock", "name" => "Rock"),
						array("url" => "http://twimlets.com/holdmusic?Bucket=com.twilio.music.soft-rock", "name" => "Soft Rock"),
                      );
?>

<div class="vbx-applet">
  <h2>Name</h2>
  <div class="vbx-full-pane vbx-input-container">
    <input type="text" class="medium" name="queue-name" value="<?php echo AppletInstance::getValue('queue-name'); ?>"/>
  </div>
  <h2>Hold Music</h2>
  <div class="vbx-full-pane vbx-input-container">
    <p>While the caller is waiting for an agent they will hear:</p>
    <select name="hold-url" class="medium">
      <?php foreach($holdMusicOptions as $option) { ?>
      <option value="<?php echo $option["url"]?>" <?php echo ($holdUrl == $option["url"])? 'selected="selected"' : '' ?>><?php echo $option["name"]; ?></option>
      <?php } ?>
    </select>
  </div>
  <h3>When no agents are accepting calls...</h3>
  <div class="vbx-full-pane vbx-input-container">
    <p>Redirect the caller to another applet.</p>
    <?php echo AppletUI::DropZone("next"); ?> </div>
</div>

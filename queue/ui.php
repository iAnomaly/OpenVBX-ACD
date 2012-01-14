<?php
OpenVBX::addJS('queue.js');
?>

<div class="vbx-content-menu vbx-content-menu-top">
  <h2 class="vbx-content-heading">Call Queue</h2>
  <div class="vbx-menu-items-right">
    <fieldset class="vbx-input-container">
      <select id="select-available" class="medium">
        <option value="0">Unavailable</option>
        <option value="1"<?php echo (isset($agents["U{$current_user_id}"])) ? ' selected="selected"' : ''; ?>>Available</option>
      </select>
    </fieldset>
    </div>
</div>
<div class="vbx-table-section">
  <table id="table-queue" class="vbx-items-grid">
    <thead class="items-head">
      <tr>
      	<th>Queue</th>
        <th>Caller</th>
        <th>City</th>
		<th>State</th>
		<th>Country</th>
		<th>ZIP</th>
        <th>Wait</th>
      </tr>
    </thead>
    <tbody id="table-queue-body" class='items-row'>
    </tbody>
  </table>
</div>
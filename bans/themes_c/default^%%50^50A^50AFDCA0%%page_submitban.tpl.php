<?php /* Smarty version 2.6.29, created on 2016-01-17 20:39:24
         compiled from page_submitban.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sb_button', 'page_submitban.tpl', 78, false),)), $this); ?>
<table style="width: 101%; margin: 0 0 -2px -2px;">
	<tr>
		<td colspan="3" class="listtable_top"><b>Submit a player</b></td>
	</tr>
</table>
<div id="submit-main">
	Here you will be able to submit a ban for a player who is breaking the rules of the gameserver. When submitting a ban we request you to fill out all the fields to be as descriptive as possible in your comments. This will ensure that your ban submission is processed much faster.<br /><br />
    For a short explination on how to create a demo, click <a href="javascript:void(0)" onclick="ShowBox('How To Record A Demo', 'While you are spectating the offending player, press the ` key on your keyboard. Then type record [demoname] and hit enter. Also type sb_status for extra information in SteamBans servers. The file will be in your mod folder.', 'blue', '', true);">here</a><br /><br />
<form action="index.php?p=submit" method="post" enctype="multipart/form-data">
<input type="hidden" name="subban" value="1">
<table cellspacing='10' width='100%' align='center'>
<tr>
	<td colspan="3">
		Ban Details:	</td>
</tr>
<tr>
	<td width="20%">
		Players SteamID:</td>
	<td>
		<input type="text" name="SteamID" size="40" maxlength="64" value="<?php echo $this->_tpl_vars['STEAMID']; ?>
" class="textbox" style="width: 250px;" />
	</td>
</tr>
<tr>
	<td width="20%">
		Players IP:</td>
	<td>
		<input type="text" name="BanIP" size="40" maxlength="64" value="<?php echo $this->_tpl_vars['ban_ip']; ?>
" class="textbox" style="width: 250px;" />
	</td>
</tr>
<tr>
	<td width="20%">
        Players Nick Name<span class="mandatory">*</span>:</td>
	<td>
        <input type="text" size="40" maxlength="70" name="PlayerName" value="<?php echo $this->_tpl_vars['player_name']; ?>
" class="textbox" style="width: 250px;" /></td>
</tr>
<tr>
	<td width="20%" valign="top">
		Comments<span class="mandatory">*</span>:<br />
		(Please write down a descriptive comment. So NO comments like: "hacking")	</td>
	<td><textarea name="BanReason" cols="30" rows="5" class="textbox" style="width: 250px;"><?php echo $this->_tpl_vars['ban_reason']; ?>
</textarea></td>
    </tr>
<tr>
	<td width="20%">
		Your Name:	</td>
	<td>
		<input type="text" size="40" maxlength="70" name="SubmitName" value="<?php echo $this->_tpl_vars['subplayer_name']; ?>
" class="textbox" style="width: 250px;" />	</td>
    </tr>

<tr>
	<td width="20%">
		Your Email<span class="mandatory">*</span>:	</td>
	<td>
		<input type="text" size="40" maxlength="70" name="EmailAddr" value="<?php echo $this->_tpl_vars['player_email']; ?>
" class="textbox" style="width: 250px;" />	</td>
    </tr>
<tr>
	<td width="20%">
		Server<span class="mandatory">*</span>:	</td>
	<td colspan="2">
        <select id="server" name="server" class="select" style="width: 277px;">
			<option value="-1">-- Select Server --</option>
			<?php $_from = ($this->_tpl_vars['server_list']); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['server']):
?>
				<option value="<?php echo $this->_tpl_vars['server']['sid']; ?>
" <?php if ($this->_tpl_vars['server_selected'] == $this->_tpl_vars['server']['sid']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['server']['hostname']; ?>
</option>
			<?php endforeach; endif; unset($_from); ?>
			<option value="0">Other server / Not listed here</option>
		</select> 
    </td>
    </tr>
<tr>
	<td width="20%">
		Upload demo:	</td>
	<td>
		<input name="demo_file" type="file" size="25" class="file" style="width: 268px;" /><br />
		Note: Only DEM, <a href="http://www.winzip.com" target="_blank">ZIP</a>, <a href="http://www.rarlab.com" target="_blank">RAR</a>, <a href="http://www.7-zip.org" target="_blank">7Z</a>, <a href="http://www.bzip.org" target="_blank">BZ2</a> or <a href="http://www.gzip.org" target="_blank">GZ</a> allowed.	</td>
    </tr>
<tr>
	<td width="20%"><span class="mandatory">*</span> = Mandatory Field</td>
	<td>
		<?php echo smarty_function_sb_button(array('text' => 'Submit','onclick' => "",'class' => 'ok','id' => 'save','submit' => true), $this);?>

	</td>
    <td>&nbsp;</td>
</tr>
</table>
</form>
<b>What happens if someone gets banned?</b><br />
If someone gets banned, the specific STEAMID or IP will be included in this SourceBans database and everytime this player tries to connect to one of our servers he/she will be blocked and will receive a message that they are blocked by SourceBans. 
</div>
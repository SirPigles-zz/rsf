<?php /* Smarty version 2.6.29, created on 2016-02-04 10:50:34
         compiled from page_protestban.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sb_button', 'page_protestban.tpl', 63, false),)), $this); ?>
<table style="width: 101%; margin: 0 0 -2px -2px;">
	<tr>
		<td colspan="3" class="listtable_top"><b>Protest a ban</b></td>
	</tr>
</table>
<div id="submit-main">
Before you proceed, make sure you first check our <a href="index.php?p=banlist">banlist</a> <b>and</b> <a href="index.php?p=commslist">commslist</a> and search it for your name.<br />
When you figure out the reason for your punishment, <a href="http://forums.rafflesmash.com/showthread.php?tid=134.">click here</a> to read how to appeal.<br />
<b>ONLY</b> once you have read the instructions <b>in full</b>, proceed. <b>Only one shot at appealing is given in most cases.</b><br /><br />
<form action="index.php?p=protest" method="post">
<input type="hidden" name="subprotest" value="1">
<table cellspacing='10' width='100%' align='center'>
<tr>
	<td colspan="3">
		Your Details:	</td>
</tr>
<tr>
	<td width="20%">Ban Type:</td>
	<td>
		<select id="Type" name="Type" class="select" style="width: 250px;" onChange="changeType(this[this.selectedIndex].value);">
			<option value="0">SteamID Account Ban</option>
			<option value="1">IP Address Ban</option>
			<option value="2">Mute (voice)</option>
			<option value="3">Gag (chat)</option>
			<option value="4">Silence (Mute and Gag)</option>
		</select>
	</td>
</tr>
<tr id="steam.row">
	<td width="20%">
		Your SteamID<span class="mandatory">*</span>:</td>
	<td>
		<input type="text" name="SteamID" size="40" maxlength="64" value="<?php echo $this->_tpl_vars['steam_id']; ?>
" class="textbox" style="width: 223px;" />
	</td>
</tr>
<tr id="ip.row" style="display: none;">
	<td width="20%">
		Your IP<span class="mandatory">*</span>:</td>
	<td>
		<input type="text" name="IP" size="40" maxlength="64" value="<?php echo $this->_tpl_vars['ip']; ?>
" class="textbox" style="width: 223px;" />
	</td>
</tr>
<tr>
	<td width="20%">
        Name<span class="mandatory">*</span>:</td>
	<td>
        <input type="text" size="40" maxlength="70" name="PlayerName" value="<?php echo $this->_tpl_vars['player_name']; ?>
" class="textbox" style="width: 223px;" /></td>
    </tr>
<tr>
	<td width="20%" valign="top">
		Why should your punishment be lifted?<span class="mandatory">*</span> (Be as descriptive as possible) </td>
	<td><textarea name="BanReason" cols="30" rows="5" class="textbox" style="width: 223px;"><?php echo $this->_tpl_vars['reason']; ?>
</textarea></td>
    </tr>
<tr>
	<td width="20%">
		Your Email<span class="mandatory">*</span>:	</td>
	<td>
		<input type="text" size="40" maxlength="70" name="EmailAddr" value="<?php echo $this->_tpl_vars['player_email']; ?>
" class="textbox" style="width: 223px;" /></td>
    </tr>
<tr>
	<td width="20%"><span class="mandatory">*</span> = Mandatory Field</td>
	<td>
		<?php echo smarty_function_sb_button(array('text' => 'Submit','class' => 'ok','id' => 'alogin','submit' => true), $this);?>

	</td>
    <td>&nbsp;</td>
</tr>
</table>
</form>
<b>What happens after you post your protest?</b><br />
  The RaffleSmash admin team will review the protest and decide if the ban will remain. Appeals can take time to process; please be patient.<br />
  <b>Note:</b> Asking admins for the status of your appeal will result in it being denied. Disrespecting admins will also produce the same result.
</div>
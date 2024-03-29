<?php /* Smarty version 2.6.29, created on 2016-01-09 22:02:00
         compiled from page_admin_settings_features.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'help_icon', 'page_admin_settings_features.tpl', 8, false),array('function', 'sb_button', 'page_admin_settings_features.tpl', 52, false),)), $this); ?>
<form action="" method="post">
    <input type="hidden" name="settingsGroup" value="features" />
    <table width="99%" border="0" style="border-collapse:collapse;" id="group.features" cellpadding="3">
        <tr>
            <td valign="top" colspan="2"><h3>Ban Features</h3>For more information or help regarding a certain subject move your mouse over the question mark.<br /><br /></td>
        </tr>
        <tr>
            <td valign="top" width="35%"><div class="rowdesc"><?php echo smarty_function_help_icon(array('title' => 'Enable Public Bans','message' => "Check this box to enable the entire ban list to be publically downloaded and shared."), $this);?>
Make Export Bans Public</div></td>
            <td>
                <div align="left">
                   <input type="checkbox" name="export_public" id="export_public" />
                </div>
            </td>
        </tr>
        <tr>
            <td valign="top"><div class="rowdesc"><?php echo smarty_function_help_icon(array('title' => 'Enable KickIt','message' => "Check this box to kick a player when a ban is posted."), $this);?>
Enable KickIt</div></td>
            <td>
                <div align="left">
                   <input type="checkbox" name="enable_kickit" id="enable_kickit" />
                </div>
            </td>
        </tr>
		<tr>
			<td valign="top"><div class="rowdesc"><?php echo smarty_function_help_icon(array('title' => 'Enable Group Banning','message' => "Check this box, if you want to enable banning of whole steam community groups."), $this);?>
Enable Group Banning</div></td>
		    <td>
		    	<div align="left">
		      		<input type="checkbox" name="enable_groupbanning" id="enable_groupbanning" />
		    	</div>
		    	<div id="enable_groupbanning.msg" class="badentry"></div>
		    </td>
		</tr>
		<tr>
			<td valign="top"><div class="rowdesc"><?php echo smarty_function_help_icon(array('title' => 'Enable Friend Banning','message' => "Check this box, if you want to enable banning all steam community friends of a player."), $this);?>
Enable Friends Banning</div></td>
		    <td>
		    	<div align="left">
		      		<input type="checkbox" name="enable_friendsbanning" id="enable_friendsbanning" />
		    	</div>
		    	<div id="enable_friendsbanning.msg" class="badentry"></div>
		    </td>
		</tr>
		<tr>
			<td valign="top"><div class="rowdesc"><?php echo smarty_function_help_icon(array('title' => 'Enable Admin Rehashing','message' => "Check this box, if you want to enable the admin rehashing everytime an admin/group has been changed."), $this);?>
Enable Admin Rehashing</div></td>
		    <td>
		    	<div align="left">
		      		<input type="checkbox" name="enable_adminrehashing" id="enable_adminrehashing" />
		    	</div>
		    	<div id="enable_adminrehashing.msg" class="badentry"></div>
		    </td>
		</tr>
        <tr>
            <td colspan="2" align="center">
                <?php echo smarty_function_sb_button(array('text' => 'Save Changes','class' => 'ok','id' => 'fsettings','submit' => true), $this);?>

                &nbsp;
                <?php echo smarty_function_sb_button(array('text' => 'Back','class' => 'cancel','id' => 'fback'), $this);?>

            </td>
        </tr>
    </table>
</form>
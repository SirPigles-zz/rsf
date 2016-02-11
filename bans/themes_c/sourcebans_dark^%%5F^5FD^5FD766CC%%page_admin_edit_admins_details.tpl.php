<?php /* Smarty version 2.6.29, created on 2016-01-08 20:11:38
         compiled from page_admin_edit_admins_details.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'help_icon', 'page_admin_edit_admins_details.tpl', 8, false),array('function', 'sb_button', 'page_admin_edit_admins_details.tpl', 63, false),)), $this); ?>
<form action="" method="post">
<div id="admin-page-content">

<div id="add-group">
<h3>Admin Details</h3>
<table width="90%" border="0" style="border-collapse:collapse;" id="group.details" cellpadding="3">
  <tr>
    <td valign="top" width="35%"><div class="rowdesc"><?php echo smarty_function_help_icon(array('title' => 'Admin Login','message' => "This is the username the admin will use to login-to their admin panel. Also this will identify the admin on any bans they make."), $this);?>
Admin Login </div></td>
    <td><div align="left">
        <input type="text" class="submit-fields" id="adminname" name="adminname" value="<?php echo $this->_tpl_vars['user']; ?>
" />
      </div>
        <div id="adminname.msg" class="badentry"></div></td>
  </tr>
  <tr>
    <td valign="top"><div class="rowdesc"><?php echo smarty_function_help_icon(array('title' => 'Steam ID','message' => "This is the admins 'STEAM' id. This must be set so that admins can use their admin rights ingame."), $this);?>
Admin STEAM ID </div></td>
    <td><div align="left">
      <input type="text" class="submit-fields" id="steam" name="steam" value="<?php echo $this->_tpl_vars['authid']; ?>
" />
    </div><div id="steam.msg" class="badentry"></div></td>
  </tr>
  <tr>
    <td valign="top"><div class="rowdesc"><?php echo smarty_function_help_icon(array('title' => 'Admin Email','message' => "Set the admins e-mail address. This will be used for sending out any automated messages from the system, and for use when you forget your password."), $this);?>
Admin Email </div></td>
    <td><div align="left">
        <input type="text" class="submit-fields" id="email" name="email" value="<?php echo $this->_tpl_vars['email']; ?>
" />
      </div>
        <div id="email.msg" class="badentry"></div></td>
  </tr>
  
  <?php if ($this->_tpl_vars['change_pass']): ?>
  <tr>
    <td valign="top"><div class="rowdesc"><?php echo smarty_function_help_icon(array('title' => 'Password','message' => "The password the admin will need to access the admin panel."), $this);?>
Admin Password </div></td>
    <td><div align="left">
        <input type="password" class="submit-fields" id="password" name="password" />
      </div>
        <div id="password.msg" class="badentry"></div></td>
  </tr>
  <tr>
    <td valign="top"><div class="rowdesc"><?php echo smarty_function_help_icon(array('title' => 'Password','message' => "Type your password again to confirm."), $this);?>
Admin Password (confirm) </div></td>
    <td><div align="left">
        <input type="password" class="submit-fields" id="password2" name="password2" />
      </div>
        <div id="password2.msg" class="badentry"></div></td>
  </tr>
  <tr>
    <td valign="top" width="35%">
      <div class="rowdesc">
        <?php echo smarty_function_help_icon(array('title' => 'Server Admin Password','message' => "If this box is checked, you will need to specify this password in the game server before you can use your admin rights."), $this);?>
Server Password <small>(<a href="http://wiki.alliedmods.net/Adding_Admins_%28SourceMod%29#Passwords" title="SourceMod Password Info" target="_blank">More</a>)</small>
      </div>
    </td>
    <td>
      <div align="left">
        <input type="checkbox" id="a_useserverpass" name="a_useserverpass"<?php if ($this->_tpl_vars['a_spass']): ?> checked="checked"<?php endif; ?> TABINDEX=6 onclick="$('a_serverpass').disabled = !$(this).checked;" /> <input type="password" TABINDEX=7 class="submit-fields" name="a_serverpass" id="a_serverpass"<?php if (! $this->_tpl_vars['a_spass']): ?> disabled="disabled"<?php endif; ?> />
      </div>
      <div id="a_serverpass.msg" class="badentry"></div>
    </td>
  </tr>
  
  <?php endif; ?>
  
 </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
      <?php echo smarty_function_sb_button(array('text' => 'Save Changes','class' => 'ok','id' => 'editmod','submit' => true), $this);?>

	&nbsp;
	  <?php echo smarty_function_sb_button(array('text' => 'Back','onclick' => "history.go(-1)",'class' => 'cancel','id' => 'back','submit' => false), $this);?>
 
      </td>
  </tr>
</table>
</div></div></form>
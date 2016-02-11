<?php /* Smarty version 2.6.29, created on 2016-02-03 10:36:46
         compiled from page_admin_bans_email.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'help_icon', 'page_admin_bans_email.tpl', 5, false),array('function', 'sb_button', 'page_admin_bans_email.tpl', 23, false),)), $this); ?>
<h3>Email Player  <i>(<?php echo $this->_tpl_vars['email_addr']; ?>
)</i></h3>
<table width="90%" style="border-collapse:collapse;" id="group.details" cellpadding="3">
	<tr>
    	<td valign="top" width="35%">
    		<div class="rowdesc"><?php echo smarty_function_help_icon(array('title' => 'Subject','message' => "Type the subject of the email."), $this);?>
Subject </div>
    	</td>
    	
    <td><div align="left">
      <input type="text" TABINDEX=1 class="textbox" id="subject" name="subject" />
    </div><div id="subject.msg" class="badentry"></div></td>
  </tr>
  <tr>
    <td valign="top"><div class="rowdesc"><?php echo smarty_function_help_icon(array('title' => 'Message','message' => "Type your message here."), $this);?>
Message </div></td>
    <td><div align="left">
       <textarea class="textbox" TABINDEX=2 cols="35" rows="7" id="message" name="message"></textarea>
    </div><div id="message.msg" class="badentry"></div></td>
  </tr>
 	

 <tr>
    <td>&nbsp;</td>
		<td>
      		<?php echo smarty_function_sb_button(array('text' => 'Send Email','onclick' => ($this->_tpl_vars['email_js']),'class' => 'ok','id' => 'aemail','submit' => false), $this);?>

     		 &nbsp;
      		<?php echo smarty_function_sb_button(array('text' => 'Back','onclick' => "history.go(-1)",'class' => 'cancel','id' => 'back','submit' => false), $this);?>

     	</td>
 	</tr>
</table>

<?php /* Smarty version 2.6.29, created on 2016-01-08 18:08:54
         compiled from page_admin_servers_rcon.tpl */ ?>
<?php if (! $this->_tpl_vars['permission_rcon']): ?>
	Access Denied!
<?php else: ?>
<div id="admin-page-content">
<div id="1">


<h3>RCON Console</h3>
<div align="center" width="90%">
<div id="rcon" style="overflow:auto;
			background-color:#efefef;
			border: 1px solid #999;
			padding: 3px;
			height: 250px;
			width: 90%;" align="left">

<pre>















<div id="rcon_con">***********************************************************<br />**&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;**<br />*&nbsp;SourceBans RCON console&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*<br />*&nbsp;Type your comand in the box below and hit enter&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*<br />*&nbsp;Type 'clr' to clear the console&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*<br />**&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;**<br />***********************************************************<br />
</div>
</pre>
</div>
<br />
Command: <input type="text" style="font-family:verdana, tahoma, arial;font-size:10px;width:500px" id="cmd"> 
<input type="button" onclick="SendRcon();" id="rcon_btn" value="Send">
</div>
</div></div>
<script>

$E('html').onkeydown = function(event){
    var event = new Event(event);
    if (event.key == 'enter' ) SendRcon();
};

function SendRcon()
{
	xajax_SendRcon('<?php echo $this->_tpl_vars['id']; ?>
', $('cmd').value, true);
	 $('cmd').value='Executing, Please Wait...'; $('cmd').disabled='true'; $('rcon_btn').disabled='true';
	 
}
</script>
<?php endif; ?>
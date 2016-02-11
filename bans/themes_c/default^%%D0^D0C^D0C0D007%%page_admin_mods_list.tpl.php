<?php /* Smarty version 2.6.29, created on 2016-01-22 18:23:04
         compiled from page_admin_mods_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'page_admin_mods_list.tpl', 17, false),array('modifier', 'escape', 'page_admin_mods_list.tpl', 27, false),)), $this); ?>
<?php if (! $this->_tpl_vars['permission_listmods']): ?>
	Access Denied!
<?php else: ?>
	<h3>Server Mods (<?php echo $this->_tpl_vars['mod_count']; ?>
)</h3>
	<table width="100%" cellspacing="0" cellpadding="0" align="center" class="listtable">
		<tr>
			<td width="50%" height='16' class="listtable_top"><strong>Name</strong></td>
			<td width="25%" height='16' class="listtable_top"><strong>Mod Folder</strong></td>
			<td width="10%" height='16' class="listtable_top"><strong>Mod icon</strong></td>
			<td width="2%" height='16' class="listtable_top"><strong><span title="SteamID Universe (X of STEAM_X:Y:Z)">SU</span></strong></td>
			<?php if ($this->_tpl_vars['permission_editmods'] || $this->_tpl_vars['permission_deletemods']): ?>
			<td height='16' class="listtable_top"><strong>Action</strong></td>
			<?php endif; ?>
		</tr>
		<?php $_from = ($this->_tpl_vars['mod_list']); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['gaben'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['gaben']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['mod']):
        $this->_foreach['gaben']['iteration']++;
?>
			<tr id="mid_<?php echo $this->_tpl_vars['mod']['mid']; ?>
">
				<td class="listtable_1" height='16'><?php echo ((is_array($_tmp=$this->_tpl_vars['mod']['name'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</td>
				<td class="listtable_1" height='16'><?php echo ((is_array($_tmp=$this->_tpl_vars['mod']['modfolder'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</td>
				<td class="listtable_1" height='16'><img src="images/games/<?php echo $this->_tpl_vars['mod']['icon']; ?>
" width="16"></td>
				<td class="listtable_1" height='16'><?php echo ((is_array($_tmp=$this->_tpl_vars['mod']['steam_universe'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</td>
				<?php if ($this->_tpl_vars['permission_editmods'] || $this->_tpl_vars['permission_deletemods']): ?>
				<td class="listtable_1" height='16'>
					<?php if ($this->_tpl_vars['permission_editmods']): ?>
					<a href="index.php?p=admin&c=mods&o=edit&id=<?php echo $this->_tpl_vars['mod']['mid']; ?>
">Edit</a> - 
					<?php endif; ?>
					<?php if ($this->_tpl_vars['permission_deletemods']): ?>
					<a href="#" onclick="RemoveMod('<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['mod']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')))) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
', '<?php echo $this->_tpl_vars['mod']['mid']; ?>
');">Delete</a>
					<?php endif; ?>
				</td>
				<?php endif; ?>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
	</table>
<?php endif; ?>
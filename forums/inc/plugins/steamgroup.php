<?php

/********************************************************************************************************************************
*
*  Steam group (/inc/plugins/steamgroup.php)
*  Author: Krzysztof "Supryk" Supryczyński
*  Copyright: © 2013 - 2015 @ Krzysztof "Supryk" Supryczyński @ All rights reserved
*  
*  Website: 
*  Description: Show information about steam group on index and portal page in sidebox.
*
********************************************************************************************************************************/
/********************************************************************************************************************************
*
* This file is part of "Steam group" plugin for MyBB.
* Copyright © 2013 - 2015 @ Krzysztof "Supryk" Supryczyński @ All rights reserved
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU Lesser General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Lesser General Public License for more details.
*
* You should have received a copy of the GNU Lesser General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
********************************************************************************************************************************/

if(!defined("IN_MYBB"))
{
	die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

$plugins->add_hook("portal_end", "steamgroup_end");
$plugins->add_hook("index_end", "steamgroup_end");
$plugins->add_hook("admin_tools_cache_view", "update_steamgroup");
$plugins->add_hook("global_start", "steamgroup_templatelist");
$plugins->add_hook("pre_output_page", "steamgroup_thanks");


function steamgroup_info()
{
    global $lang;
    $lang->load("config_steamgroup");
	
	return array(
		"name"			=> $lang->steamgroup_name,
		"description"	=> $lang->steamgroup_desc,
		"website"				=> "",
		"author"				=> "Krzysztof \"Supryk\" Supryczyński",
		"authorsite"			=> "",
		"version"				=> "2.5",
		"compatibility"		=> "1801,1802,1803,1804,1805,1806",
		"codename"			=> "steam_group",
	);
}

function steamgroup_is_installed()
{
    global $db;
	
	return $db->num_rows($db->simple_select("settinggroups", "*", "name=\"steamgroup\""));
}

function steamgroup_install()
{
	global $db, $lang, $mybb;
	$lang->load("config_steamgroup");
	
	if(!in_array($mybb->version_code, explode("," ,"1801,1802,1803,1804,1805,1806")))
	{
		flash_message($lang->steamgroup_to_old_mybb, "error");
		admin_redirect("index.php?module=config-plugins");
	}
	
	$max_disporder = $db->fetch_field($db->simple_select("settinggroups", "MAX(disporder) AS max_disporder"), "max_disporder");
	
	$settinggroups = array(
		"gid"					=> "NULL",
		"name" 			=> "steamgroup", 
		"title"				=> $db->escape_string($lang->steamgroup_setting),
		"description" 	=> $db->escape_string($lang->steamgroup_setting_desc),
		"disporder" 		=> $max_disporder + 1,
		"isdefault" 		=> "0",
	);
	$gid = $db->insert_query("settinggroups", $settinggroups);
	
	$settings = array();
	
	$settings[] = array(
		"sid"					=> "NULL",
		"name"			=> "steamgroup_onoff",
		"title"				=> $db->escape_string($lang->steamgroup_setting_onoff),
		"description"	=> $db->escape_string($lang->steamgroup_setting_onoff_desc),
		"optionscode"	=> "onoff",
		"value"				=> "1",
		"disporder"		=> "1",
		"gid"					=> $gid,
		"isdefault"			=> "0",
	);
	
	$settings[] = array(
		"sid"					=> "NULL",
		"name"			=> "steamgroup_portal_onoff",
		"title"				=> $db->escape_string($lang->steamgroup_setting_portal_onoff),
		"description"	=> $db->escape_string($lang->steamgroup_setting_portal_onoff_desc),
		"optionscode"	=> "onoff",
		"value"				=> "1",
		"disporder"		=> "2",
		"gid"					=> $gid,
		"isdefault"			=> "0",
	);
	
	$settings[] = array(
		"sid"					=> "NULL",
		"name"			=> "steamgroup_index_onoff",
		"title"				=> $db->escape_string($lang->steamgroup_setting_index_onoff),
		"description"	=> $db->escape_string($lang->steamgroup_setting_index_onoff_desc),
		"optionscode"	=> "onoff",
		"value"				=> "1",
		"disporder"		=> "3",
		"gid"					=> $gid,
		"isdefault"			=> "0",
	);

	$settings[] = array(
		"sid"					=> "NULL",
		"name"			=> "steamgroup_group_name",
		"title"				=> $db->escape_string($lang->steamgroup_setting_group_name),
		"description"	=> $db->escape_string($lang->steamgroup_setting_group_name_desc),
		"optionscode"	=> "text",
		"value"				=> "polish-zone",
		"disporder"		=> "4",
		"gid"					=> $gid,
		"isdefault"			=> "0",
	);
	
	$settings[] = array(
		"sid"					=> "NULL",
		"name"			=> "steamgroup_group_cache_time",
		"title"				=> $db->escape_string($lang->steamgroup_setting_cache_time),
		"description"	=> $db->escape_string($lang->steamgroup_setting_cache_time_desc),
		"optionscode"	=> "numeric",
		"value"				=> "5",
		"disporder"		=> "5",
		"gid"					=> $gid,
		"isdefault"			=> "0",
	);
	
	$db->insert_query_multiple("settings", $settings);
	
	rebuild_settings();
		
	$templates = array();
		
	$templates[] = array(
		"tid" 					=> "NULL",
		"title" 				=> "steamgroup",
		"template" 		=> $db->escape_string('<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
<tr>
<td class="thead" colspan="1">
<strong>{$lang->steamgroup_steamgroup}</strong>
</td>
</tr>
{$tpl[\'row\']}
</table>
<br />'),
		"sid" 				=> "-1",
		"version" 				=> "2.5",
		"status" 				=> "",
		"dateline" 				=> TIME_NOW,
	);
	
	$templates[] = array(
		"tid" 					=> "NULL",
		"title" 				=> "steamgroup_row",
		"template" 		=> $db->escape_string('<tr><td class="trow1">
<img src="{$data[\'avatar\']}" style="float: left;width: 108px;margin-right: 5px;"/>
<b>{$data[\'name\']}</b>{$data[\'shortname\']}<br/>
{$lang->steamgroup_members} {$data[\'members\']}<br/>
{$lang->steamgroup_online} {$data[\'online\']}<br/>
{$lang->steamgroup_ingame} {$data[\'ingame\']}<br/>
{$lang->steamgroup_inchat} {$data[\'inchat\']}<br/>
<a href="http://steamcommunity.com/groups/{$data[\'url\']}">{$lang->steamgroup_viewandjoin}</a> | <a href="steam://friends/joinchat/{$data[\'id\']}">{$lang->steamgroup_chat}</a>
</td></tr>'),
		"sid" 				=> "-1",
		"version" 				=> "2.5",
		"status" 				=> "",
		"dateline" 				=> TIME_NOW,
	);
	
	$templates[] = array(
		"tid" 					=> "NULL",
		"title" 				=> "steamgroup_row_noinformation",
		"template" 		=> $db->escape_string('<tr><td class="trow1" align="center">
{$lang->steamgroup_noinformation}
</td></tr>'),
		"sid" 				=> "-1",
		"version" 				=> "2.5",
		"status" 				=> "",
		"dateline" 				=> TIME_NOW,
	);
	
	$db->insert_query_multiple("templates", $templates);
}

function steamgroup_uninstall()
{
    global $db, $cache;
	
	$db->delete_query("settinggroups", "name = \"steamgroup\"");
	$db->delete_query("settings", "name LIKE \"steamgroup%\"");
	rebuild_settings();
	$db->delete_query("templates", "title LIKE \"steamgroup%\"");
	$cache->delete("steamgroup");
}

function steamgroup_deactivate()
{
    global $cache;
	
	$cache->delete("steamgroup");
}

function steamgroup_end()
{
	global $cache, $lang, $mybb, $templates, $theme, $steamgroup;
	$lang->load("steamgroup");
			
	if($mybb->settings['steamgroup_onoff'] != "1")
	{
		return;
	}
	
	if(THIS_SCRIPT == "portal.php" && $mybb->settings['steamgroup_portal_onoff'] != "1")
	{
		return;
	}
	
	if(THIS_SCRIPT == "index.php" && $mybb->settings['steamgroup_index_onoff'] != "1")
	{
		return;
	}
	
	$tree = $cache->read("steamgroup");
	
	if(empty($tree) || ($mybb->settings['steamgroup_group_cache_time'] * 60) < (TIME_NOW - $tree['time']))
	{
		update_steamgroup();
		$tree = $cache->read("steamgroup");
	}
	
	$data['desc'] = $tree['desc'];
	$data['name'] = $tree['name'];
	$data['avatar'] = $tree['avatar'];
	$data['members'] = $tree['members'];
	$data['inchat'] = $tree['inchat'];
	$data['ingame'] = $tree['ingame'];
	$data['online'] = $tree['online'];
	$data['url'] = $tree['url'];
	$data['id'] = $tree['id'];

	if(!empty($tree))
	{
		eval("\$tpl['row'] = \"" . $templates->get("steamgroup_row") . "\";");
	}
	else
	{
		eval("\$tpl['row'] = \"" . $templates->get("steamgroup_row_noinformation") . "\";");
	}
	
	eval("\$steamgroup = \"".$templates->get("steamgroup")."\";");
}

function update_steamgroup()
{
	global $cache, $mybb;
	
	$contents = fetch_remote_file("http://steamcommunity.com/groups/".$mybb->settings['steamgroup_group_name']."/memberslistxml/?xml=1.xml", $post_data);
	if($contents)
	{
		require_once MYBB_ROOT."inc/class_xml.php";
		$parser = new XMLParser($contents);
		$tree = $parser->get_tree();
		$data = array();
		$data['desc'] = $tree['memberList']['groupDetails']['headline']['value'];
		$data['name'] = $tree['memberList']['groupDetails']['groupName']['value'];	
		$data['avatar'] = $tree['memberList']['groupDetails']['avatarFull']['value'];
		$data['members'] = $tree['memberList']['groupDetails']['memberCount']['value'];
		$data['inchat'] = $tree['memberList']['groupDetails']['membersInChat']['value'];
		$data['ingame'] = $tree['memberList']['groupDetails']['membersInGame']['value'];
		$data['online'] = $tree['memberList']['groupDetails']['membersOnline']['value'];
		$data['url'] = $tree['memberList']['groupDetails']['groupURL']['value'];
		$data['id'] = $tree['memberList']['groupID64']['value'];
		$data['time'] = TIME_NOW;
		$cache->update("steamgroup", $data); 
	}
}

function steamgroup_templatelist()
{
	global $mybb;
	
	if($mybb->settings['steamgroup_onoff'] != '1')
	{
		return;
	}
	
	if(in_array(THIS_SCRIPT, explode("," ,"portal.php")) && $mybb->settings['steamgroup_portal_onoff'] == "1")
	{
		global $templatelist;
	
		if(isset($templatelist))
		{
			$templatelist .= ',';
		}
		
		$templatelist .= "steamgroup,steamgroup_row,steamgroup_row_noinformation";
	}
	
	if(in_array(THIS_SCRIPT, explode("," ,"index.php")) && $mybb->settings['steamgroup_index_onoff'] == "1")
	{
		global $templatelist;
	
		if(isset($templatelist))
		{
			$templatelist .= ',';
		}
		
		$templatelist .= "steamgroup,steamgroup_row,steamgroup_row_noinformation";
	}
}

/********************************************************************************************************************************
*
* Say thanks to plugin author - paste link to author website.
* Please don't remove this code if you didn't make donate.
* It's the only way to say thanks without donate.
*
********************************************************************************************************************************/
function steamgroup_thanks(&$content)
{
    global $session, $thanksSupryk, $lang;
	$lang->load("steamgroup");
        
    if(!isset($thanksSupryk) && $session->is_spider)
    {
        $thx = '<div style="margin:auto; text-align:center;">'.$lang->steamgroup_thanks.'</div></body>';
        $content = str_replace('</body>', $thx, $content);
        $thanksSupryk = true;
    }
}
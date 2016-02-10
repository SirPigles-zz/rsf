<?php

/**
 * Chatwee is a feature-rich social chat platform that provides real-time chatting experience for communities on forums
 *
 * @package MyBB Chat by Chatwee 
 * @version 2.0 Release
 * @date 02.08.2015
 * @author Jakub Kadzielawa <jakub.kadzielawa@chatwee.com> 
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GPL Version 3, 29 June 2007
 */
 
if(!defined('IN_MYBB'))
{
	die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

$plugins->add_hook('pre_output_page','chatweecode');
$plugins->add_hook('member_do_login_end','chatweelogin');
$plugins->add_hook('member_logout_end','chatweelogout');

//global_start
function checksite() {
	
	global $mybb;

	if(!$mybb->user['uid'] && isSet($_COOKIE['chch-SI']) && $mybb->settings['chatweesso_status'])
		chatweelogout();
	
	if($mybb->user['uid'] && !isSet($_COOKIE['chch-SI']) && $mybb->settings['chatweesso_status'])
		chatweelogin();		
}

function chatweelogin() 
{
	global $db, $mybb;
	
	if(!$mybb->settings['chatweesso_status'])
		return;
	
	if($mybb->input)
	{
		$user = validate_password_from_username($mybb->input['username'], $mybb->input['password']);
	}
	
	if(!$user['uid'])
		return; 
	
	$user = get_user($user['uid']);    

	$avatar = 	$user['avatar'] == '' ? '' : $user['avatar'];

	$user_login = $user['username'];
		
	$chatId = $mybb->settings['chatweesso_chatid'];
		
	$clientKey = $mybb->settings['chatweesso_apikey'];
		
	$isAdmin = 0;

	if($user['usergroup'] == 4)
		$isAdmin = 1;

	$ismobile = (check_user_agent('mobile')==true) ? 1 : 0;
		
	$ip = get_the_user_ip();

	if(isSet($_COOKIE["chch-SI"]))
	{
		chatweelogout(); 
	}
	
	if(isSet($_SESSION['chatwee'][$user_login]))
	{
		$previousSessionId = $_SESSION['chatwee'][$user_login];
	}
		
	else if(isSet($_COOKIE["chch-PSI"]))
	{
		$previousSessionId = $_COOKIE["chch-PSI"];
	}		
	else 
	{
		$previousSessionId = null;
	}

	$url = "http://chatwee-api.com/api/remotelogin?chatId=".$chatId."&clientKey=".$clientKey."&login=".$user_login."&isAdmin=".$isAdmin."&ipAddress=".$ip."&avatar=".$avatar."&isMobile=".$ismobile."&previousSessionId=".$previousSessionId;

	$url = str_replace(' ', '%20', $url);	
	
	$response = get_response($url);
			
	$sessionArray = json_decode($response);
		
	if($sessionArray->errorCode) 
	{
		print_R($sessionArray->errorMessage);
	}
		
	$sessionId = $sessionArray->sessionId;
	
	$fullDomain = $_SERVER["HTTP_HOST"];
	
	$isNumericDomain = preg_match('/\d|"."/',$fullDomain);
		
	if($isNumericDomain)
	{
		$CookieDomain = $fullDomain;
	}
	else 
	{
		$hostChunks = explode(".", $fullDomain);

		$hostChunks = array_slice($hostChunks, -2);	

		$CookieDomain = "." . implode(".", $hostChunks);
	}
		
	setcookie("chch-SI", $sessionId, time() + 2592000, "/", $CookieDomain);
		
	$_SESSION['chatwee'][$user_login] = $_SESSION['chatwee'][$user_login] == '' ? $sessionId : $_SESSION['chatwee'][$user_login];		
}

function get_the_user_ip()
{	
	if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
		//check ip from share internet
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
	//to check ip is pass from proxy
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}
	
function check_user_agent($type = NULL)
{	
    $user_agent = strtolower ( $_SERVER['HTTP_USER_AGENT'] );
    if ( $type == 'bot' ) {
        if ( preg_match ( "/googlebot|adsbot|yahooseeker|yahoobot|msnbot|watchmouse|pingdom\.com|feedfetcher-google/", $user_agent ) ) {
            return true;
        }
        } else if ( $type == 'browser' ) {
            if ( preg_match ( "/mozilla\/|opera\//", $user_agent ) ) {
                return true;
            }
        } else if ( $type == 'mobile' ) {
            
             if ( preg_match ( "/phone|iphone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent ) ) {
                   return true;
                } else if ( preg_match ( "/mobile|pda;|avantgo|eudoraweb|minimo|netfront|brew|teleca|lg;|lge |wap;| wap /", $user_agent ) ) {
                   return true;
            }
        }
    return false;
}

function get_response($url) 
{
	$hand = curl_init();
	 
	curl_setopt($hand, CURLOPT_URL, $url);
	
	curl_setopt($hand, CURLOPT_RETURNTRANSFER, 1);
	
	$response = curl_exec($hand);
		 
	curl_close($hand);
		
	return $response;
}


function chatweelogout() 
{
	global $mybb;
	
	$chatId = $mybb->settings['chatweesso_chatid'];
		
	$clientKey = $mybb->settings['chatweesso_apikey'];
		
	$sessionId = $_COOKIE['chch-SI'];
		
	$url = "http://chatwee-api.com/api/remotelogout?chatId=".$chatId."&clientKey=".$clientKey."&sessionId=".$sessionId;
		
	get_response($url);

	$hostChunks = explode(".", $_SERVER["HTTP_HOST"]);

	$hostChunks = array_slice($hostChunks, -2);

	$domain = "." . implode(".", $hostChunks);

	setcookie("chch-SI", "", time() - 1, "/", $domain);
}

function chatweecode_info()
{
	global $lang;
	$lang->load('chatweecode');
	
	return array(
		'name'			=> $lang->chatweecode_plugin_title,
		'description'	=> $lang->chatweecode_description,
		'website'		=> 'https://www.chatwee.com/',
		'author'		=> 'Chatwee Team',
		'authorsite'	=> 'https://www.chatwee.com/',
		'version'		=> '1.0',
		'compatibility' => '14*,16*,17*,18*',
		'guid' 			=> '',
		'codename'      => 'chatweecode'
	);
}

function chatweecode_activate()
{
	global $db, $lang;
	$lang->load('chatweecode');

	$insertarray = array(
		'name' => 'chatweecode',
		'title' => $lang->chatweecode_settings_title,
		'description' => mres($lang->chatweecode_settings_description),
		'disporder' => 35,
		'isdefault' => 0,
	);
	$gid = $db->insert_query("settinggroups", $insertarray);
	
	$insertarray = array(
		'name' => 'chatweecode_status',
		'title' => $lang->chatweecode_settings_status_title,
		'description' => mres($lang->chatweecode_settings_status_description),
		'optionscode' => 'yesno',
		'value' => 'yes',
		'disporder' => 1,
		'isdefault' =>1,
		'gid' => $gid
	);
	$db->insert_query("settings", $insertarray);
	
	$insertarray = array(
		'name' => 'chatweecode_code',
		'title' => $lang->chatweecode_settings_url_title,
		'description' => mres($lang->chatweecode_settings_url_description),
		'optionscode' => 'textarea',
		'value' => '',
		'disporder' => 2,
		'gid' => $gid
	);
	$db->insert_query("settings", $insertarray);
	
	$insertarray = array(
		'name' => 'chatweesso_status',
		'title' => $lang->chatweesso_settings_ssostatus_title,
		'description' => mres($lang->chatweesso_settings_ssostatus_description),
		'optionscode' => 'yesno',
		'value' => '',
		'disporder' => 3,
		'isdefault' =>1,
		'gid' => $gid
	);
	$db->insert_query("settings", $insertarray);
	
	$insertarray = array(
		'name' => 'chatweesso_apikey',
		'title' => $lang->chatweesso_settings_apikey_title,
		'description' => mres($lang->chatweesso_settings_apikey_description),
		'optionscode' => 'text',
		'value' => '',
		'disporder' => 4,
		'gid' => $gid
	);
	$db->insert_query("settings", $insertarray);
	
	$insertarray = array(
		'name' => 'chatweesso_chatid',
		'title' => $lang->chatweesso_settings_chatid_title,
		'description' => mres($lang->chatweesso_settings_chatid_description),
		'optionscode' => 'text',
		'value' => '',
		'disporder' => 5,
		'gid' => $gid
	);
	$db->insert_query("settings", $insertarray);

	rebuild_settings();

}

function mres($value)
{
    $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
    $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");

    return str_replace($search, $replace, $value);
}

function chatweecode_deactivate()
{
	global $db;
	$db->delete_query("settings", "name IN('chatweecode_status','chatweecode_code')");
	$db->delete_query("settinggroups", "name IN('chatweecode')");
}

function chatweecode($page)
{
	global $mybb;
	if($mybb->settings['chatweecode_status'] == 1)
	{
		$page=str_replace("</body>",$mybb->settings['chatweecode_code']."</body>",$page);
	}
	return $page;
}
?>

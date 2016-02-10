<?php
/**
  * Version:            1.1
  * Compatibillity:     MyBB 1.8.x
  * Website:            http://soportemybb.es
  * Autor:              Dark Neo
*/

if(!defined("IN_MYBB")){
    die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

// Enganche para cargar las plantillas a utilizar por el plugin
$plugins->add_hook("global_start", "vars_xstyle_global");

function vars_xstyle_info(){
    global $mybb, $db, $lang;
    
    return array(
        'name'          => 'XSTYLE custom language variables',
        'description'   => 'This plugins loads custom language variables for XSTYLE themes.',
        'website'       => 'http://xstyle.xyz/',
        'author'        => 'Dark Neo',
        'authorsite'    => 'http://soportemybb.es',
        'version'       => '1.1',
        'guid'          => '',  // This value dissapear on 1.8
        'codename'      => '',
        'compatibility' => '18*'
    );
}

function vars_xstyle_activate(){
}

function vars_xstyle_deactivate(){
}

function vars_xstyle_global(){
    global $mybb, $lang;

    if(file_exists($lang->path."/".$lang->language."/vars_xstyle.lang.php"))
    {
        $lang->load("vars_xstyle");
    }
    else if(file_exists($lang->path."/english/vars_xstyle.lang.php"))
    {
        $lang->load("vars_xstyle");
    }
    else{
        return false;
    }   
}
?>
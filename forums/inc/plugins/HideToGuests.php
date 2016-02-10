<?php
/*
 *
 * Hide To Guests Plugin 0.3.1 Release
 * Mariusz "marines" Kujawski <marinespl@gmail.com>
 * MyBB Site: http://mybbsite.pl/
 * Marines Blog: http://marines.jogger.pl/
 *
 */

// Disallow direct access to this file for security reasons
if(!defined('IN_MYBB')) die('Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.');

$plugins->add_hook('showthread_end', 'HideToGuests_post');
$plugins->add_hook('archive_thread_post', 'HideToGuests_archive');
$plugins->add_hook('newreply_end', 'HideToGuests_reply');
$plugins->add_hook('editpost_end', 'HideToGuests_reply');
$plugins->add_hook('xmlhttp', 'HideToGuests_xmlhttp_edit');
$plugins->add_hook('xmlhttp', 'HideToGuests_xmlhttp_multiquote');


function HideToGuests_info()
{
	return array(
		'name'				=> 'Hide To Guests',
		'description'		=> 'Plugin hides content from unwanted groups by putting it in specified tag.',
		'website'			=> 'http://marines.jogger.pl',
		'author'			=> 'Mariusz Kujawski',
		'authorsite'		=> 'http://marines.jogger.pl',
		'version'			=> '0.3.1',
		'guid'				=> '22ef3731adba0100608c3c3c73dc7e9f',
		'compatibility' 	=> '18*',
	);
}

function HideToGuests_activate()
{
	global $db, $mybb;

	$group = array(
		'gid'			=> 'NULL',
		'name'			=> 'htg',
		'title'			=> 'Hide To Guests',
		'description'	=> 'Hide content from specified usergroups.',
		'disporder'		=> '40',
		'isdefault'		=> 'no',
	);
	$db->insert_query('settinggroups', $group);
	$gid = $db->insert_id();

    $setting = array(
        'sid'			=> 'NULL',
        'name'			=> 'htg_enabled',
        'title'			=> 'Enable?',
        'description'	=> 'Please decide whether plugin should do its job.',
        'optionscode'	=> 'yesno',
        'value'			=> 'no',
        'disporder'		=> '1',
        'gid'			=> intval($gid),
        );
    $db->insert_query('settings', $setting);

	$setting = array(
        'sid'			=> 'NULL',
        'name'			=> 'htg_groups',
        'title'			=> 'Groups you would like to have the content hidden from.',
        'description'	=> 'Please enter a comma separated list of groups.',
        'optionscode'	=> 'text',
        'value'			=> '1',
        'disporder'		=> '2',
        'gid'			=> intval($gid),
        );
    $db->insert_query('settings', $setting);

	$setting = array(
        'sid'			=> 'NULL',
        'name'			=> 'htg_text',
        'title'			=> 'Replacement',
        'description'	=> 'Please enter the text you would like to be displayed instead of the content you would like to hide.',
        'optionscode'	=> 'textarea',
        'value'			=> 'Hidden Content',
        'disporder'		=> '3',
        'gid'			=> intval($gid),
        );
    $db->insert_query('settings', $setting);

    $setting = array(
        'sid'			=> 'NULL',
        'name'			=> 'htg_tag',
        'title'			=> 'Tag',
        'description'	=> 'Please enter the tag you would like to use to hide content (without braces). <strong style="color:red">CAUTION!</strong> Remember that when you change the tag all currently used tags meant to hide content <strong>will not work!</strong>',
        'optionscode'	=> 'text',
        'value'			=> 'hide',
        'disporder'		=> '4',
        'gid'			=> intval($gid),
        );
    $db->insert_query('settings', $setting);

    $setting = array(
        'sid'			=> 'NULL',
        'name'			=> 'htg_class',
        'title'			=> 'Class',
        'description'	=> 'Please enter CSS class name you would like to give to the <em>span</em> tag which will contain replacement text.',
        'optionscode'	=> 'text',
        'value'			=> 'hide',
        'disporder'		=> '5',
        'gid'			=> intval($gid),
        );
    $db->insert_query('settings', $setting);

    $setting = array(
        'sid'			=> 'NULL',
        'name'			=> 'htg_removal',
        'title'			=> 'Remove tag in reply',
        'description'	=> 'Please decide whether hide tag should be removed from reply form of user which is member of one of groups above.',
        'optionscode'	=> 'yesno',
        'value'			=> 'yes',
        'disporder'		=> '6',
        'gid'			=> intval($gid),
        );
    $db->insert_query('settings', $setting);

	rebuild_settings();
}

function HideToGuests_deactivate()
{
	global $db, $mybb;

	$db->delete_query('settings', 'name IN("htg_groups", "htg_text", "htg_tag", "htg_class", "htg_removal", "htg_enabled")');
	$db->delete_query('settinggroups', 'name = "htg"');

	rebuild_settings();
}

function HideToGuests_post()
{
	global $mybb, $posts;

    if ($mybb->settings['htg_enabled'] == 1)
    {
        $hidden = false;

        // prepare array of user's groups
        $groups = explode(',', $mybb->user['additionalgroups']);
        array_push($groups, $mybb->user['usergroup']);

        // groups to hide to
        $hide_to = explode(',', $mybb->settings['htg_groups']);

        // parse message until tag is hidden
        while (!$hidden && !empty($groups))
        {
            // if user's group is in groups to hide content to hide tag
            // and set visibility indicator to true
            if (in_array(array_pop($groups), $hide_to))
            {
                $hidden = true;
                $posts = preg_replace('#\['.$mybb->settings['htg_tag'].'\](.*?)\[/'.$mybb->settings['htg_tag'].'\]#s', '<span class="'.$mybb->settings['htg_class'].'">'.$mybb->settings['htg_text'].'</span>', $posts);
            }
        }
    }

    // remove hide tag for regular user
    if (!$hidden)
        $posts = preg_replace('#\['.$mybb->settings['htg_tag'].'\](.*?)\[/'.$mybb->settings['htg_tag'].'\]#s', '$1', $posts);

	return;
}

function HideToGuests_archive()
{
  global $mybb, $post;

    if ($mybb->settings['htg_enabled'] == 1)
    {
        $hidden = false;

        // prepare array of user's groups
        $groups = explode(',', $mybb->user['additionalgroups']);
        array_push($groups, $mybb->user['usergroup']);

        // groups to hide to
        $hide_to = explode(',', $mybb->settings['htg_groups']);

        // parse message until tag is hidden
        while (!$hidden && !empty($groups))
        {
            // if user's group is in groups to hide content to hide tag
            // and set visibility indicator to true
            if (in_array(array_pop($groups), $hide_to))
            {
                $hidden = true;
                $post['message'] = preg_replace('#\['.$mybb->settings['htg_tag'].'\](.*?)\[/'.$mybb->settings['htg_tag'].'\]#s', '<span class="'.$mybb->settings['htg_class'].'">'.$mybb->settings['htg_text'].'</span>', $post['message']);
            }
        }
    }

    // remove hide tag for regular user
    if (!$hidden)
        $post['message'] = preg_replace('#\['.$mybb->settings['htg_tag'].'\](.*?)\[/'.$mybb->settings['htg_tag'].'\]#s', '$1', $post['message']);

	return;
}

function HideToGuests_reply()
{
	global $mybb, $message;

    if ($mybb->settings['htg_enabled'] == 1)
    {
        $hidden = false;

        // prepare array of user's groups
        $groups = explode(',', $mybb->user['additionalgroups']);
        array_push($groups, $mybb->user['usergroup']);

        // groups to hide to
        $hide_to = explode(',', $mybb->settings['htg_groups']);

        // parse message until tag is hidden
        while (!$hidden && !empty($groups))
        {
            // if user's group is in groups to hide content to hide tag
            // and set visibility indicator to true
            if (in_array(array_pop($groups), $hide_to))
            {
                $hidden = true;

                if ($mybb->settings['htg_removal'] == 1)
                    $message = preg_replace('#\['.$mybb->settings['htg_tag'].'\](.*?)\[/'.$mybb->settings['htg_tag'].'\]#s', '', $message);
                else
                    $message = preg_replace('#\['.$mybb->settings['htg_tag'].'\](.*?)\[/'.$mybb->settings['htg_tag'].'\]#s', $mybb->settings['htg_text'], $message);
            }
        }
    }

	return;
}

/*
 * Function content copied from xmlhttp.php file from
 * original MyBB 1.6 package (3 August 2010) modified
 * for plugin matters.
 */
function HideToGuests_xmlhttp_edit()
{
    global $mybb, $templates, $lang;

    if($mybb->settings['htg_enabled'] == 1 && $mybb->input['action'] == "edit_post" && $mybb->input['do'] == "get_post")
    {
        // Fetch the post from the database.
        $post = get_post($mybb->input['pid']);

        // No result, die.
        if(!$post['pid'])
            xmlhttp_error($lang->post_doesnt_exist);

        // Fetch the thread associated with this post.
        $thread = get_thread($post['tid']);

        // Fetch the specific forum this thread/post is in.
        $forum = get_forum($thread['fid']);

        // Missing thread, invalid forum? Error.
        if(!$thread['tid'] || !$forum['fid'] || $forum['type'] != "f")
            xmlhttp_error($lang->thread_doesnt_exist);

        // Fetch forum permissions.
        $forumpermissions = forum_permissions($forum['fid']);

        // If this user is not a moderator with "caneditposts" permissions.
        if(!is_moderator($forum['fid'], "caneditposts"))
        {
            // Thread is closed - no editing allowed.
            if($thread['closed'] == 1)
                xmlhttp_error($lang->thread_closed_edit_message);

            // Forum is not open, user doesn't have permission to edit, or author doesn't match this user - don't allow editing.
            else if($forum['open'] == 0 || $forumpermissions['caneditposts'] == 0 || $mybb->user['uid'] != $post['uid'] || $mybb->user['uid'] == 0 || $mybb->user['suspendposting'] == 1)
                xmlhttp_error($lang->no_permission_edit_post);

            // If we're past the edit time limit - don't allow editing.
            else if($mybb->settings['edittimelimit'] != 0 && $post['dateline'] < (TIME_NOW-($mybb->settings['edittimelimit']*60)))
            {
                $lang->edit_time_limit = $lang->sprintf($lang->edit_time_limit, $mybb->settings['edittimelimit']);
                xmlhttp_error($lang->edit_time_limit);
            }
        }

        // Forum is closed - no editing allowed (for anyone)
        if($forum['open'] == 0)
            xmlhttp_error($lang->no_permission_edit_post);

        // Send our headers.
        header("Content-type: text/xml; charset={$charset}");

        // HTG Code
        $hidden = false;

        // prepare array of user's groups
        $groups = explode(',', $mybb->user['additionalgroups']);
        array_push($groups, $mybb->user['usergroup']);

        // groups to hide to
        $hide_to = explode(',', $mybb->settings['htg_groups']);

        // parse message until tag is hidden
        while (!$hidden && !empty($groups))
        {
            // if user's group is in groups to hide content to hide tag
            // and set visibility indicator to true
            if (in_array(array_pop($groups), $hide_to))
            {
                $hidden = true;

                if ($mybb->settings['htg_removal'] == 1)
                    $post['message'] = preg_replace('#\['.$mybb->settings['htg_tag'].'\](.*?)\[/'.$mybb->settings['htg_tag'].'\]#s', '', $post['message']);
                else
                    $post['message'] = preg_replace('#\['.$mybb->settings['htg_tag'].'\](.*?)\[/'.$mybb->settings['htg_tag'].'\]#s', $mybb->settings['htg_text'], $post['message']);
            }
        }
        // HTG Code END

        $post['message'] = htmlspecialchars_uni($post['message']);

        // Send the contents of the post.
        eval("\$inline_editor = \"".$templates->get("xmlhttp_inline_post_editor")."\";");
        echo "<?xml version=\"1.0\" encoding=\"{$charset}\"?".">";
        echo "<form>".$inline_editor."</form>";
        exit;
    }
}

/*
 * Function content copied from xmlhttp.php file from
 * original MyBB 1.6 package (3 August 2010) modified
 * for plugin matters.
 */
function HideToGuests_xmlhttp_multiquote()
{
    global $mybb, $db;

    if($mybb->settings['htg_enabled'] == 1 && $mybb->input['action'] == "get_multiquoted")
    {
        // If the cookie does not exist, exit
        if(!array_key_exists("multiquote", $mybb->cookies))
            exit;

        // Divide up the cookie using our delimeter
        $multiquoted = explode("|", $mybb->cookies['multiquote']);

        // No values - exit
        if(!is_array($multiquoted))
            exit;

        // Loop through each post ID and sanitize it before querying
        foreach($multiquoted as $post)
            $quoted_posts[$post] = intval($post);

        // Join the post IDs back together
        $quoted_posts = implode(",", $quoted_posts);

        // Fetch unviewable forums
        $unviewable_forums = get_unviewable_forums();
        if($unviewable_forums)
            $unviewable_forums = "AND t.fid NOT IN ({$unviewable_forums})";

        $message = '';

        // Are we loading all quoted posts or only those not in the current thread?
        if(!$mybb->input['load_all'])
            $from_tid = "p.tid != '".intval($mybb->input['tid'])."' AND ";
        else
            $from_tid = '';

        require_once MYBB_ROOT."inc/class_parser.php";
        $parser = new postParser;

        require_once MYBB_ROOT."inc/functions_posting.php";

        // Query for any posts in the list which are not within the specified thread
        $query = $db->query("
            SELECT p.subject, p.message, p.pid, p.tid, p.username, p.dateline, t.fid, p.visible, u.username AS userusername
            FROM ".TABLE_PREFIX."posts p
            LEFT JOIN ".TABLE_PREFIX."threads t ON (t.tid=p.tid)
            LEFT JOIN ".TABLE_PREFIX."users u ON (u.uid=p.uid)
            WHERE {$from_tid}p.pid IN ($quoted_posts) {$unviewable_forums}
        ");

        while($quoted_post = $db->fetch_array($query))
        {
            if(!is_moderator($quoted_post['fid']) && $quoted_post['visible'] == 0)
                continue;

            $message .= parse_quoted_message($quoted_post, false);
        }

        if($mybb->settings['maxquotedepth'] != '0')
            $message = remove_message_quotes($message);

        // Send our headers.
        header("Content-type: text/plain; charset={$charset}");

        // HTG Code
        $hidden = false;

        // prepare array of user's groups
        $groups = explode(',', $mybb->user['additionalgroups']);
        array_push($groups, $mybb->user['usergroup']);

        // groups to hide to
        $hide_to = explode(',', $mybb->settings['htg_groups']);

        // parse message until tag is hidden
        while (!$hidden && !empty($groups))
        {
            // if user's group is in groups to hide content to hide tag
            // and set visibility indicator to true
            if (in_array(array_pop($groups), $hide_to))
            {
                $hidden = true;

                if ($mybb->settings['htg_removal'] == 1)
                    $message = preg_replace('#\['.$mybb->settings['htg_tag'].'\](.*?)\[/'.$mybb->settings['htg_tag'].'\]#s', '', $message);
                else
                    $message = preg_replace('#\['.$mybb->settings['htg_tag'].'\](.*?)\[/'.$mybb->settings['htg_tag'].'\]#s', $mybb->settings['htg_text'], $message);
            }
        }
        // HTG Code END

        echo $message;
        exit;
    }
}
// EOF
?>

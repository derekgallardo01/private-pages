<?php
add_action('wp', 'checkAccess');
function checkAccess()
{
	$isPrivatePage = isPrivatePage();
	$userLoged = is_user_logged_in();
	if($isPrivatePage AND !$userLoged)
	{
		$loginUrl = wp_login_url( get_permalink());
		header( 'Location:'.$loginUrl );
	}
	else
	{
		$userHasPrivilege = userHasPrivilege();
		if($isPrivatePage AND $userLoged AND !$userHasPrivilege) {
			$message = '<span class="private_page_error">'.__('Sorry, you have no privileges to see this content','pp').'</span>';
			replaceContent($message);
		}
	}
}

function replaceContent($message){
	global $post;
	$post->post_content = $message;
}

function isPrivatePage()
{
	$return = false;
	if(is_page())
	{
		$privatePages = get_option('private-pages-selected-pages', array());
		global $post;
		if(in_array($post->post_name, $privatePages))
		$return = true;
	}
	
	return $return;
}

function userHasPrivilege()
{
	if(!is_user_logged_in())
	{
		return false;
	}
	$return = false;
	$alowedRoles = get_option('private-pages-allowed-roles', array());
	global $current_user, $wpdb;
	$role = $wpdb->prefix . 'capabilities';
	$current_user->role = array_keys($current_user->$role);
	$role = $current_user->role[0];

	if(in_array($role, $alowedRoles))
	{
		$return = true;
	}
	if($role == "administrator")
	{
		$return = true;
	}
	return $return;
}
?>
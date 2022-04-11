<?php

add_action('admin_menu','addMenu');
function addMenu()
{
	add_menu_page('Private Pages', __('Private Pages','pp'), '10', 'page_selection', 'pageSelectionSetup');
	add_submenu_page( 'page_selection', 'Private Pages', __('Select Pages','pp'), '10', 'page_selection', 'pageSelectionSetup');
	add_submenu_page( 'page_selection', 'Private Pages', __('User Options','pp'), '10', 'user_options', 'userOptionsSetup');
}

function userOptionsSetup()
{
	$return = '<h3 class="pp-config-message">'.__('Select user roles, allowed to see private pages','pp').':</h3>';
	$return .= updateUserOptions();
	$return .= '<form class="options-form" method="post" action="">';
	$return .= '<ul class="roles_list">';
	$WPRoles = new WP_roles();

	$roles = $WPRoles->get_names();
	unset($roles['administrator']);
	$allowedRoles = get_option('private-pages-allowed-roles', array());
	foreach($roles as $key => $value)
	{
		$return .= '<li>';
		$return .= getCheckBox($key, $value, $allowedRoles);
		$return .= '</li>';
	}
	$return .= '</ul>';
	$return .= '<input type="hidden" value="roles_sent" name="roles_sent">';
	$return .= '<input class="pp-submit" type="submit" value="'.__('Save','pp').'">';
	$return .= "</form>";
	echo $return;
}

function getCheckBox($key, $name, $checkedList)
{
	$checked = "";
	
	if(in_array($key, $checkedList))
	{
		$checked = "checked";
	}
	return '<input type="checkbox" name="'.$key.'" value="'.$key.'" '.$checked.'> '.$name;
}

function updateUserOptions()
{
	if(!isset($_POST["roles_sent"]))
	{
		return "";
	}
	$allowedRoles = array();
	$WPRoles = new WP_roles();
	$roles = $WPRoles->get_names();
	foreach($_POST as $roleKey => $roleValue)
	{
		if(in_array($roleKey, $roles));
		array_push($allowedRoles, $roleKey);
	}
	update_option('private-pages-allowed-roles', $allowedRoles);
	return __('Changes Saved','pp')."<hr/>";
}

function updateSelectedPages()
{
	if(!isset($_POST["pages_sent"]))
	{
		return "";
	}
	$selectedPages = array();
	
	
	foreach($_POST as $pageKey => $pageName)
	{
		array_push($selectedPages, $pageKey);
	}
	update_option('private-pages-selected-pages', $selectedPages);
	return __('Changes Saved','pp')."<hr/>";
}

function pageSelectionSetup()
{
	$return = '<h3 class="pp-config-message">'.__('Select private pages','pp').':</h3>';
	$return .= 	updateSelectedPages();
	$return .= '<form class="options-form" method="post" action="">';
	$return .= '<ul class="roles_list">';
	

	$pages = get_pages(array('post_type' => 'page','post_status' => 'publish'));
	
	$selectedPages = get_option('private-pages-selected-pages', array());
	foreach($pages as $onePage)
	{
		$return .= '<li>';
		$return .= getCheckBox($onePage->post_name, $onePage->post_title, $selectedPages);
		$return .= '</li>';
	}
	$return .= '</ul>';
	$return .= '<input type="hidden" value="pages_sent" name="pages_sent">';
	$return .= '<input class="pp-submit" type="submit" value="'.__('Save','pp').'">';
	$return .= "</form>";
	echo $return;

}
?>
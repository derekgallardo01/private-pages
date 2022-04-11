<?php
/*
	Plugin Name:	Private Pages
	Description:	A plugin to privatize pages only for selected users.
	Author:			Alberto Casado
	Version:		1
	Changes:		
	Author URI:		http://www.codebox.es
*/

/*  Copyright 2011 Alberto Casado  (email : alberto@codebox.es)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_option( "private-pages-allowed-roles", array('editor', 'author'), '', 'no' );
add_option( "private-pages-selected-pages", array(), '', 'no' );
load_plugin_textdomain('pp',false, dirname( plugin_basename( __FILE__ ) ) . '/lang/');
add_action( 'wp_print_styles', 'enqueue_my_styles' );
add_action( 'admin_print_styles', 'enqueue_my_styles' );
function enqueue_my_styles()
{
	wp_enqueue_style('private-pages-css', plugins_url() .'/'.dirname( plugin_basename( __FILE__ ) ) .'/css/style.css');
}
	
if( is_admin() ) 
{	
	require_once( 'wp-private-pages_admin.php' );
}
else
{
	require_once( 'wp-private-pages_public.php');
}

?>

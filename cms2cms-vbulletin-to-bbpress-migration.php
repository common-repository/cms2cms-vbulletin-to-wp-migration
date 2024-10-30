<?php
/*
    Plugin Name: CMS2CMS vBulletin to WordPress migration
    Plugin URI: http://www.cms2cms.com
    Description: Plugin for automated data migration from vBulletin to WordPress. Convert vBulletin to WordPress easily and fast.
    Version: 3.7.0
    Author: CMS2CMS
    Author URI: https://cms2cms.com/
    License: GPLv2
*/
/*  Copyright 2013  MagneticOne  (email : contact@magneticone.com)

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

include_once 'includes/cms2cms-functions.php';
include_once 'includes/cms2cms-bridge-loader.php';

define( 'CMS2CMS_VBULL_VERSION', '3.7.0' );

/* ****************************************************** */

function cms2cms_vBulletin_plugin_menu() {
    $viewProvider = new CmsPluginFunctionsvBulletin();
    add_plugins_page(
        $viewProvider->getPluginNameLong(),
        $viewProvider->getPluginNameShort(),
        'activate_plugins',
        'cms2cms-vBulletin-migration',
        'cms2cms_vBulletin_menu_page'
    );
}
add_action('admin_menu', 'cms2cms_vBulletin_plugin_menu');

function cms2cms_vBulletin_menu_page(){
	include 'includes/cms2cms-view.php';
}

function cms2cms_vBulletin_plugin_init() {
    load_plugin_textdomain( 'cms2cms-vBulletin-migration', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action('plugins_loaded', 'cms2cms_vBulletin_plugin_init');

function cms2cms_vBulletin_install() {
    $dataProvider = new CmsPluginFunctionsvBulletin();
}
register_activation_hook( __FILE__, 'cms2cms_vBulletin_install' );

/* ******************************************************* */
/* AJAX */
/* ******************************************************* */

/**
 * Save Access key and email
 */
function cms2cms_vBulletin_save_options() {
    $dataProvider = new CmsPluginFunctionsvBulletin();
    $response = $dataProvider->saveOptions();

    echo json_encode($response);
    die(); // this is required to return a proper result
}
add_action('wp_ajax_cms2cms_vBulletin_save_options', 'cms2cms_vBulletin_save_options');

/**
 * Get auth string
 */

function cms2cms_vBulletin_get_options() {
    $dataProvider = new CmsPluginFunctionsvBulletin();
    $response = $dataProvider->getOptions();

    echo json_encode($response);
    die(); // this is required to return a proper result
}
add_action('wp_ajax_cms2cms_vBulletin_get_options', 'cms2cms_vBulletin_get_options');


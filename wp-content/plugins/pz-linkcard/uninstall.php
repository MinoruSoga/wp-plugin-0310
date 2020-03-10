<?php if (!defined('ABSPATH') || !defined('WP_UNINSTALL_PLUGIN')) exit(); ?>
<?php

$slug			= basename(dirname(__FILE__));
$wp_upload_dir	= wp_upload_dir();
$css_dir		= $wp_upload_dir['basedir'].'/'.$slug;
$css_path1		= $css_dir.'/style.css';
$css_path2		= $css_dir.'/'.$slug.'-style.css';

// Delete options
delete_option('Pz_LinkCard_options');

// Delect CSS
if (file_exists($css_path1))	unlink ($css_path1);
if (file_exists($css_path2))	unlink ($css_path2);
if (file_exists($css_dir))		rmdir  ($css_dir);

// Drop DB-table
global $wpdb;
$sql = "DROP TABLE ".$wpdb->prefix.'pz_linkcard';
$wpdb->query($sql);

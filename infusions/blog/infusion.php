<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) PHP-Fusion Inc
| https://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
| Author: J.Falk (Domi)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) {
	die("Access Denied");
}
include LOCALE.LOCALESET."setup.php";
// Infusion general information
$inf_title = $locale['blog']['title'];
$inf_description = $locale['blog']['description'];
$inf_version = "1.00";
$inf_developer = "PHP Fusion Development Team";
$inf_email = "";
$inf_weburl = "https://www.php-fusion.co.uk";
$inf_folder = "blog";
// Multilanguage table for Administration
$inf_mlt[] = array(
	"title" => $locale['blog']['title'],
	"rights" => "BL",
);
// Create tables
$inf_newtable[] = DB_BLOG." (
	blog_id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
	blog_subject VARCHAR(200) NOT NULL DEFAULT '',
	blog_image VARCHAR(100) NOT NULL DEFAULT '',
	blog_image_t1 VARCHAR(100) NOT NULL DEFAULT '',
	blog_image_t2 VARCHAR(100) NOT NULL DEFAULT '',
	blog_ialign VARCHAR(15) NOT NULL DEFAULT '',
	blog_cat TEXT NOT NULL,
	blog_blog TEXT NOT NULL,
	blog_extended TEXT NOT NULL,
	blog_keywords VARCHAR(250) NOT NULL DEFAULT '',
	blog_breaks CHAR(1) NOT NULL DEFAULT '',
	blog_name MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '1',
	blog_datestamp INT(10) UNSIGNED NOT NULL DEFAULT '0',
	blog_start INT(10) UNSIGNED NOT NULL DEFAULT '0',
	blog_end INT(10) UNSIGNED NOT NULL DEFAULT '0',
	blog_visibility TINYINT(4) NOT NULL DEFAULT '0',
	blog_reads INT(10) UNSIGNED NOT NULL DEFAULT '0',
	blog_draft TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	blog_sticky TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	blog_allow_comments TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
	blog_allow_ratings TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
	blog_language VARCHAR(50) NOT NULL DEFAULT '".LANGUAGE."',
	PRIMARY KEY (blog_id),
	KEY blog_datestamp (blog_datestamp),
	KEY blog_reads (blog_reads)
) ENGINE=MyISAM DEFAULT CHARSET=UTF8 COLLATE=utf8_unicode_ci";
$inf_newtable[] = DB_BLOG_CATS." (
	blog_cat_id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
	blog_cat_parent MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
	blog_cat_name VARCHAR(100) NOT NULL DEFAULT '',
	blog_cat_image VARCHAR(100) NOT NULL DEFAULT '',
	blog_cat_language VARCHAR(50) NOT NULL DEFAULT '".LANGUAGE."',
	PRIMARY KEY (blog_cat_id)
) ENGINE=MyISAM DEFAULT CHARSET=UTF8 COLLATE=utf8_unicode_ci";
// Automatic enable the archives panel
$inf_insertdbrow[] = DB_PANELS." (panel_name, panel_filename, panel_content, panel_side, panel_order, panel_type, panel_access, panel_display, panel_status, panel_url_list, panel_restriction) VALUES('Blog archive panel', 'blog_archive_panel', '', '1', '5', 'file', '0', '0', '1', '', '')";
// Position these links under Content Administration
$inf_adminpanel[] = array(
	"image" => "blog.png",
	"page" => 1,
	"rights" => "BLOG",
	"title" => $locale['setup_3055'],
	"panel" => INFUSIONS."blog/blog_admin.php",
);

// Insert settings
$inf_insertdbrow[] = DB_SETTINGS_INF." (settings_name, settings_value, settings_inf) VALUES('blog_image_readmore', '0', 'blog')";
$inf_insertdbrow[4] = DB_SETTINGS_INF." (settings_name, settings_value, settings_inf) VALUES('blog_thumb_ratio', '0', 'blog')";
$inf_insertdbrow[5] = DB_SETTINGS_INF." (settings_name, settings_value, settings_inf) VALUES('blog_image_link', '1', 'blog')";
$inf_insertdbrow[6] = DB_SETTINGS_INF." (settings_name, settings_value, settings_inf) VALUES('blog_photo_w', '400', 'blog')";
$inf_insertdbrow[7] = DB_SETTINGS_INF." (settings_name, settings_value, settings_inf) VALUES('blog_photo_h', '300', 'blog')";
$inf_insertdbrow[8] = DB_SETTINGS_INF." (settings_name, settings_value, settings_inf) VALUES('blog_thumb_w', '100', 'blog')";
$inf_insertdbrow[9] = DB_SETTINGS_INF." (settings_name, settings_value, settings_inf) VALUES('blog_thumb_h', '100', 'blog')";
$inf_insertdbrow[10] = DB_SETTINGS_INF." (settings_name, settings_value, settings_inf) VALUES('blog_photo_max_w', '1800', 'blog')";
$inf_insertdbrow[11] = DB_SETTINGS_INF." (settings_name, settings_value, settings_inf) VALUES('blog_photo_max_h', '1600', 'blog')";
$inf_insertdbrow[12] = DB_SETTINGS_INF." (settings_name, settings_value, settings_inf) VALUES('blog_photo_max_b', '150000', 'blog')";
$inf_insertdbrow[13] = DB_SETTINGS_INF." (settings_name, settings_value, settings_inf) VALUES('blog_pagination', '12', 'blog')";
$inf_insertdbrow[14] = DB_SETTINGS_INF." (settings_name, settings_value, settings_inf) VALUES('blog_allow_submission', '1', 'blog')";
$inf_insertdbrow[15] = DB_SETTINGS_INF." (settings_name, settings_value, settings_inf) VALUES('blog_allow_submission_files', '1', 'blog')";
$inf_insertdbrow[16] = DB_SETTINGS_INF." (settings_name, settings_value, settings_inf) VALUES('blog_extended_required', '0', 'blog')";

// always find and loop ALL languages
$enabled_languages = makefilelist(LOCALE, ".|..", TRUE, "folders");
// Create a link for all installed languages
if (!empty($enabled_languages)) {
	foreach($enabled_languages as $language) {
		include LOCALE.$language."/setup.php";
		// add new language records
		$mlt_insertdbrow[$language][] = DB_SITE_LINKS." (link_name, link_url, link_visibility, link_position, link_window, link_order, link_language) VALUES ('".$locale['setup_3055']."', 'infusions/blog/blog.php', '0', '2', '0', '2', '".$language."')";
		$mlt_insertdbrow[$language][] = DB_SITE_LINKS." (link_name, link_url, link_visibility, link_position, link_window, link_order, link_language) VALUES ('".$locale['setup_3317']."', 'submit.php?stype=b', ".USER_LEVEL_MEMBER.", '1', '0', '14', '".$language."')";
		$mlt_insertdbrow[$language][] = DB_BLOG_CATS." (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3500']."', 'bugs.gif', '".$language."')";
		$mlt_insertdbrow[$language][] = DB_BLOG_CATS." (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3501']."', 'downloads.gif', '".$language."')";
		$mlt_insertdbrow[$language][] = DB_BLOG_CATS." (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3502']."', 'games.gif', '".$language."')";
		$mlt_insertdbrow[$language][] = DB_BLOG_CATS." (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3503']."', 'graphics.gif', '".$language."')";
		$mlt_insertdbrow[$language][] = DB_BLOG_CATS." (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3504']."', 'hardware.gif', '".$language."')";
		$mlt_insertdbrow[$language][] = DB_BLOG_CATS." (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3505']."', 'journal.gif', '".$language."')";
		$mlt_insertdbrow[$language][] = DB_BLOG_CATS." (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3506']."', 'members.gif', '".$language."')";
		$mlt_insertdbrow[$language][] = DB_BLOG_CATS." (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3507']."', 'mods.gif', '".$language."')";
		$mlt_insertdbrow[$language][] = DB_BLOG_CATS." (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3509']."', 'network.gif', '".$language."')";
		$mlt_insertdbrow[$language][] = DB_BLOG_CATS." (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3510']."', 'news.gif', '".$language."')";
		$mlt_insertdbrow[$language][] = DB_BLOG_CATS." (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3511']."', 'php-fusion.gif', '".$language."')";
		$mlt_insertdbrow[$language][] = DB_BLOG_CATS." (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3512']."', 'security.gif', '".$language."')";
		$mlt_insertdbrow[$language][] = DB_BLOG_CATS." (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3513']."', 'software.gif', '".$language."')";
		$mlt_insertdbrow[$language][] = DB_BLOG_CATS." (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3514']."', 'themes.gif', '".$language."')";
		$mlt_insertdbrow[$language][] = DB_BLOG_CATS." (blog_cat_name, blog_cat_image, blog_cat_language) VALUES ('".$locale['setup_3515']."', 'windows.gif', '".$language."')";

		// drop deprecated language records
		$mlt_deldbrow[$language][] = DB_SITE_LINKS." WHERE link_url='infusions/news/news.php' AND link_language='".$language."'";
		$mlt_deldbrow[$language][] = DB_SITE_LINKS." WHERE link_url='submit.php?stype=n' AND link_language='".$language."'";
		$mlt_deldbrow[$language][] = DB_BLOG_CATS." WHERE blog_cat_language='".$language."'";
		$mlt_deldbrow[$language][] = DB_BLOG." WHERE blog_language='".$language."'";
	}
} else {
	$inf_insertdbrow[] = DB_SITE_LINKS." (link_name, link_url, link_visibility, link_position, link_window, link_order, link_language) VALUES('".$locale['setup_3055']."', 'infusions/blog/blog.php', '0', '2', '0', '2', '".LANGUAGE."')";
	$inf_insertdbrow[] = DB_SITE_LINKS." (link_name, link_url, link_visibility, link_position, link_window, link_order, link_language) VALUES ('".$locale['setup_3317']."', 'submit.php?stype=b', ".USER_LEVEL_MEMBER.", '1', '0', '14', '".LANGUAGE."')";
}

// Defuse cleanup
$inf_droptable[] = DB_BLOG;
$inf_droptable[] = DB_BLOG_CATS;

$inf_deldbrow[] = DB_COMMENTS." WHERE comment_type='B'";
$inf_deldbrow[] = DB_RATINGS." WHERE rating_type='B'";
$inf_deldbrow[] = DB_SUBMISSIONS." WHERE submit_type='B'";
$inf_deldbrow[] = DB_PANELS." WHERE panel_name='".$locale['setup_3318']."'";
$inf_deldbrow[] = DB_ADMIN." WHERE admin_rights='BLOG'";
$inf_deldbrow[] = DB_SETTINGS_INF." WHERE settings_inf='blog'";
$inf_deldbrow[] = DB_SITE_LINKS." WHERE link_url='infusions/blog/blog.php'";
$inf_deldbrow[] = DB_SITE_LINKS." WHERE link_url='submit.php?stype=b'";
$inf_deldbrow[] = DB_LANGUAGE_TABLES." WHERE mlt_rights='BL'";
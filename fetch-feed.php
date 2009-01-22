<?php
/*
Plugin Name: Fetch Feed
Plugin URI: http://jrtashjian.com/?p=55
Description: Fetches and Caches an RSS feed for display
Version: 1.0
Author: JR Tashjian
Author URI: http://jrtashjian.com
*/

/*  Copyright 2009  JR Tashjian  (email : jrtashjian@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function cache($url, $localfile)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	$data = curl_exec($ch);
	curl_close($ch);
	
	$file = fopen($localfile, "w");
	fwrite($file, $data);
	fclose($file);
}

function fetch_feed($url, $cache_min = 1)
{
	$name = parse_url($url);
	$name = $name['host'];
	$localfile = WP_PLUGIN_DIR . "/fetch-feed/cache/" . $name . ".xml";
	
	if( ! file_exists($localfile))
	{
		touch($localfile);
		chmod($localfile, 0666);
		cache($url, $localfile);
	}
	else if( ((time()-filemtime($localfile))/60) > $cache_min)
	{
		cache($url, $localfile);
	}
	
	return simplexml_load_file($localfile);
}
?>
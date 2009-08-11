<?php
/*
Plugin Name: Fetch Feed
Plugin URI: http://jrtashjian.com
Description: Fetches and Caches an RSS feed for display
Version: 1.5
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

function fetch_feed_cache($url, $cache_minutes = 1)
{
	$localfile = WP_PLUGIN_DIR . '/fetch-feed/cache/' . md5($url) . '.xml';
	
	if(( ! file_exists($localfile)) OR (file_exists($localfile) AND ((time() - filemtime($localfile)) / 60) > $cache_minutes) OR (file_exists($localfile) AND filesize($localfile) == 0))
	{
		// initialize curl resource
		$ch = curl_init();
		
		// set curl options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		
		// execute curl
		$response = curl_exec($ch);
		
		// cache the response
		$file = fopen($localfile, "w");
		fwrite($file, $response);
		fclose($file);
		
		// close curl resource
		curl_close($ch);
	}
	
	if(filesize($localfile) == 0) { return FALSE; }
	
	return simplexml_load_file($localfile);
}

/* End of file fetch-feed.php */
/* Location: ./wp-content/plugins/fetch-feed.php */
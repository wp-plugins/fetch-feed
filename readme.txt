=== Plugin Name ===
Contributors: JR Tashjian
Tags: rss, feeds, cache
Requires at least: 2.5
Tested up to: 2.8
Stable tag: 1.4

Fetches an RSS feed and returns RSS as array

== Description ==

This plugin was created to retrieve and cache an RSS feed for use in a template.

What you do is pass the url to the feed you would like returned and the number of minutes you would like the feed cached for. The 
plugin will cache the RSS xml and return the feed as an object which you can loop through and output however you please.

New As Of Version 1.4:
- Compatible with Wordpress 2.8
- Function name changed to fetch_feed_cache() instead of fetch_feed()


== Installation ==

1. Upload the `fetch-feed/` directory to the `/wp-content/plugins/` directory
2. Make sure the `fetch-feed/cache/` directory is writeable
3. Activate the plugin through the 'Plugins' menu in WordPress


== General Usage ==

fetch_feed_cache() is the only function you will be using with this plugin. fetch_feed_cache() accepts 2 parameters.

1. (string) $url		- This is the URL to the feed you would like to parse
2. (int)	$cache_min	- This is the amount of time in minutes you would like the feed cached for.


Here is an example of the plugin being used in a template:

`<?php $xml = fetch_feed_cache("http://jrtashjian.com/feed/", 60); ?>
<h3><?=$xml->channel->title?></h3>
<ul>
	<?php if( ! empty($xml)) : ?>
		<?php foreach($xml->channel->item as $item) : ?>
			<li><a href="<?=$item->link?>"><?=$item->title?></a></li>
		<?php endforeach; ?>
	<?php else : ?>
		<p>Delicious doesn't seem to be working at the moment...</p>
	<?php endif; ?>
</ul>`


Remeber, every feed could be different. If you need to see the structure of the object returned just use print_r().
Example: `<?php print_r(fetch_feed_cache("http://jrtashjian.com/feed/", 25)); ?>`
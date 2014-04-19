<?php
// Array of Elusive Icons 
// Contributed by @WhatJustHappened 
// Last updated: 14 Sept. 2013
function get_wpimagehover_socials(){
        $socials = array(
						'facebook' => __('Facebook', 'wpimagehover'),
						'twitter' => __('Twitter', 'wpimagehover'),
						'linkedin' => __('Linkedin', 'wpimagehover'),
						// 'instagram' => __('Instagram', 'wpimagehover'),
						'googleplus' => __('Google+', 'wpimagehover'),
						'pinterest' => __('Pinterest', 'wpimagehover'),
						'digg' => __('Digg', 'wpimagehover'),
						'delicious' => __('Delicious', 'wpimagehover'),
						// 'youtube' => __('Youtube', 'wpautbox'),
						// 'skype' => __('Skype', 'wpautbox'),
						// 'github' => __('Github', 'wpautbox'),
						// 'flickr' => __('Flickr', 'wpautbox'),
						// 'vimeo' => __('Vimeo', 'wpautbox'),
						// 'tumblr' => __('Tumblr', 'wpautbox'),
						// 'foursquare' => __('Foursquare', 'wpautbox'),
						// 'dribbble' => __('Dribbble', 'wpautbox'),
						'stumbleupon' => __('Stumbleupon', 'wpautbox'),
						// 'reddit' => __('Reddit', 'wpautbox'),
						// 'quora' => __('Quora', 'wpautbox'),
						// 'lastfm' => __('Lastfm', 'wpautbox'),
						// 'rdio' => __('Rdio', 'wpautbox'),
						// 'spotify' => __('Spotify', 'wpautbox'),
						// 'qq' => __('QQ', 'wpautbox'),
						// 'dropbox' => __('Dropbox', 'wpautbox'),
						// 'evernote' => __('Evernote', 'wpautbox'),
						// 'flattr' => __('Flattr', 'wpautbox'),
						// 'renren' => __('Renren', 'wpautbox'),
						// 'sina-weibo' => __('Sina Weibo', 'wpautbox'),
						// 'paypal' => __('Paypal', 'wpautbox'),
						// 'picasa' => __('Picasa', 'wpautbox'),
						// 'soundcloud' => __('Soundcloud', 'wpautbox'),
						// // 'mixi' => __('Mixi', 'wpautbox'),
						// 'behance' => __('Behance', 'wpautbox'),
						// 'google-circles' => __('Google Circles', 'wpautbox'),
						// // 'vk' => __('Vk', 'wpautbox'),
						// 'smashing' => __('Smashing Magazine', 'wpautbox'),
						// 'deviantart' => __('Deviantart', 'wpautbox'),
						// 'steam' => __('Steam', 'wpautbox'),
						// 'slideshare' => __('Slideshare', 'wpautbox'),
						// 'rss' => __('RSS', 'wpautbox'),
					);
        return $socials;
}
add_filter('wpimagehover/socials' , 'get_wpimagehover_socials');
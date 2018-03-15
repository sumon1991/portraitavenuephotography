<?php 
/*
**
** Functions for Napoli Plugins
**
*/

// functions  get data from twitter
function napoli_get_twitts( $page, $count_twitts = 3, $access_token, $access_token_secret, $consumer_key, $consumer_secret ) {

	if ( ! file_exists( EF_ROOT . '/includes/TwitterAPIExchange.php' ) ) {
		return false;
	}

	require_once EF_ROOT . '/includes/TwitterAPIExchange.php';

	$settings = array(
		'oauth_access_token' 		=> $access_token,
		'oauth_access_token_secret' => $access_token_secret,
		'consumer_key' 				=> $consumer_key,
		'consumer_secret' 			=> $consumer_secret
	);

	$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
	$requestMethod = 'GET';
	$getfield = '?screen_name=' . $page . '&count=' . $count_twitts . '&exclude_replies=true&skip_status=1';
	$twitter = new TwitterAPIExchange($settings);
	return $twitter->setGetfield($getfield)
		->buildOauth($url, $requestMethod)
		->performRequest();
}

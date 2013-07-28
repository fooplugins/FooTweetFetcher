<?php

//example_usage.php
//Example usage of FooTweetFetcher class

//we have some dependancies
require_once 'twitteroauth.php';
//require_once 'OAuth.php'; - twitteroauth includes OAuth.php

//include FooTweetFetcher
require_once 'FooTweetFetcher.php';

//Register a new appplication at http://dev.twitter.com/apps/new
//Below are fake twitter app details
$twitter_consumer_key = 'YUsyMo5NicXhE4v1WrxdPb';
$twitter_consumer_secret = 'GTFbRUwmzaQ81xLvhYkXfONCyEdSsIZoVDrqMn5g';
$twitter_access_key = '393392201-UnWGXxQYOwJsdaycrbIztpVlEq2kZMHvR64hKPoi';
$twitter_access_secret = 'PNquKXvpgYGcDRilrwFZtSHsUWjCOTeAJf28EM0oQ';

//create a new instance
$fetcher = new FooTweetFetcher($twitter_consumer_key, $twitter_consumer_secret, $twitter_access_key, $twitter_access_secret);
$args = array(
	'limit'            => 10,	 //get 10 tweets please
	'include_rts' 	   => false, //do not include retweets
	'exclude_replies'  => true	 //exclude replies
);

//get tweets (cached for 5 hours)
$tweets = fetcher->get_tweets( $meta["twitterUser"], $args );

if ( $tweets !== false && is_array( $tweets ) && (count( $tweets ) > 0) ) {
	//loop through each tweet
	foreach ( $tweets as $tweet ) {
		//convert all URLs, mentions, hashtags, media to clickable links
		$text = fetcher->make_clickable( $tweet );
		echo $text;
	}
}
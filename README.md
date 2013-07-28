FooTweetFetcher
===============

A class for WordPress to pull tweets from Twitter API v1.1

Features
--------
* Uses [Twitter API v1.1](https://dev.twitter.com/docs/api/1.1/get/statuses/user_timeline)
* Returns easy-to-use array of tweet objects.
* Tweets are cached in a WordPress transient for 5 hours (configurable).

Dependancies
------------
* FooTweetFetcher depends on [twitteroauth.php](https://github.com/abraham/twitteroauth)
* twitteroauth depends on [OAuth.php](http://oauth.net)

Example Usage
-------------
```php
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
	'limit'            => 10,	//get 10 tweets please
	'include_retweets' => 0,	//do not include retweets
	'exclude_replies'  => 1		//exclude replies
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
```
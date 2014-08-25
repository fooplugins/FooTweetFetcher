<?php

if ( !class_exists( 'FooTweetFetcher' ) ) {

	class FooTweetFetcher {

		//needed for Twitter OAuth V1.1
		protected $consumer_key;
		protected $consumer_secret;
		protected $access_key;
		protected $access_secret;

		protected $error = false;
		protected $transient_expires = 18000; // 5 hours

		function __construct($consumer_key, $consumer_secret, $access_key, $access_secret, $transient_expires = 18000) {
			global $WP_Twitter_API;

			$this->consumer_key      = $WP_Twitter_API->get_setting('consumer_key', 'string', $consumer_key );
			$this->consumer_secret   = $WP_Twitter_API->get_setting('consumer_secret', 'string', $consumer_secret );
			$this->access_key        = $WP_Twitter_API->get_setting('access_key', 'string', $access_key );
			$this->access_secret     = $WP_Twitter_API->get_setting('access_secret', 'string', $access_secret );
			$this->transient_expires = $WP_Twitter_API->get_setting('transient_expires', 'string', $transient_expires );

		}

		public function get_tweets($username, $args) {
			$transient_key = $username . '-tweets';

			if ( ($data = get_transient( $transient_key )) === false ) {
				//transient has expired - fetch fresh tweets
				$data = $this->get_tweets_from_api( $username, $args );

				if ( $data !== false ) {
					set_transient( $transient_key, $data, $this->transient_expires );
				}
			}

			return $data;
		}

		private function get_tweets_from_api($username, $args) {
			if ( !class_exists( 'TwitterOAuth' ) ) {
				//you need to reference the TwitterOAuth class for this to work
				$this->error = 'The TwitterOAuth class cannot be found. Please include twitteroauth.php!';

				return false;
			}

			$twitter_oauth = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $this->access_key, $this->access_secret);

			//setup params
			$params                = array();
			$params['screen_name'] = strip_tags( sanitize_user( $username ) );
			if ( array_key_exists('limit', $args) ) {
				$params['count'] = intval( $args['limit'] );
			}
			if ( array_key_exists('include_rts', $args) ) {
				$params['include_rts'] = $args['include_rts'];
			}
			if ( array_key_exists('exclude_replies', $args) ) {
				$params['exclude_replies'] = $args['exclude_replies'];
			}

			$response = $twitter_oauth->get( 'statuses/user_timeline', $params );

			if ( is_wp_error( $response ) ) {
				$this->error = $response->get_error_message();

				return false;
			} else if ( isset($response->errors) ) {
				$this->error = $response->errors;

				return false;
			} else {
				return $response;
			}
		}

		///found http://stackoverflow.com/questions/11533214/php-how-to-use-the-twitter-apis-data-to-convert-urls-mentions-and-hastags-in
		public function make_clickable($tweet) {
			$text = $tweet->text;
			$length = $this->safe_strlen( $text ); // Number of characters in plain tweet.

			if( function_exists( 'mb_substr' ) ) {
				for ( $i = 0; $i < $length; $i++ ) {
					$ch = mb_substr( $text, $i, 1 );
					if ($ch<>"\n") $char[]=$ch; else $char[]="\n<br/>";
				}
			} else {
				for ( $i = 0; $i < $length; $i++ ) {
					$ch = substr( $text, $i, 1 );
					if ($ch<>"\n") $char[]=$ch; else $char[]="\n<br/>";
				}
			}
			if ( isset($tweet->entities->user_mentions) ) {
				foreach ( $tweet->entities->user_mentions as $entity ) {
					$char[$entity->indices[0]] = '<a href="https://twitter.com/' . $entity->screen_name . '">' . $char[$entity->indices[0]];
					$char[$entity->indices[1] - 1] .= '</a>';
				}
			}
			if ( isset($tweet->entities->hashtags) ) {
				foreach ( $tweet->entities->hashtags as $entity ) {
					$char[$entity->indices[0]] = '<a href="https://twitter.com/search?q=%23' . $entity->text . '">' . $char[$entity->indices[0]];
					$char[$entity->indices[1] - 1] .= '</a>';
				}
			}
			if ( isset($tweet->entities->urls) ) {
				foreach ( $tweet->entities->urls as $entity ) {
					$char[$entity->indices[0]] = '<a href="' . $entity->expanded_url . '">' . $entity->display_url . '</a>';
					for ( $i = $entity->indices[0] + 1; $i < $entity->indices[1]; $i++ ) $char[$i] = '';
				}
			}
			if ( isset($tweet->entities->media) ) {
				foreach ( $tweet->entities->media as $entity ) {
					$char[$entity->indices[0]] = '<a href="' . $entity->expanded_url . '">' . $entity->display_url . '</a>';
					for ( $i = $entity->indices[0] + 1; $i < $entity->indices[1]; $i++ ) $char[$i] = '';
				}
			}

			return implode( '', $char ); // HTML tweet.
		}

		private function safe_strlen( $str ) {
			if( function_exists( 'mb_strlen' ) ) {
				return mb_strlen( $str );
			}
			return strlen( $str );
		}
	}
}
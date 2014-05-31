<?php
/*
 * Plugin Name: Twitter API
 * Description: Provides a plugin wrapper around the Twitter API for easy use by other plugins or themes
 * Author: FooPlugins/Philip John
 * Author URI: https://github.com/fooplugins</a>, <a href="http://philipjohn.me.uk">Philip John
 * License: GPLv2
 */

// Don't be a moron
defined('ABSPATH') or die("Naughty naughty");

// Require the SimpleSettings class seeing as we're extending that
// with our main plugin class
require_once 'inc/wordpress-simple-settings.php';

Class WP_Twitter_API extends WordPress_SimpleSettings {

	/**
	 * Constructor
	 */
	public function __construct() {

		// Make sure the FooTweetFetcher class is there and grab it.
		if ( file_exists( 'inc/class.FooTweetFetcher.php' ) )
			require_once 'inc/class.FooTweetFetcher.php';

		// Load up the SimpleSettings Class stuff
		parent::__construct();

		// Actions
		add_action('admin_menu', array($this, 'menu') );

		register_activation_hook(__FILE__, array($this, 'activate') );
	}

	function menu () {
		add_options_page("Twitter API", "Twitter API", 'manage_options', "twitter-api", array($this, 'admin_page') );
	}

	function admin_page () {
		include 'inc/twitter-api-admin.php';
	}

	function activate() {

		$this->add_setting('consumer_key');
		$this->add_setting('consumer_secret');
		$this->add_setting('access_key');
		$this->add_setting('access_secret');
		$this->add_setting('transient_expires', 3600);

	}

}
$WP_Twitter_API = new WP_Twitter_API();
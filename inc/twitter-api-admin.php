<?php
global $WP_Twitter_API; // we'll need this below
?>
<div class="wrap">
	<h2><?php _e('Twitter API Settings') ?></h2>

	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<?php $WP_Twitter_API->the_nonce(); ?>
		<table class="form-table">
			<tbody>
			<tr>
				<th scope="row" valign="top">
					<label for="<?php echo $WP_Twitter_API->get_field_name('consumer_key'); ?>"><?php _e('Consumer key'); ?></label>
				</th>
				<td>
					<input type="text"
						   id="<?php echo $WP_Twitter_API->get_field_name('consumer_key'); ?>"
						   name="<?php echo $WP_Twitter_API->get_field_name('consumer_key'); ?>"
						   value="<?php echo $WP_Twitter_API->get_setting('consumer_key'); ?>"
						   class="regular-text" />
				</td>
			</tr>
			<tr>
				<th scope="row" valign="top">
					<label for="<?php echo $WP_Twitter_API->get_field_name('consumer_secret'); ?>"><?php _e('Consumer secret'); ?></label>
				</th>
				<td>
					<input type="text"
						   id="<?php echo $WP_Twitter_API->get_field_name('consumer_secret'); ?>"
						   name="<?php echo $WP_Twitter_API->get_field_name('consumer_secret'); ?>"
						   value="<?php echo $WP_Twitter_API->get_setting('consumer_secret'); ?>"
						   class="regular-text" />
				</td>
			</tr>
			<tr>
				<th scope="row" valign="top">
					<label for="<?php echo $WP_Twitter_API->get_field_name('access_key'); ?>"><?php _e('Access key'); ?></label>
				</th>
				<td>
					<input type="text"
						   id="<?php echo $WP_Twitter_API->get_field_name('access_key'); ?>"
						   name="<?php echo $WP_Twitter_API->get_field_name('access_key'); ?>"
						   value="<?php echo $WP_Twitter_API->get_setting('access_key'); ?>"
						   class="regular-text" />
				</td>
			</tr>
			<tr>
				<th scope="row" valign="top">
					<label for="<?php echo $WP_Twitter_API->get_field_name('access_secret'); ?>"><?php _e('Access secret'); ?></label>
				</th>
				<td>
					<input type="text"
						   id="<?php echo $WP_Twitter_API->get_field_name('access_secret'); ?>"
						   name="<?php echo $WP_Twitter_API->get_field_name('access_secret'); ?>"
						   value="<?php echo $WP_Twitter_API->get_setting('access_secret'); ?>"
						   class="regular-text" />
				</td>
			</tr>
			<tr>
				<th scope="row" valign="top">
					<label for="<?php echo $WP_Twitter_API->get_field_name('transient_expires'); ?>"><?php _e('Cache expiry'); ?></label>
				</th>
				<td>
					<input type="text"
						   id="<?php echo $WP_Twitter_API->get_field_name('transient_expires'); ?>"
						   name="<?php echo $WP_Twitter_API->get_field_name('transient_expires'); ?>"
						   value="<?php echo $WP_Twitter_API->get_setting('transient_expires'); ?>"
						   class="regular-text" />
					<p class="description"><?php _e('The time, in seconds, that any Twitter data should be cached for. E.g. 1 hour = 3600 seconds'); ?></p>
				</td>
			</tr>
			</tbody>
		</table>
		<input class="button-primary" type="submit" value="<?php _e('Save Settings'); ?>" />
	</form>
</div>
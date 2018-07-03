<?php
/**
 *  Post icon setting in admin panel
 */
class Post_Icon_Setting 
{

	function __construct() 
	{

		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'settings_scripts' ) );

	}

	function admin_menu () 
	{

		add_options_page( 'Post icon','Post icon','manage_options','post-icon-options', array( $this, 'settings_page' ) );

	}

	function settings_scripts ()
	{

		wp_enqueue_style( 'settings-style', plugins_url( 'css/settings-style.css', __FILE__ ) );

		wp_enqueue_script( 'settings-scripts', plugins_url( 'js/scripts.js', __FILE__ ) );

	}

	function settings_page () 
	{ 

		global $post;

		$dashicons = Dash_Icons::getList();

		$current_icons = get_option('dashicons-cpt'); 

		$args = array( 'posts_per_page' => -1, 'post_status' => 'publish' );

		$posts = get_posts( $args ); ?>

		<div class="wrap">
			
			<h2>Post icon settings</h2>

			<form id="configuration_form" method="post" action="options.php">

				<?php wp_nonce_field('update-options'); ?>

				<table class="form-table">
					
					<tr valign="top">
						<th scope="row">Enable/Disable plugin</th>
						<td>
							<label for="enable_plagin">
								<input type="checkbox" name="enable_plagin" value="1" <?php checked(1, get_option('enable_plagin'), true); ?> />
								<span>Enable</span>
							</label>
							<p class="description">Check to enable the plugin, uncheck to disable the plugin</p>
						 </td>
					</tr>

					<tr valign="top">
						<th scope="row">Where do you want your icon to show?</th>
						<td>
							<label class="icon_position">
								<input type="radio" name="icon_position" value="before" <?php checked('before', get_option('icon_position'), true); ?>/>
								<span>Before post title</span>
							</label>

							<label class="icon_position">
								<input type="radio" name="icon_position" value="after" <?php checked('after', get_option('icon_position'), true); ?>/>
								<span>After post title</span>
							</label>

						 </td>
					</tr>

				</table>
				<input type="hidden" name="selected_icon" id="selected_icon" value="<?php echo get_option('selected_icon') ?>">

				<p class="pi_title">Select icon</p>

				<div class="dashicons-set postbox">
				<?php foreach( $dashicons as $before_content => $dashicon ) : 

					if ($dashicon == get_option('selected_icon')) {
							
						$selected_class =  "selected";

					} else{

						$selected_class =  "";

					} ?>
					<div class="dashicons <?php echo $selected_class; ?> dashicons-<?php echo $dashicon; ?>" data-before="<?php echo $dashicon; ?>" ></div>
				<?php endforeach; ?>
				</div>

				<p class="pi_title">Select posts</p>
				<div class="postbox posts-list">
				<?php if ($posts) {

					foreach ($posts as $post ) { 
						setup_postdata( $post ); 
						$post_id = $post->ID;
						$checked = in_array($post_id, get_option('checked_posts'));
						?>
						<label>
							<input type="checkbox" name="checked_posts[]" value="<?php echo $post_id ?>" <?php checked( $checked ); ?>>
							<span><?php echo $post->post_title ?></span>
						</label>

					<?php }
					wp_reset_postdata();
				} ?>
					
				</div>

				<input type="hidden" name="action" value="update" />
				<input type="hidden" name="page_options" value="enable_plagin, icon_position, selected_icon, checked_posts" />

				<p class="submit">
					<input type="submit" class="button-primary" value="Save Options"/>
				</p>

			</form>

		</div>

	<?php } 

}

new Post_Icon_Setting;

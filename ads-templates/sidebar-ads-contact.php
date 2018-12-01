<?php 
/**
 *
 * The template used for displaying ad sidebar
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
	global $post;
	$social = array();
	$social_links = apply_filters('listingo_get_social_media_icons_list',array());
	$address = '';
	$phone = '';
	$fax = '';
	$email = '';
	$website = '';
	if (function_exists('fw_get_db_post_option')) {		
		$address = fw_get_db_post_option($post->ID, 'address', true);
		$phone = fw_get_db_post_option($post->ID, 'phone', true);
		$fax = fw_get_db_post_option($post->ID, 'fax', true);
		$email = fw_get_db_post_option($post->ID, 'email', true);
		$website = fw_get_db_post_option($post->ID, 'website', true);
	}
	if( !empty( $social_links ) ) {
		foreach ($social_links as $key => $value) {
			if (function_exists('fw_get_db_post_option')) {
				$social_data = fw_get_db_post_option($post->ID, $key);
				$social[$key] = $social_data;		
			}
		}
	}
	$social_exist = '';
	if( !empty( $social ) ) {
		foreach ($social as $key => $value) {
			if( !empty( $value) ){
				$social_exist = 'exist';
				break;
			}
		}
	}
	if( !empty( $address ) || !empty( $social[0] ) ) {	
?>
<div class="tg-widget tg-widgetvtwo">
	<?php if( !empty( $address ) ){?>		
		<div id="tg-locationmapvtwo" class="tg-locationmapvtwo"></div>
		<?php			
			wp_enqueue_script('gmap3');
			wp_enqueue_script('listingo_maps');
			$map_script ='jQuery("#tg-locationmapvtwo").gmap3({
				marker: {
					address: "'.$address.'",
					options: {
						title: "'.$address.'",
						icon: "'.get_template_directory_uri().'/images/markerseven.png",
					}
				},
				map: {
					options: {
						zoom: 20,
						scrollwheel: false,
						disableDoubleClickZoom: true,
					}
				}
			});';
			wp_add_inline_script('listingo_maps', $map_script, 'after');
		?>
    <?php }?>
	<div class="tg-contactinfoboxvtwo">
		<?php 
			if( !empty( $address ) 
				|| !empty( $phone ) 
				|| !empty( $fax ) 
				|| !empty( $email ) 
				|| !empty( $website ) ) { ?>
		<ul class="tg-contactinfo">
			<?php if( !empty( $address ) ) { ?>
				<li>
					<i class="lnr lnr-location"></i>
					<address><?php echo esc_attr( $address ); ?></address>
				</li>
			<?php } ?>
			<?php if( !empty( $phone ) ) { ?>
				<li>
					<i class="lnr lnr-phone-handset"></i>
					<span><?php echo esc_attr( $phone ); ?></span>
				</li>
			<?php } ?>
			<?php if( !empty( $fax ) ) { ?>
				<li>
					<i class="lnr lnr-printer"></i>
					<span><?php echo esc_attr( $fax ); ?></span>
				</li>
			<?php } ?>
			<?php if( !empty( $email ) ) { ?>
				<li>
					<i class="lnr lnr-envelope"></i>
					<span><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_attr( $email ); ?></a></span>
				</li>
			<?php } ?>
			<?php if( !empty( $website ) ) { ?>	
				<li>
					<i class="lnr lnr-screen"></i>
					<span>
					<a href="<?php echo esc_url( $website ); ?>" target="_blank"><?php echo esc_attr( $website ); ?></a></span>
				</li>
			<?php } ?>
		</ul>
		<?php } ?>
		<?php if( !empty( $social )  && !empty( $social_exist ) ) { ?>
			<div class="tg-socialiconsbox">
				<span class="tg-getsocial"><i class="lnr lnr-sync"></i>&nbsp;<?php esc_html_e('Get Social', 'listingo'); ?></span>
				<ul class="tg-socialicons tg-socialiconssilmple">
					<?php
					foreach ( $social as $key => $value ) { 
					if( !empty( $value ) ) {
						if( $value == 'googleplus'){
							$value = 'google-plus';
						}
					 ?>							
					<li class="tg-<?php echo esc_attr( $key ); ?>"><a href="<?php echo esc_attr( $value ); ?>"><i class="fa fa-<?php echo esc_attr( $key ); ?>"></i></a>
					</li>
				<?php } } ?>	
				</ul>
			</div>
		<?php } ?>
	</div>
</div>
<?php } 
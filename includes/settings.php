<?php
/**
 * Instellingenpagina onder het menu "Vacancies".
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function mkv_register_settings_page() {
	add_submenu_page(
		'edit.php?post_type=vacature',
		__( 'MF Job Board — Settings', 'mf-job-board' ),
		__( 'Settings', 'mf-job-board' ),
		'manage_options',
		'mkv-settings',
		'mkv_render_settings_page'
	);
}
add_action( 'admin_menu', 'mkv_register_settings_page' );

function mkv_register_settings() {
	register_setting( 'mkv_settings', 'mkv_listing_page_id', array( 'sanitize_callback' => 'absint', 'default' => 0 ) );
	register_setting( 'mkv_settings', 'mkv_apply_email_opt', array( 'sanitize_callback' => 'sanitize_email', 'default' => '' ) );
	register_setting( 'mkv_settings', 'mkv_accent_color', array( 'sanitize_callback' => 'mkv_sanitize_hex_color', 'default' => '' ) );
	register_setting( 'mkv_settings', 'mkv_cta_color', array( 'sanitize_callback' => 'mkv_sanitize_hex_color', 'default' => '' ) );
}
add_action( 'admin_init', 'mkv_register_settings' );

/** Color picker alleen op de instellingenpagina laden. */
function mkv_settings_admin_assets( $hook ) {
	if ( 'vacature_page_mkv-settings' !== $hook ) {
		return;
	}
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_add_inline_script( 'wp-color-picker', 'jQuery(function($){$(".mkv-color-field").wpColorPicker();});' );
}
add_action( 'admin_enqueue_scripts', 'mkv_settings_admin_assets' );

function mkv_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$listing_id = (int) get_option( 'mkv_listing_page_id' );
	$email      = get_option( 'mkv_apply_email_opt' );
	$accent     = get_option( 'mkv_accent_color' );
	$cta        = get_option( 'mkv_cta_color' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'MF Job Board — Settings', 'mf-job-board' ); ?></h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'mkv_settings' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="mkv_listing_page_id"><?php esc_html_e( 'Listing page', 'mf-job-board' ); ?></label></th>
					<td>
						<?php
						wp_dropdown_pages(
							array(
								'name'              => 'mkv_listing_page_id',
								'id'                => 'mkv_listing_page_id',
								'selected'          => $listing_id,
								'show_option_none'  => __( '— Detect automatically —', 'mf-job-board' ),
								'option_none_value' => 0,
							)
						);
						?>
						<p class="description"><?php esc_html_e( 'The page that contains the [mk_vacatures] shortcode. "Back to all vacancies" on the detail page points here, and any archive URLs are redirected here. Leave on "Detect automatically" to let the plugin find it.', 'mf-job-board' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="mkv_apply_email_opt"><?php esc_html_e( 'Application email address', 'mf-job-board' ); ?></label></th>
					<td>
						<input type="email" name="mkv_apply_email_opt" id="mkv_apply_email_opt" class="regular-text" value="<?php echo esc_attr( $email ); ?>" placeholder="<?php echo esc_attr( MKV_APPLY_EMAIL ); ?>" />
						<p class="description">
							<?php
							/* translators: %s is the default email address. */
							printf( esc_html__( 'Leave empty to use the default (%s).', 'mf-job-board' ), esc_html( MKV_APPLY_EMAIL ) );
							?>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="mkv_accent_color"><?php esc_html_e( 'Accent color', 'mf-job-board' ); ?></label></th>
					<td>
						<input type="text" name="mkv_accent_color" id="mkv_accent_color" class="mkv-color-field" value="<?php echo esc_attr( $accent ); ?>" data-default-color="<?php echo esc_attr( MKV_DEFAULT_ACCENT ); ?>" placeholder="<?php echo esc_attr( MKV_DEFAULT_ACCENT ); ?>" />
						<p class="description"><?php esc_html_e( 'Dominant color: heading rule, bullets, arrow icons and links on the list page. Leave empty for the default.', 'mf-job-board' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="mkv_cta_color"><?php esc_html_e( 'CTA button color', 'mf-job-board' ); ?></label></th>
					<td>
						<input type="text" name="mkv_cta_color" id="mkv_cta_color" class="mkv-color-field" value="<?php echo esc_attr( $cta ); ?>" data-default-color="<?php echo esc_attr( MKV_DEFAULT_CTA ); ?>" placeholder="<?php echo esc_attr( MKV_DEFAULT_CTA ); ?>" />
						<p class="description"><?php esc_html_e( 'Color of the apply / open-application buttons (Solliciteer / Open sollicitatie). Leave empty for the default.', 'mf-job-board' ); ?></p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
